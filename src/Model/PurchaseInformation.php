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
 * Describes the current state of a purchase.
 */
class PurchaseInformation
{
    /**
     * @var string|null
     */
    private $purchaseId;

    /**
     * @var PurchaseState|null
     */
    private $state;

    /**
     * @var Currency|null
     */
    private $currency;

    /**
     * @var Amount|null
     */
    private $authorizedAmount;

    /**
     * @var Amount|null
     */
    private $capturedAmount;

    /**
     * @var Amount|null
     */
    private $remainingCaptureAmount;

    /**
     * @var Amount|null
     */
    private $refundedAmount;

    /**
     * @var Amount|null
     */
    private $remainingRefundableAmount;

    /**
     * @var Amount|null
     */
    private $purchaseAmount;

    /**
     * @var Consumer|null
     */
    private $consumer;

    /**
     * @var ConsumerVerification|null
     */
    private $consumerVerification;

    /**
     * @var MerchantReference|null
     */
    private $merchantReference;

    /**
     * @var PaymentInformation|null
     */
    private $paymentInformation;

    /**
     * @var PaymentOption[]|null
     */
    private $paymentOptions;

    /**
     * @var OperationInformation[]|null
     */
    private $captures;

    /**
     * @var OperationInformation[]|null
     */
    private $refunds;

    /**
     * @var Document[]|null
     */
    private $documents;

    /**
     * @var string[]|null
     */
    private $metaData;

    /**
     * @param string|null $purchaseId
     * @param PurchaseState|null $state
     * @param Currency|null $currency
     * @param Amount|null $authorizedAmount
     * @param Amount|null $capturedAmount
     * @param Amount|null $remainingCaptureAmount
     * @param Amount|null $refundedAmount
     * @param Amount|null $remainingRefundableAmount
     * @param Amount|null $purchaseAmount
     * @param Consumer|null $consumer
     * @param ConsumerVerification|null $consumerVerification
     * @param MerchantReference|null $merchantReference
     * @param PaymentInformation|null $paymentInformation
     * @param PaymentOption[]|null $paymentOptions
     * @param OperationInformation[]|null $captures
     * @param OperationInformation[]|null $refunds
     * @param Document[]|null $documents
     * @param string[]|null $metaData
     */
    public function __construct(
        string $purchaseId = null,
        PurchaseState $state = null,
        Currency $currency = null,
        Amount $authorizedAmount = null,
        Amount $capturedAmount = null,
        Amount $remainingCaptureAmount = null,
        Amount $refundedAmount = null,
        Amount $remainingRefundableAmount = null,
        Amount $purchaseAmount = null,
        Consumer $consumer = null,
        ConsumerVerification $consumerVerification = null,
        MerchantReference $merchantReference = null,
        PaymentInformation $paymentInformation = null,
        array $paymentOptions = null,
        array $captures = null,
        array $refunds = null,
        array $documents = null,
        array $metaData = null
    ) {
        $this->purchaseId = $purchaseId;
        $this->state = $state;
        $this->currency = $currency;
        $this->authorizedAmount = $authorizedAmount;
        $this->capturedAmount = $capturedAmount;
        $this->remainingCaptureAmount = $remainingCaptureAmount;
        $this->refundedAmount = $refundedAmount;
        $this->remainingRefundableAmount = $remainingRefundableAmount;
        $this->purchaseAmount = $purchaseAmount;
        $this->consumer = $consumer;
        $this->consumerVerification = $consumerVerification;
        $this->merchantReference = $merchantReference;
        $this->paymentInformation = $paymentInformation;
        $this->paymentOptions = $paymentOptions;
        $this->captures = $captures;
        $this->refunds = $refunds;
        $this->documents = $documents;
        $this->metaData = $metaData;
    }

    /**
     * @return string|null
     */
    public function getPurchaseId(): ?string
    {
        return $this->purchaseId;
    }

    /**
     * @param string $purchaseId
     * @return PurchaseInformation
     */
    public function setPurchaseId(string $purchaseId): PurchaseInformation
    {
        $this->purchaseId = $purchaseId;
        return $this;
    }

    /**
     * @return PurchaseState|null
     */
    public function getState(): ?PurchaseState
    {
        return $this->state;
    }

