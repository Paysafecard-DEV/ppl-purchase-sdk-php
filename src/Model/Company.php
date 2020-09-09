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

/**
 * Representation of a company.
 */
class Company
{
    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var string|null
     */
    private $companyName;

    /**
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $companyName
     */
    public function __construct(
        string $firstName = null,
        string $lastName = null,
        string $companyName = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->companyName = $companyName;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Company
     */
    public function setFirstName(string $firstName): Company
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Company
     */
    public function setLastName(string $lastName): Company
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return Company
     */
    public function setCompanyName(string $companyName): Company
    {
        $this->companyName = $companyName;
        return $this;
    }
}
