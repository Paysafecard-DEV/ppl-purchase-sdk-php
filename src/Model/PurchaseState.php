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

class PurchaseState implements Enum
{
    public const INITIALIZED = 'INITIALIZED';
    public const PRECHECKED = 'PRECHECKED';
    public const DECLINED = 'DECLINED';
    public const AUTHORIZED = 'AUTHORIZED';
    public const AUTHORIZATION_PENDING = 'AUTHORIZATION_PENDING';
    public const CANCELLED = 'CANCELLED';
    public const FULFILLMENT = 'FULFILLMENT';
    public const BLOCKED = 'BLOCKED';
    public const TIMED_OUT = 'TIMED_OUT';
    public const CLOSED = 'CLOSED';

    public const ALLOWED_TYPES = [
        'INITIALIZED' => self::INITIALIZED,
        'PRECHECKED' => self::PRECHECKED,
        'DECLINED' => self::DECLINED,
        'AUTHORIZED' => self::AUTHORIZED,
        'AUTHORIZATION_PENDING' => self::AUTHORIZATION_PENDING,
        'CANCELLED' => self::CANCELLED,
        'FULFILLMENT' => self::FULFILLMENT,
        'BLOCKED' => self::BLOCKED,
        'TIMED_OUT' => self::TIMED_OUT,
        'CLOSED' => self::CLOSED,
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
