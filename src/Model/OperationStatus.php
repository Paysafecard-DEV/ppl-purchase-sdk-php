<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 *
 * This class is based on the Paysafe Pay Later OpenAPI specification, version 1.0.0.
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Model;

use InvalidArgumentException;

use function array_key_exists;
use function sprintf;

/**
 * Status of the operation.
 */
class OperationStatus implements Enum
{
    public const OK = 'OK';
    public const NOK = 'NOK';
    public const ERROR = 'ERROR';
    public const PENDING = 'PENDING';
    public const UNKNOWN = 'UNKNOWN';

    public const ALLOWED_TYPES = [
        'OK' => self::OK,
        'NOK' => self::NOK,
        'ERROR' => self::ERROR,
        'PENDING' => self::PENDING,
        'UNKNOWN' => self::UNKNOWN,
    ];

    /**
     * @var string
     */
    private $value;

    /**
      * @param string $value
      * @throws InvalidArgumentException
      */
    public function __construct(string $value)
    {
        if (!array_key_exists($value, self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException(sprintf('Unexpected value "%s"', $value));
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
