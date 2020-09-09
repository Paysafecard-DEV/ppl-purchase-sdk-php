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
 * Represents a postal address of a consumer.
 */
class Address
{
    /**
     * @var string|null
     */
    private $street;

    /**
     * @var string|null
     */
    private $houseNumber;

    /**
     * @var string|null
     */
    private $additionalInfo;

    /**
     * @var string|null
     */
    private $zipCode;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @var Country|null
     */
    private $countryCode;

    /**
     * @var string|null
     */
    private $state;

    /**
     * @param string|null $street
     * @param string|null $houseNumber
     * @param string|null $additionalInfo
     * @param string|null $zipCode
     * @param string|null $city
     * @param Country|null $countryCode
     * @param string|null $state
     */
    public function __construct(
        string $street = null,
        string $houseNumber = null,
        string $additionalInfo = null,
        string $zipCode = null,
        string $city = null,
        Country $countryCode = null,
        string $state = null
    ) {
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->additionalInfo = $additionalInfo;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->countryCode = $countryCode;
        $this->state = $state;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return Address
     */
    public function setStreet(string $street): Address
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    /**
     * @param string $houseNumber
     * @return Address
     */
    public function setHouseNumber(string $houseNumber): Address
    {
        $this->houseNumber = $houseNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    /**
     * @param string $additionalInfo
     * @return Address
     */
    public function setAdditionalInfo(string $additionalInfo): Address
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return Address
     */
    public function setZipCode(string $zipCode): Address
    {
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Address
     */
    public function setCity(string $city): Address
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return Country|null
     */
    public function getCountryCode(): ?Country
    {
        return $this->countryCode;
    }

    /**
     * @param Country $countryCode
     * @return Address
     */
    public function setCountryCode(Country $countryCode): Address
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Address
     */
    public function setState(string $state): Address
    {
        $this->state = $state;
        return $this;
    }
}
