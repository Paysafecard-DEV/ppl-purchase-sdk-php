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

class Ach
{
    /**
     * @var string|null
     */
    private $accountNumber;

    /**
     * @var AchAccountType|null
     */
    private $accountType;

    /**
     * @var string|null
     */
    private $routingNumber;

    /**
     * @param string|null $accountNumber
     * @param AchAccountType|null $accountType
     * @param string|null $routingNumber
     */
    public function __construct(
        string $accountNumber = null,
        AchAccountType $accountType = null,
        string $routingNumber = null
    ) {
        $this->accountNumber = $accountNumber;
        $this->accountType = $accountType;
        $this->routingNumber = $routingNumber;
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
     * @return Ach
     */
    public function setAccountNumber(string $accountNumber): Ach
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @return AchAccountType|null
     */
    public function getAccountType(): ?AchAccountType
    {
        return $this->accountType;
    }

    /**
     * @param AchAccountType $accountType
     * @return Ach
     */
    public function setAccountType(AchAccountType $accountType): Ach
    {
        $this->accountType = $accountType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoutingNumber(): ?string
    {
        return $this->routingNumber;
    }

    /**
     * @param string $routingNumber
     * @return Ach
     */
    public function setRoutingNumber(string $routingNumber): Ach
    {
        $this->routingNumber = $routingNumber;
        return $this;
    }
}
