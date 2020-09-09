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
 * Represents a consumer.
 */
class Consumer
{
    /**
     * @var Person|null
     */
    private $person;

    /**
     * @var Company|null
     */
    private $company;

    /**
     * @var Account|null
     */
    private $bankAccount;

    /**
     * @var Address|null
     */
    private $billingAddress;

    /**
     * @var DeliveryAddress|null
     */
    private $deliveryAddress;

    /**
     * @var DeliveryType|null
     */
    private $deliveryType;

    /**
     * @var Language|null
     */
    private $language;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var string|null
     */
    private $email;

    /**
     * @param Person|null $person
     * @param Company|null $company
     * @param Account|null $bankAccount
     * @param Address|null $billingAddress
     * @param DeliveryAddress|null $deliveryAddress
     * @param DeliveryType|null $deliveryType
     * @param Language|null $language
     * @param string|null $phone
     * @param string|null $email
     */
    public function __construct(
        Person $person = null,
        Company $company = null,
        Account $bankAccount = null,
        Address $billingAddress = null,
        DeliveryAddress $deliveryAddress = null,
        DeliveryType $deliveryType = null,
        Language $language = null,
        string $phone = null,
        string $email = null
    ) {
        $this->person = $person;
        $this->company = $company;
        $this->bankAccount = $bankAccount;
        $this->billingAddress = $billingAddress;
        $this->deliveryAddress = $deliveryAddress;
        $this->deliveryType = $deliveryType;
        $this->language = $language;
        $this->phone = $phone;
        $this->email = $email;
    }

    /**
     * @return Person|null
     */
    public function getPerson(): ?Person
    {
        return $this->person;
    }

    /**
     * @param Person $person
     * @return Consumer
     */
    public function setPerson(Person $person): Consumer
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     * @return Consumer
     */
    public function setCompany(Company $company): Consumer
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return Account|null
     */
    public function getBankAccount(): ?Account
    {
        return $this->bankAccount;
    }

    /**
     * @param Account $bankAccount
     * @return Consumer
     */
    public function setBankAccount(Account $bankAccount): Consumer
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getBillingAddress(): ?Address
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $billingAddress
     * @return Consumer
     */
    public function setBillingAddress(Address $billingAddress): Consumer
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    /**
     * @return DeliveryAddress|null
     */
    public function getDeliveryAddress(): ?DeliveryAddress
    {
        return $this->deliveryAddress;
    }

    /**
     * @param DeliveryAddress $deliveryAddress
     * @return Consumer
     */
    public function setDeliveryAddress(DeliveryAddress $deliveryAddress): Consumer
    {
        $this->deliveryAddress = $deliveryAddress;
        return $this;
    }

    /**
     * @return DeliveryType|null
     */
    public function getDeliveryType(): ?DeliveryType
    {
        return $this->deliveryType;
    }

    /**
     * @param DeliveryType $deliveryType
     * @return Consumer
     */
    public function setDeliveryType(DeliveryType $deliveryType): Consumer
    {
        $this->deliveryType = $deliveryType;
        return $this;
    }

    /**
     * @return Language|null
     */
    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    /**
     * @param Language $language
     * @return Consumer
     */
    public function setLanguage(Language $language): Consumer
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Consumer
     */
    public function setPhone(string $phone): Consumer
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Consumer
     */
    public function setEmail(string $email): Consumer
    {
        $this->email = $email;
        return $this;
    }
}
