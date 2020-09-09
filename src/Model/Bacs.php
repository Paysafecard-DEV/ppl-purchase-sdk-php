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

// phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
// phpcs:disable ObjectCalisthenics.Metrics.PropertyPerClassLimit

class Bacs
{
    /**
     * @var string|null
     */
    private $accountNumber;

    /**
     * @var string|null
     */
    private $sortCode;

    /**
     * @param string|null $accountNumber
     * @param string|null $sortCode
     */
    public function __construct(
        string $accountNumber = null,
        string $sortCode = null
    ) {
        $this->accountNumber = $accountNumber;
        $this->sortCode = $sortCode;
    }

    /**
     * @return string|null
     */
    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    /**
     * @param string $accountNumber
     * @return Bacs
     */
    public function setAccountNumber(string $accountNumber): Bacs
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSortCode(): ?string
    {
        return $this->sortCode;
    }

    /**
     * @param string $sortCode
     * @return Bacs
     */
    public function setSortCode(string $sortCode): Bacs
    {
        $this->sortCode = $sortCode;
        return $this;
    }
}
