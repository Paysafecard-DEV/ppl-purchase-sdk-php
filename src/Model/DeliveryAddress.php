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
 * Address where goods can be delivered to.
 */
class DeliveryAddress
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
     * @var Address|null
     */
    private $address;

    /**
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $companyName
     * @param Address|null $address
     */
    public function __construct(
        string $firstName = null,
        string $lastName = null,
        string $companyName = null,
        Address $address = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->companyName = $companyName;
        $this->address = $address;
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
     * @return DeliveryAddress
     */
    public function setFirstName(string $firstName): DeliveryAddress
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
     * @return DeliveryAddress
     */
    public function setLastName(string $lastName): DeliveryAddress
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
     * @return DeliveryAddress
     */
    public function setCompanyName(string $companyName): DeliveryAddress
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return DeliveryAddress
     */
    public function setAddress(Address $address): DeliveryAddress
    {
        $this->address = $address;
        return $this;
    }
}
