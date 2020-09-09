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

class ProductType implements Enum
{
    public const INVOICE = 'INVOICE';
    public const INSTALLMENT = 'INSTALLMENT';
    public const MONTHLY_INVOICE = 'MONTHLY_INVOICE';

    public const ALLOWED_TYPES = [
        'INVOICE' => self::INVOICE,
        'INSTALLMENT' => self::INSTALLMENT,
        'MONTHLY_INVOICE' => self::MONTHLY_INVOICE,
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
