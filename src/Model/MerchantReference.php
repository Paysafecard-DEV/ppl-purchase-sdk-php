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

class MerchantReference
{
    /**
     * @var string|null
     */
    private $orderId;

    /**
     * @var string|null
     */
    private $customerId;

    /**
     * @var string|null
     */
    private $invoiceId;

    /**
     * @param string|null $orderId
     * @param string|null $customerId
     * @param string|null $invoiceId
     */
    public function __construct(
        string $orderId = null,
        string $customerId = null,
        string $invoiceId = null
    ) {
        $this->orderId = $orderId;
        $this->customerId = $customerId;
        $this->invoiceId = $invoiceId;
    }

    /**
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     * @return MerchantReference
     */
    public function setOrderId(string $orderId): MerchantReference
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     * @return MerchantReference
     */
    public function setCustomerId(string $customerId): MerchantReference
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInvoiceId(): ?string
    {
        return $this->invoiceId;
    }

    /**
     * @param string $invoiceId
     * @return MerchantReference
     */
    public function setInvoiceId(string $invoiceId): MerchantReference
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }
}
