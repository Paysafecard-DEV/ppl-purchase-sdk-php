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

use DateTime;

// phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
// phpcs:disable ObjectCalisthenics.Metrics.PropertyPerClassLimit

/**
 * Properties of a natural person.
 */
class Person
{
    /**
     * @var string|null
     */
    private $salutation;

    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var DateTime|null
     */
    private $birthdate;

    /**
     * @var string|null
     */
    private $socialId;

    /**
     * @var Occupation|null
     */
    private $occupation;

    /**
     * @param string|null $salutation
     * @param string|null $firstName
     * @param string|null $lastName
     * @param DateTime|null $birthdate
     * @param string|null $socialId
     * @param Occupation|null $occupation
     */
    public function __construct(
        string $salutation = null,
        string $firstName = null,
        string $lastName = null,
        DateTime $birthdate = null,
        string $socialId = null,
        Occupation $occupation = null
    ) {
        $this->salutation = $salutation;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthdate = $birthdate;
        $this->socialId = $socialId;
        $this->occupation = $occupation;
    }

    /**
     * @return string|null
     */
    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    /**
     * @param string $salutation
     * @return Person
     */
    public function setSalutation(string $salutation): Person
    {
        $this->salutation = $salutation;
        return $this;
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
     * @return Person
     */
    public function setFirstName(string $firstName): Person
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
     * @return Person
     */
    public function setLastName(string $lastName): Person
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getBirthdate(): ?DateTime
    {
        return $this->birthdate;
    }

    /**
     * @param DateTime $birthdate
     * @return Person
     */
    public function setBirthdate(DateTime $birthdate): Person
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSocialId(): ?string
    {
        return $this->socialId;
    }

    /**
     * @param string $socialId
     * @return Person
     */
    public function setSocialId(string $socialId): Person
    {
        $this->socialId = $socialId;
        return $this;
    }

    /**
     * @return Occupation|null
     */
    public function getOccupation(): ?Occupation
    {
        return $this->occupation;
    }

    /**
     * @param Occupation $occupation
     * @return Person
     */
    public function setOccupation(Occupation $occupation): Person
    {
        $this->occupation = $occupation;
        return $this;
    }
}
