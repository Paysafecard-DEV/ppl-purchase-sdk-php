<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

use DateTime;
use Paysafe\PayLater\Exception\BuilderException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use stdClass;

use function array_key_exists;
use function count;
use function get_class;
use function is_array;
use function is_object;
use function json_encode;
use function lcfirst;
use function method_exists;
use function sprintf;
use function strpos;
use function substr;

class RequestBuilder
{
    /**
     * @param object|null $object
     * @return string
     * @throws BuilderException
     */
    public static function toJson(?object $object): string
    {
        if ($object === null) {
            return (string) json_encode(new stdClass());
        }
        return (string) json_encode(self::reflectObject($object));
    }

    /**
     * @param object|null $object
     * @return array<string, string|array>
     * @throws BuilderException
     */
    public static function toArray(?object $object): array
    {
        if ($object === null) {
            return [];
        }
        return self::reflectObject($object);
    }

    /**
     * @param object $object
     * @return array<string, string|array>
     * @throws BuilderException
     */
    private static function reflectObject(object $object): array
    {
        $result = [];
        try {
            $reflection = new ReflectionClass($object);
        } catch (ReflectionException $e) {
            throw new BuilderException(sprintf('Class %s does not exist', get_class($object)));
        }

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (strpos($method->getName(), 'get') === 0) {
                $key = lcfirst(substr($method->getName(), 3));
                $value = self::getValueForMethod($object, $method->getName());
                if ($value !== null) {
                    $result[$key] = (is_array($value) && count($value) === 1 && array_key_exists('value', $value)) ?
                        $result[$key] = $value['value'] :
                        $result[$key] = $value;
                }
            }
        }

        return $result;
    }

    /**
     * @param object $object
     * @param string $method
     * @return mixed|null
     * @throws BuilderException
     */
    private static function getValueForMethod(object $object, string $method)
    {
        if (method_exists($object, $method)) {
            return self::resolveValue($object->$method());
        }
        return null;
    }

    /**
     * @param mixed|null $value
     * @return mixed|null
     * @throws BuilderException
     */
    private static function resolveValue($value)
    {
        if ($value instanceof DateTime) {
            return $value->format('c');
        }

        if (is_object($value)) {
            $value = self::reflectObject($value);
        }

        if (is_array($value)) {
            $newValue = [];
            foreach ($value as $index => $originalValue) {
                $newValue[$index] = self::resolveValue($originalValue);
            }
            $value = $newValue;
        }

        if ($value !== '' && $value !== null) {
            if ($value === []) {
                $value = new stdClass();
            }
            return $value;
        }

        return null;
    }
}
