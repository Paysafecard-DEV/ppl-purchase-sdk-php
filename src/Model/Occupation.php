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
 * Occupation of a person.
 */
class Occupation
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $yearlyGrossSalary;

    /**
     * @var string|null
     */
    private $employersName;

    /**
     * @var Address|null
     */
    private $employersAddress;

    /**
     * @param string|null $name
     * @param string|null $yearlyGrossSalary
     * @param string|null $employersName
     * @param Address|null $employersAddress
     */
    public function __construct(
        string $name = null,
        string $yearlyGrossSalary = null,
        string $employersName = null,
        Address $employersAddress = null
    ) {
        $this->name = $name;
        $this->yearlyGrossSalary = $yearlyGrossSalary;
        $this->employersName = $employersName;
        $this->employersAddress = $employersAddress;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Occupation
     */
    public function setName(string $name): Occupation
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getYearlyGrossSalary(): ?string
    {
        return $this->yearlyGrossSalary;
    }

    /**
     * @param string $yearlyGrossSalary
     * @return Occupation
     */
    public function setYearlyGrossSalary(string $yearlyGrossSalary): Occupation
    {
        $this->yearlyGrossSalary = $yearlyGrossSalary;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmployersName(): ?string
    {
        return $this->employersName;
    }

    /**
     * @param string $employersName
     * @return Occupation
     */
    public function setEmployersName(string $employersName): Occupation
    {
        $this->employersName = $employersName;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getEmployersAddress(): ?Address
    {
        return $this->employersAddress;
    }

    /**
     * @param Address $employersAddress
     * @return Occupation
     */
    public function setEmployersAddress(Address $employersAddress): Occupation
    {
        $this->employersAddress = $employersAddress;
        return $this;
    }
}
