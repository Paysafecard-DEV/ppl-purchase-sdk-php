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

use Paysafe\PayLater\Communication\Response;

// phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
// phpcs:disable ObjectCalisthenics.Metrics.PropertyPerClassLimit

class PurchaseOperationResponse implements Response
{
    /**
     * @var OperationResult|null
     */
    private $result;

    /**
     * @var PurchaseInformation|null
     */
    private $purchase;

    /**
     * @param OperationResult|null $result
     * @param PurchaseInformation|null $purchase
     */
    public function __construct(
        OperationResult $result = null,
        PurchaseInformation $purchase = null
    ) {
        $this->result = $result;
        $this->purchase = $purchase;
    }

    /**
     * @return OperationResult|null
     */
    public function getResult(): ?OperationResult
    {
        return $this->result;
    }

    /**
     * @param OperationResult $result
     * @return PurchaseOperationResponse
     */
    public function setResult(OperationResult $result): PurchaseOperationResponse
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return PurchaseInformation|null
     */
    public function getPurchase(): ?PurchaseInformation
    {
        return $this->purchase;
    }

    /**
     * @param PurchaseInformation $purchase
     * @return PurchaseOperationResponse
     */
    public function setPurchase(PurchaseInformation $purchase): PurchaseOperationResponse
    {
        $this->purchase = $purchase;
        return $this;
    }
}
