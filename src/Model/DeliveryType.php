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

class DeliveryType implements Enum
{
    public const BILLING_ADDRESS = 'BILLING_ADDRESS';
    public const ALTERNATIVE_DELIVERY_ADDRESS = 'ALTERNATIVE_DELIVERY_ADDRESS';
    public const SHOP_PICKUP = 'SHOP_PICKUP';
    public const POST_OFFICE_PICKUP = 'POST_OFFICE_PICKUP';

    public const ALLOWED_TYPES = [
        'BILLING_ADDRESS' => self::BILLING_ADDRESS,
        'ALTERNATIVE_DELIVERY_ADDRESS' => self::ALTERNATIVE_DELIVERY_ADDRESS,
        'SHOP_PICKUP' => self::SHOP_PICKUP,
        'POST_OFFICE_PICKUP' => self::POST_OFFICE_PICKUP,
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
