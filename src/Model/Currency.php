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

class Currency implements Enum
{
    public const EUR = 'EUR';
    public const CHF = 'CHF';
    public const USD = 'USD';
    public const CAD = 'CAD';
    public const GBP = 'GBP';

    public const ALLOWED_TYPES = [
        'EUR' => self::EUR,
        'CHF' => self::CHF,
        'USD' => self::USD,
        'CAD' => self::CAD,
        'GBP' => self::GBP,
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
