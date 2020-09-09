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

class CapturePurchaseRequest implements Request
{
    /**
     * @var string|null
     */
    private $purchaseId;

    /**
     * @var string|null
     */
    private $orderId;

    /**
     * @var Amount
     */
    private $fulfillmentAmount;

    /**
     * @var bool|null
     */
    private $closePurchase;

    /**
     * @var DeliveryInformation|null
     */
    private $deliveryInformation;

    /**
     * @param string|null $purchaseId
     * @param string|null $orderId
     * @param Amount $fulfillmentAmount
     * @param bool|null $closePurchase
     * @param DeliveryInformation|null $deliveryInformation
     */
    public function __construct(
        Amount $fulfillmentAmount,
        string $purchaseId = null,
        string $orderId = null,
        bool $closePurchase = null,
        DeliveryInformation $deliveryInformation = null
    ) {
        $this->purchaseId = $purchaseId;
        $this->orderId = $orderId;
        $this->fulfillmentAmount = $fulfillmentAmount;
        $this->closePurchase = $closePurchase;
        $this->deliveryInformation = $deliveryInformation;
    }

    /**
     * PurchaseId received from initializePurchase or authorizePurchase response.
     * @return string|null
     */
    public function getPurchaseId(): ?string
    {
        return $this->purchaseId;
    }

    /**
     * @param string $purchaseId
     * @return CapturePurchaseRequest
     */
    public function setPurchaseId(string $purchaseId): CapturePurchaseRequest
    {
        $this->purchaseId = $purchaseId;
        return $this;
    }

    /**
     * OrderId received after the consumer has completed the transaction from getPurchase response or callback message.
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     * @return CapturePurchaseRequest
     */
    public function setOrderId(string $orderId): CapturePurchaseRequest
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return Amount
     */
    public function getFulfillmentAmount(): Amount
    {
        return $this->fulfillmentAmount;
    }

    /**
     * This flag indicates if the purchase can be closed.
     * @return bool|null
     */
    public function getClosePurchase(): ?bool
    {
        return $this->closePurchase;
    }

    /**
     * @param bool $closePurchase
     * @return CapturePurchaseRequest
     */
    public function setClosePurchase(bool $closePurchase): CapturePurchaseRequest
    {
        $this->closePurchase = $closePurchase;
        return $this;
    }

    /**
     * @return DeliveryInformation|null
     */
    public function getDeliveryInformation(): ?DeliveryInformation
    {
        return $this->deliveryInformation;
    }

    /**
     * @param DeliveryInformation $deliveryInformation
     * @return CapturePurchaseRequest
     */
    public function setDeliveryInformation(DeliveryInformation $deliveryInformation): CapturePurchaseRequest
    {
        $this->deliveryInformation = $deliveryInformation;
        return $this;
    }
}