    /**
     * @param PurchaseState $state
     * @return PurchaseInformation
     */
    public function setState(PurchaseState $state): PurchaseInformation
    {
        $this->state = $state;
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
     * @return PurchaseInformation
     */
    public function setCurrency(Currency $currency): PurchaseInformation
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getAuthorizedAmount(): ?Amount
    {
        return $this->authorizedAmount;
    }

    /**
     * @param Amount $authorizedAmount
     * @return PurchaseInformation
     */
    public function setAuthorizedAmount(Amount $authorizedAmount): PurchaseInformation
    {
        $this->authorizedAmount = $authorizedAmount;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getCapturedAmount(): ?Amount
    {
        return $this->capturedAmount;
    }

    /**
     * @param Amount $capturedAmount
     * @return PurchaseInformation
     */
    public function setCapturedAmount(Amount $capturedAmount): PurchaseInformation
    {
        $this->capturedAmount = $capturedAmount;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getRemainingCaptureAmount(): ?Amount
    {
        return $this->remainingCaptureAmount;
    }

    /**
     * @param Amount $remainingCaptureAmount
     * @return PurchaseInformation
     */
    public function setRemainingCaptureAmount(Amount $remainingCaptureAmount): PurchaseInformation
    {
        $this->remainingCaptureAmount = $remainingCaptureAmount;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getRefundedAmount(): ?Amount
    {
        return $this->refundedAmount;
    }

    /**
     * @param Amount $refundedAmount
     * @return PurchaseInformation
     */
    public function setRefundedAmount(Amount $refundedAmount): PurchaseInformation
    {
        $this->refundedAmount = $refundedAmount;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getRemainingRefundableAmount(): ?Amount
    {
        return $this->remainingRefundableAmount;
    }

    /**
     * @param Amount $remainingRefundableAmount
     * @return PurchaseInformation
     */
    public function setRemainingRefundableAmount(Amount $remainingRefundableAmount): PurchaseInformation
    {
        $this->remainingRefundableAmount = $remainingRefundableAmount;
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
     * @return PurchaseInformation
     */
    public function setPurchaseAmount(Amount $purchaseAmount): PurchaseInformation
    {
        $this->purchaseAmount = $purchaseAmount;
        return $this;
    }

    /**
     * @return Consumer|null
     */
    public function getConsumer(): ?Consumer
    {
        return $this->consumer;
    }

    /**
     * @param Consumer $consumer
     * @return PurchaseInformation
     */
    public function setConsumer(Consumer $consumer): PurchaseInformation
    {
        $this->consumer = $consumer;
        return $this;
    }

    /**
     * @return ConsumerVerification|null
     */
    public function getConsumerVerification(): ?ConsumerVerification
    {
        return $this->consumerVerification;
    }

    /**
     * @param ConsumerVerification $consumerVerification
     * @return PurchaseInformation
     */
    public function setConsumerVerification(ConsumerVerification $consumerVerification): PurchaseInformation
    {
        $this->consumerVerification = $consumerVerification;
        return $this;
    }

    /**
     * @return MerchantReference|null
     */
    public function getMerchantReference(): ?MerchantReference
    {
        return $this->merchantReference;
    }

    /**
     * @param MerchantReference $merchantReference
     * @return PurchaseInformation
     */
    public function setMerchantReference(MerchantReference $merchantReference): PurchaseInformation
    {
        $this->merchantReference = $merchantReference;
        return $this;
    }

    /**
     * @return PaymentInformation|null
     */
    public function getPaymentInformation(): ?PaymentInformation
    {
        return $this->paymentInformation;
    }

    /**
     * @param PaymentInformation $paymentInformation
     * @return PurchaseInformation
     */
    public function setPaymentInformation(PaymentInformation $paymentInformation): PurchaseInformation
    {
        $this->paymentInformation = $paymentInformation;
        return $this;
    }

    /**
     * @return PaymentOption[]|null
     */
    public function getPaymentOptions(): ?array
    {
        return $this->paymentOptions;
    }

    /**
     * @param PaymentOption[] $paymentOptions
     * @return PurchaseInformation
     */
    public function setPaymentOptions(array $paymentOptions): PurchaseInformation
    {
        $this->paymentOptions = $paymentOptions;
        return $this;
    }

    /**
     * @param PaymentOption $value
     * @return PurchaseInformation
     */
    public function addPaymentOptions(PaymentOption $value): PurchaseInformation
    {
        $this->paymentOptions[] = $value;
        return $this;
    }

    /**
     * Performed captures.
     * @return OperationInformation[]|null
     */
    public function getCaptures(): ?array
    {
        return $this->captures;
    }

    /**
     * @param OperationInformation[] $captures
     * @return PurchaseInformation
     */
    public function setCaptures(array $captures): PurchaseInformation
    {
        $this->captures = $captures;
        return $this;
    }

    /**
     * @param OperationInformation $value
     * @return PurchaseInformation
     */
    public function addCaptures(OperationInformation $value): PurchaseInformation
    {
        $this->captures[] = $value;
        return $this;
    }

    /**
     * Performed refunds.
     * @return OperationInformation[]|null
     */
    public function getRefunds(): ?array
    {
        return $this->refunds;
    }

    /**
     * @param OperationInformation[] $refunds
     * @return PurchaseInformation
     */
    public function setRefunds(array $refunds): PurchaseInformation
    {
        $this->refunds = $refunds;
        return $this;
    }

    /**
     * @param OperationInformation $value
     * @return PurchaseInformation
     */
    public function addRefunds(OperationInformation $value): PurchaseInformation
    {
        $this->refunds[] = $value;
        return $this;
    }

    /**
     * Static documents.
     * @return Document[]|null
     */
    public function getDocuments(): ?array
    {
        return $this->documents;
    }

    /**
     * @param Document[] $documents
     * @return PurchaseInformation
     */
    public function setDocuments(array $documents): PurchaseInformation
    {
        $this->documents = $documents;
        return $this;
    }

    /**
     * @param Document $value
     * @return PurchaseInformation
     */
    public function addDocuments(Document $value): PurchaseInformation
    {
        $this->documents[] = $value;
        return $this;
    }

    /**
     * Additional information provided as a key value map.
     * @return string[]|null
     */
    public function getMetaData(): ?array
    {
        return $this->metaData;
    }

    /**
     * @param string[] $metaData
     * @return PurchaseInformation
     */
    public function setMetaData(array $metaData): PurchaseInformation
    {
        $this->metaData = $metaData;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return PurchaseInformation
     */
    public function addMetaData(string $key, string $value): PurchaseInformation
    {
        $this->metaData[$key] = $value;
        return $this;
    }
}
