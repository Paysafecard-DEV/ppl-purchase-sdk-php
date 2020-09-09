<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

use DateTime;
use Exception;
use Paysafe\PayLater\Exception\BuilderException;
use Paysafe\PayLater\Model\Enum;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use ReflectionType;

use function array_filter;
use function array_key_exists;
use function array_keys;
use function array_merge;
use function class_exists;
use function count;
use function file_get_contents;
use function in_array;
use function is_array;
use function is_callable;
use function method_exists;
use function preg_match;
use function preg_quote;
use function preg_replace;
use function sprintf;

class ResponseBuilder
{
    /**
     * @var array<string, mixed>
     */
    private static $parameters;

    /**
     * @param string $targetObject
     * @param array<string, mixed> $jsonData
     * @param array<string, mixed> $parameters
     * @return Response
     * @throws BuilderException
     */
    public static function build(
        string $targetObject,
        array $jsonData,
        array $parameters = []
    ): Response {
        self::$parameters = $parameters;
        if (!class_exists($targetObject)) {
            throw new BuilderException(sprintf('Class %s does not exist', $targetObject));
        }

        try {
            $reflection = new ReflectionClass($targetObject);
        } catch (ReflectionException $exception) {
            throw new BuilderException(
                sprintf('Class %s does not exist', $targetObject),
                $exception->getCode(),
                $exception
            );
        }

        if (!$reflection->implementsInterface(Response::class)) {
            throw new BuilderException(sprintf('Class %s does not implement the Response interface', $targetObject));
        }

        $constructorData = array_merge(self::reflectConstructor($reflection, $jsonData));
        return self::createObject($targetObject, $constructorData);
    }

