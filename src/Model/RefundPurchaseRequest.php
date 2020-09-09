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

class RefundPurchaseRequest implements Request
{
    /**
     * @var string
     */
    private $purchaseId;

    /**
     * @var Amount
     */
    private $refundAmount;

    /**
     * @var RefundReason|null
     */
    private $reason;

    /**
     * @param string $purchaseId
     * @param Amount $refundAmount
     * @param RefundReason|null $reason
     */
    public function __construct(
        string $purchaseId,
        Amount $refundAmount,
        RefundReason $reason = null
    ) {
        $this->purchaseId = $purchaseId;
        $this->refundAmount = $refundAmount;
        $this->reason = $reason;
    }

    /**
     * PurchaseId received from initializePurchase or authorizePurchase response.
     * @return string
     */
    public function getPurchaseId(): string
    {
        return $this->purchaseId;
    }

    /**
     * @return Amount
     */
    public function getRefundAmount(): Amount
    {
        return $this->refundAmount;
    }

    /**
     * @return RefundReason|null
     */
    public function getReason(): ?RefundReason
    {
        return $this->reason;
    }

    /**
     * @param RefundReason $reason
     * @return RefundPurchaseRequest
     */
    public function setReason(RefundReason $reason): RefundPurchaseRequest
    {
        $this->reason = $reason;
        return $this;
    }
}
