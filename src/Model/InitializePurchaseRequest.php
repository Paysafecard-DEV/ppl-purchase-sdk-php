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

use Paysafe\PayLater\Communication\Request;

// phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
// phpcs:disable ObjectCalisthenics.Metrics.PropertyPerClassLimit

class InitializePurchaseRequest implements Request
{
    /**
     * @var Amount
     */
    private $purchaseAmount;

    /**
     * @var Consumer|null
     */
    private $consumer;

    /**
     * @var MerchantReference|null
     */
    private $merchantReference;

    /**
     * @var string|null
     */
    private $additionalInformation;

    /**
     * @param Amount $purchaseAmount
     * @param Consumer|null $consumer
     * @param MerchantReference|null $merchantReference
     * @param string|null $additionalInformation
     */
    public function __construct(
        Amount $purchaseAmount,
        Consumer $consumer = null,
        MerchantReference $merchantReference = null,
        string $additionalInformation = null
    ) {
        $this->purchaseAmount = $purchaseAmount;
        $this->consumer = $consumer;
        $this->merchantReference = $merchantReference;
        $this->additionalInformation = $additionalInformation;
    }

    /**
     * @return Amount
     */
    public function getPurchaseAmount(): Amount
    {
        return $this->purchaseAmount;
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
     * @return InitializePurchaseRequest
     */
    public function setConsumer(Consumer $consumer): InitializePurchaseRequest
    {
        $this->consumer = $consumer;
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
     * @return InitializePurchaseRequest
     */
    public function setMerchantReference(MerchantReference $merchantReference): InitializePurchaseRequest
    {
        $this->merchantReference = $merchantReference;
        return $this;
    }

    /**
     * Additional information provided as a key value map.  Shop information, when a merchant has multiple shops this assigns a specific transaction to a specific shop: - PAYOLUTION_SHOP_ID - PAYOLUTION_SHOP_NAME - PAYOLUTION_SHOP_LEGAL_NAME  Customer registration, input for risk, increases acceptance rate: - PAYOLUTION_CUSTOMER_REGISTRATION_DATE - PAYOLUTION_CUSTOMER_REGISTRATION_LEVEL  Basket content, input for risk, increases acceptance rate: - PAYOLUTION_ITEM_DESCR_1 - PAYOLUTION_ITEM_PRICE_1 - PAYOLUTION_ITEM_TAX_1  Fulfillment dates, delays due date for customer: - PAYOLUTION_FULFILLMENT_START - PAYOLUTION_FULFILLMENT_END
     * @return string|null
     */
    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    /**
     * @param string $additionalInformation
     * @return InitializePurchaseRequest
     */
    public function setAdditionalInformation(string $additionalInformation): InitializePurchaseRequest
    {
        $this->additionalInformation = $additionalInformation;
        return $this;
    }
}
