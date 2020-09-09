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

class PaymentOption
{
    /**
     * @var string|null
     */
    private $optionId;

    /**
     * @var Country|null
     */
    private $consumerCountry;

    /**
     * @var Currency|null
     */
    private $currency;

    /**
     * @var ProductType|null
     */
    private $productType;

    /**
     * @var PaymentMethod[]|null
     */
    private $supportedPaymentMethods;

    /**
     * @var Amount|null
     */
    private $totalAmount;

    /**
     * @var Amount|null
     */
    private $purchaseAmount;

    /**
     * @var float|null
     */
    private $interestRate;

    /**
     * @var float|null
     */
    private $effectiveInterestRate;

    /**
     * @var float|null
     */
    private $numberOfPayments;

    /**
     * @var Payment[]|null
     */
    private $payments;

    /**
     * @var Contract[]|null
     */
    private $contracts;

    /**
     * @param string|null $optionId
     * @param Country|null $consumerCountry
     * @param Currency|null $currency
     * @param ProductType|null $productType
     * @param PaymentMethod[]|null $supportedPaymentMethods
     * @param Amount|null $totalAmount
     * @param Amount|null $purchaseAmount
     * @param double|null $interestRate
     * @param double|null $effectiveInterestRate
     * @param float|null $numberOfPayments
     * @param Payment[]|null $payments
     * @param Contract[]|null $contracts
     */
    public function __construct(
        string $optionId = null,
        Country $consumerCountry = null,
        Currency $currency = null,
        ProductType $productType = null,
        array $supportedPaymentMethods = null,
        Amount $totalAmount = null,
        Amount $purchaseAmount = null,
        float $interestRate = null,
        float $effectiveInterestRate = null,
        float $numberOfPayments = null,
        array $payments = null,
        array $contracts = null
    ) {
        $this->optionId = $optionId;
        $this->consumerCountry = $consumerCountry;
        $this->currency = $currency;
        $this->productType = $productType;
        $this->supportedPaymentMethods = $supportedPaymentMethods;
        $this->totalAmount = $totalAmount;
        $this->purchaseAmount = $purchaseAmount;
        $this->interestRate = $interestRate;
        $this->effectiveInterestRate = $effectiveInterestRate;
        $this->numberOfPayments = $numberOfPayments;
        $this->payments = $payments;
        $this->contracts = $contracts;
    }

    /**
     * @return string|null
     */
    public function getOptionId(): ?string
    {
        return $this->optionId;
    }

    /**
     * @param string $optionId
     * @return PaymentOption
     */
    public function setOptionId(string $optionId): PaymentOption
    {
        $this->optionId = $optionId;
        return $this;
    }

    /**
     * @return Country|null
     */
    public function getConsumerCountry(): ?Country
    {
        return $this->consumerCountry;
    }

    /**
     * @param Country $consumerCountry
     * @return PaymentOption
     */
    public function setConsumerCountry(Country $consumerCountry): PaymentOption
    {
        $this->consumerCountry = $consumerCountry;
        return $this;
    }

    /**
     * @return Currency|null
     */
    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     * @return PaymentOption
     */
    public function setCurrency(Currency $currency): PaymentOption
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return ProductType|null
     */
    public function getProductType(): ?ProductType
    {
        return $this->productType;
    }

    /**
     * @param ProductType $productType
     * @return PaymentOption
     */
    public function setProductType(ProductType $productType): PaymentOption
    {
        $this->productType = $productType;
        return $this;
    }

    /**
     * @return PaymentMethod[]|null
     */
    public function getSupportedPaymentMethods(): ?array
    {
        return $this->supportedPaymentMethods;
    }

    /**
     * @param PaymentMethod[] $supportedPaymentMethods
     * @return PaymentOption
     */
    public function setSupportedPaymentMethods(array $supportedPaymentMethods): PaymentOption
    {
        $this->supportedPaymentMethods = $supportedPaymentMethods;
        return $this;
    }

    /**
     * @param PaymentMethod $value
     * @return PaymentOption
     */
    public function addSupportedPaymentMethods(PaymentMethod $value): PaymentOption
    {
        $this->supportedPaymentMethods[] = $value;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getTotalAmount(): ?Amount
    {
        return $this->totalAmount;
    }

    /**
     * @param Amount $totalAmount
     * @return PaymentOption
     */
    public function setTotalAmount(Amount $totalAmount): PaymentOption
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getPurchaseAmount(): ?Amount
    {
        return $this->purchaseAmount;
    }

    /**
     * @param Amount $purchaseAmount
     * @return PaymentOption
     */
    public function setPurchaseAmount(Amount $purchaseAmount): PaymentOption
    {
        $this->purchaseAmount = $purchaseAmount;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getInterestRate(): ?float
    {
        return $this->interestRate;
    }

    /**
     * @param float $interestRate
     * @return PaymentOption
     */
    public function setInterestRate(float $interestRate): PaymentOption
    {
        $this->interestRate = $interestRate;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getEffectiveInterestRate(): ?float
    {
        return $this->effectiveInterestRate;
    }

    /**
     * @param float $effectiveInterestRate
     * @return PaymentOption
     */
    public function setEffectiveInterestRate(float $effectiveInterestRate): PaymentOption
    {
        $this->effectiveInterestRate = $effectiveInterestRate;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getNumberOfPayments(): ?float
    {
        return $this->numberOfPayments;
    }

    /**
     * @param float $numberOfPayments
     * @return PaymentOption
     */
    public function setNumberOfPayments(float $numberOfPayments): PaymentOption
    {
        $this->numberOfPayments = $numberOfPayments;
        return $this;
    }

    /**
     * @return Payment[]|null
     */
    public function getPayments(): ?array
    {
        return $this->payments;
    }

    /**
     * @param Payment[] $payments
     * @return PaymentOption
     */
    public function setPayments(array $payments): PaymentOption
    {
        $this->payments = $payments;
        return $this;
    }

    /**
     * @param Payment $value
     * @return PaymentOption
     */
    public function addPayments(Payment $value): PaymentOption
    {
        $this->payments[] = $value;
        return $this;
    }

    /**
     * @return Contract[]|null
     */
    public function getContracts(): ?array
    {
        return $this->contracts;
    }

    /**
     * @param Contract[] $contracts
     * @return PaymentOption
     */
    public function setContracts(array $contracts): PaymentOption
    {
        $this->contracts = $contracts;
        return $this;
    }

    /**
     * @param Contract $value
     * @return PaymentOption
     */
    public function addContracts(Contract $value): PaymentOption
    {
        $this->contracts[] = $value;
        return $this;
    }
}
