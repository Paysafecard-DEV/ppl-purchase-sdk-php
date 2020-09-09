<?php

declare(strict_types=1);

namespace Paysafe\PayLater\Model;

use InvalidArgumentException;

interface Enum
{
    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value);

    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @return string
     */
    public function __toString(): string;
}