    /**
     * @param ReflectionClass<object> $reflection
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private static function reflectConstructor(ReflectionClass $reflection, array $data): array
    {
        $result = [];
        $constructor = $reflection->getConstructor();
        if ($constructor === null) {
            return $result;
        }

        foreach ($constructor->getParameters() as $parameter) {
            if (array_key_exists($parameter->getName(), $data)) {
                $value = $data[$parameter->getName()];
                $result[$parameter->getName()] = $value;
            }
        }
        return $result;
    }

    /**
     * @param string $type
     * @param array<string, mixed> $arguments
     * @return mixed
     * @throws BuilderException
     */
    private static function createObject(string $type, array $arguments)
    {
        $constructorArguments = [];
        if (!class_exists($type)) {
            throw new BuilderException(sprintf('Class %s does not exist', $type));
        }

        try {
            $reflectedClass = new ReflectionClass($type);
        } catch (ReflectionException $exception) {
            throw new BuilderException(
                sprintf('Class %s does not exist', $type),
                $exception->getCode(),
                $exception
            );
        }

        $constructor = $reflectedClass->getConstructor();
        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $parameter) {
                $constructorArguments[] = self::getValueForParameter($parameter, $arguments, $type);
            }
        }

        return new $type(...$constructorArguments);
    }

    /**
     * @param ReflectionParameter $parameter
     * @return string
     * @throws BuilderException
     */
    private static function getType(ReflectionParameter $parameter): string
    {
        foreach (self::$parameters as $parameterName => $callback) {
            if (is_callable($callback) && $parameterName === $parameter->getName()) {
                return $callback($parameter);
            }
        }

        $type = 'null';
        $reflectionType = $parameter->getType();
        if ($reflectionType instanceof ReflectionType) {
            $type = method_exists($reflectionType, 'getName') ?
                $reflectionType->getName() :
                (string) $reflectionType;
        }

        if ($type === 'array') {
            return self::resolveTypeFromArray($parameter);
        }

        return $type;
    }

    /**
     * @param ReflectionParameter $parameter
     * @param array<string, mixed> $arguments
     * @param string $type
     * @return mixed|null
     * @throws BuilderException
     */
    private static function getValueForParameter(ReflectionParameter $parameter, array $arguments, string $type)
    {
        if (array_key_exists($parameter->getName(), $arguments)) {
            $value = $arguments[$parameter->getName()];
            if ($value === []) {
                $value = null;
            }
            $parameterType = self::getType($parameter);
            $value = self::resolveValue($value, $parameterType, $parameter);
        } else {
            if (!$parameter->isOptional()) {
                throw new BuilderException(
                    sprintf(
                        'Required property "%s" is missing from arguments for class "%s"',
                        $parameter->getName(),
                        $type
                    )
                );
            }
            try {
                $value = $parameter->getDefaultValue();
            } catch (ReflectionException $exception) {
                throw new BuilderException(
                    sprintf('Parameter %s is not optional', $parameter->getName()),
                    $exception->getCode(),
                    $exception
                );
            }
        }

        return $value;
    }

    /**
     * @param array<string, mixed> $array
     * @return bool
     */
    private static function isAssociatedArray(array $array): bool
    {
        return $array === [] ?
            false :
            count(array_filter(array_keys($array), 'is_string')) > 0;
    }

    /**
     * @param string $parameterType
     * @param mixed $value
     * @return mixed
     * @throws BuilderException
     */
    private static function handleDataTypes(string $parameterType, $value)
    {
        switch ($parameterType) {
            case 'DateTime':
                try {
                    return new DateTime($value);
                } catch (Exception $e) {
                    throw new BuilderException(sprintf('Cannot convert value %s to a DateTime object', $value));
                }
        }

        if (!is_array($value) && class_exists($parameterType)) {
            try {
                $reflection = new ReflectionClass($parameterType);
            } catch (ReflectionException $exception) {
                throw new BuilderException(
                    sprintf('Class %s does not exist', $parameterType),
                    $exception->getCode(),
                    $exception
                );
            }
            if ($reflection->implementsInterface(Enum::class)) {
                return new $parameterType($value);
            }
        }

        return $value;
    }

    // phpcs:disable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff
    // phpcs:disable ObjectCalisthenics.Metrics.MaxNestingLevel.ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff

    /**
     * @param mixed $value
     * @param string $parameterType
     * @param ReflectionParameter $parameter
     * @return array|mixed
     * @throws BuilderException
     */
    private static function resolveValue($value, string $parameterType, ReflectionParameter $parameter)
    {
        if ($value === null && $parameter->isDefaultValueAvailable()) {
            try {
                return $parameter->getDefaultValue();
            } catch (ReflectionException $exception) {
                throw new BuilderException(
                    sprintf('Parameter %s is not optional', $parameter->getName()),
                    $exception->getCode(),
                    $exception
                );
            }
        }

        if (is_array($value) && $parameterType !== 'array') {
            if (self::isAssociatedArray($value)) {
                $value = self::createObject($parameterType, $value);
            } elseif (class_exists($parameterType)) {
                try {
                    $reflection = new ReflectionClass($parameterType);
                } catch (ReflectionException $exception) {
                    throw new BuilderException(
                        sprintf('Class %s does not exist', $parameterType),
                        $exception->getCode(),
                        $exception
                    );
                }
                $newValue = [];
                if ($reflection->implementsInterface(Enum::class)) {
                    foreach ($value as $singleValue) {
                        $newValue[] = new $parameterType($singleValue);
                    }
                } else {
                    foreach ($value as $singleValue) {
                        $newValue[] = self::createObject($parameterType, $singleValue);
                    }
                }
                $value = $newValue;
            }
        }

        $value = self::handleDataTypes($parameterType, $value);
        return $value;
    }

    // phpcs:enable ObjectCalisthenics.Metrics.MaxNestingLevel.ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff
    // phpcs:enable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff

    /**
     * @param ReflectionParameter $parameter
     * @return mixed|string
     * @throws BuilderException
     */
    private static function resolveTypeFromArray(ReflectionParameter $parameter)
    {
        $docComment = $parameter->getDeclaringFunction()->getDocComment();
        if ($docComment === false) {
            throw new BuilderException(
                sprintf('parameters defined as array must have a docblock: %1$s', $parameter->getName())
            );
        }

        $regex = sprintf('/@param (?P<parameterType>.*?)(\|null)? \$%s/', preg_quote($parameter->getName(), '/'));
        if (preg_match($regex, $docComment, $matches) !== 1) {
            throw new BuilderException(
                sprintf('incorrect or missing @param in docblock for: %1$s', $parameter->getName())
            );
        }

        if (preg_match('/\[]$/', $matches['parameterType']) === 1) {
            $parameterType = (string) preg_replace('/\[]$/', '', $matches['parameterType']);
            if (!in_array($parameterType, ['int', 'string', 'bool', 'float'], true)) {
                $declaringClass = $parameter->getDeclaringClass();
                if ($declaringClass === null) {
                    throw new BuilderException('Cannot get declaring class for parameter: ' . $parameter->getName());
                }
                return self::resolveClassName($parameterType, $declaringClass);
            }
        }

        return 'array';
    }

    /**
     * @param string $baseClassName
     * @param ReflectionClass<object> $declaringClass
     * @return string
     * @throws BuilderException
     */
    private static function resolveClassName(string $baseClassName, ReflectionClass $declaringClass): string
    {
        // Check if the class exists in the use statements of the reflected class:
        $fileName = $declaringClass->getFileName();
        if ($fileName === false) {
            throw new BuilderException(sprintf('Class %s does not have a file', $declaringClass->getName()));
        }

        $fileContent = file_get_contents($fileName);
        if ($fileContent === false) {
            throw new BuilderException(sprintf('Class file %s cannot be read', $fileName));
        }

        $regex = sprintf('/^use (?P<className>.*\\\\%s);$/m', preg_quote($baseClassName, '/'));
        if (preg_match($regex, $fileContent, $matches) === 1) {
            return $matches['className'];
        }

        // Check if the class exists in the namespace of the reflected class:
        $className = $declaringClass->getNamespaceName() . '\\' . $baseClassName;
        if (class_exists($className)) {
            return $className;
        }

        // Check if it exists in general:
        $className = $baseClassName;
        if (class_exists($className)) {
            return $className;
        }

        throw new BuilderException(sprintf('Class %s does not exist', $className));
    }
}
