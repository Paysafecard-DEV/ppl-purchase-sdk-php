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

class RefundReason implements Enum
{
    public const CUSTOMER_REFUND = 'CUSTOMER_REFUND';
    public const MERCHANT_TECHNICAL_PROBLEM = 'MERCHANT_TECHNICAL_PROBLEM';
    public const REFUND_OBLIGINGNESS = 'REFUND_OBLIGINGNESS';
    public const MERCHANT_CAN_NOT_DELIVER_GOODS = 'MERCHANT_CAN_NOT_DELIVER_GOODS';

    public const ALLOWED_TYPES = [
        'CUSTOMER_REFUND' => self::CUSTOMER_REFUND,
        'MERCHANT_TECHNICAL_PROBLEM' => self::MERCHANT_TECHNICAL_PROBLEM,
        'REFUND_OBLIGINGNESS' => self::REFUND_OBLIGINGNESS,
        'MERCHANT_CAN_NOT_DELIVER_GOODS' => self::MERCHANT_CAN_NOT_DELIVER_GOODS,
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
