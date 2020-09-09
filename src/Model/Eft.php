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

class Eft
{
    /**
     * @var string|null
     */
    private $accountNumber;

    /**
     * @var string|null
     */
    private $transitNumber;

    /**
     * @var string|null
     */
    private $institutionId;

    /**
     * @param string|null $accountNumber
     * @param string|null $transitNumber
     * @param string|null $institutionId
     */
    public function __construct(
        string $accountNumber = null,
        string $transitNumber = null,
        string $institutionId = null
    ) {
        $this->accountNumber = $accountNumber;
        $this->transitNumber = $transitNumber;
        $this->institutionId = $institutionId;
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
     * @return Eft
     */
    public function setAccountNumber(string $accountNumber): Eft
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTransitNumber(): ?string
    {
        return $this->transitNumber;
    }

    /**
     * @param string $transitNumber
     * @return Eft
     */
    public function setTransitNumber(string $transitNumber): Eft
    {
        $this->transitNumber = $transitNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInstitutionId(): ?string
    {
        return $this->institutionId;
    }

    /**
     * @param string $institutionId
     * @return Eft
     */
    public function setInstitutionId(string $institutionId): Eft
    {
        $this->institutionId = $institutionId;
        return $this;
    }
}
