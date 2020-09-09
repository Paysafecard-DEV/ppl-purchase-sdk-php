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

class PaymentInformation
{
    /**
     * @var string|null
     */
    private $paymentReference;

    /**
     * @var Account|null
     */
    private $account;

    /**
     * @var PaymentMethod|null
     */
    private $paymentMethod;

    /**
     * @var PaymentOption|null
     */
    private $confirmedPaymentOption;

    /**
     * @param string|null $paymentReference
     * @param Account|null $account
     * @param PaymentMethod|null $paymentMethod
     * @param PaymentOption|null $confirmedPaymentOption
     */
    public function __construct(
        string $paymentReference = null,
        Account $account = null,
        PaymentMethod $paymentMethod = null,
        PaymentOption $confirmedPaymentOption = null
    ) {
        $this->paymentReference = $paymentReference;
        $this->account = $account;
        $this->paymentMethod = $paymentMethod;
        $this->confirmedPaymentOption = $confirmedPaymentOption;
    }

    /**
     * @return string|null
     */
    public function getPaymentReference(): ?string
    {
        return $this->paymentReference;
    }

    /**
     * @param string $paymentReference
     * @return PaymentInformation
     */
    public function setPaymentReference(string $paymentReference): PaymentInformation
    {
        $this->paymentReference = $paymentReference;
        return $this;
    }

    /**
     * @return Account|null
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     * @return PaymentInformation
     */
    public function setAccount(Account $account): PaymentInformation
    {
        $this->account = $account;
        return $this;
    }

    /**
     * @return PaymentMethod|null
     */
    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    /**
     * @param PaymentMethod $paymentMethod
     * @return PaymentInformation
     */
    public function setPaymentMethod(PaymentMethod $paymentMethod): PaymentInformation
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    /**
     * @return PaymentOption|null
     */
    public function getConfirmedPaymentOption(): ?PaymentOption
    {
        return $this->confirmedPaymentOption;
    }

    /**
     * @param PaymentOption $confirmedPaymentOption
     * @return PaymentInformation
     */
    public function setConfirmedPaymentOption(PaymentOption $confirmedPaymentOption): PaymentInformation
    {
        $this->confirmedPaymentOption = $confirmedPaymentOption;
        return $this;
    }
}
