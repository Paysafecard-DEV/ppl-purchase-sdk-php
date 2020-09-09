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
 * Represents a bank account of a consumer. Contains holder information and different types of routing information.
 */
class Account
{
    /**
     * @var string|null
     */
    private $holder;

    /**
     * @var Country|null
     */
    private $country;

    /**
     * @var Sepa|null
     */
    private $sepa;

    /**
     * @var Eft|null
     */
    private $eft;

    /**
     * @var Ach|null
     */
    private $ach;

    /**
     * @var Bacs|null
     */
    private $bacs;

    /**
     * @param string|null $holder
     * @param Country|null $country
     * @param Sepa|null $sepa
     * @param Eft|null $eft
     * @param Ach|null $ach
     * @param Bacs|null $bacs
     */
    public function __construct(
        string $holder = null,
        Country $country = null,
        Sepa $sepa = null,
        Eft $eft = null,
        Ach $ach = null,
        Bacs $bacs = null
    ) {
        $this->holder = $holder;
        $this->country = $country;
        $this->sepa = $sepa;
        $this->eft = $eft;
        $this->ach = $ach;
        $this->bacs = $bacs;
    }

    /**
     * @return string|null
     */
    public function getHolder(): ?string
    {
        return $this->holder;
    }

    /**
     * @param string $holder
     * @return Account
     */
    public function setHolder(string $holder): Account
    {
        $this->holder = $holder;
        return $this;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     * @return Account
     */
    public function setCountry(Country $country): Account
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return Sepa|null
     */
    public function getSepa(): ?Sepa
    {
        return $this->sepa;
    }

    /**
     * @param Sepa $sepa
     * @return Account
     */
    public function setSepa(Sepa $sepa): Account
    {
        $this->sepa = $sepa;
        return $this;
    }

    /**
     * @return Eft|null
     */
    public function getEft(): ?Eft
    {
        return $this->eft;
    }

    /**
     * @param Eft $eft
     * @return Account
     */
    public function setEft(Eft $eft): Account
    {
        $this->eft = $eft;
        return $this;
    }

    /**
     * @return Ach|null
     */
    public function getAch(): ?Ach
    {
        return $this->ach;
    }

    /**
     * @param Ach $ach
     * @return Account
     */
    public function setAch(Ach $ach): Account
    {
        $this->ach = $ach;
        return $this;
    }

    /**
     * @return Bacs|null
     */
    public function getBacs(): ?Bacs
    {
        return $this->bacs;
    }

    /**
     * @param Bacs $bacs
     * @return Account
     */
    public function setBacs(Bacs $bacs): Account
    {
        $this->bacs = $bacs;
        return $this;
    }
}
