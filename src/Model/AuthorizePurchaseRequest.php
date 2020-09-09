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

class AuthorizePurchaseRequest implements Request
{
    /**
     * @var string
     */
    private $purchaseId;

    /**
     * @var string|null
     */
    private $phone;

    /**
     * @var MethodType
     */
    private $method;

    /**
     * @var string|null
     */
    private $successUrl;

    /**
     * @var string|null
     */
    private $callbackUrl;

    /**
     * @param string $purchaseId
     * @param string|null $phone
     * @param MethodType $method
     * @param string|null $successUrl
     * @param string|null $callbackUrl
     */
    public function __construct(
        string $purchaseId,
        MethodType $method,
        string $phone = null,
        string $successUrl = null,
        string $callbackUrl = null
    ) {
        $this->purchaseId = $purchaseId;
        $this->phone = $phone;
        $this->method = $method;
        $this->successUrl = $successUrl;
        $this->callbackUrl = $callbackUrl;
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
     * If method 'SMS' is chosen, a phone number must be provided and will receive a message to start the verify process.
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return AuthorizePurchaseRequest
     */
    public function setPhone(string $phone): AuthorizePurchaseRequest
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return MethodType
     */
    public function getMethod(): MethodType
    {
        return $this->method;
    }

    /**
     * Redirect URL for the merchant after finishing the flow.
     * @return string|null
     */
    public function getSuccessUrl(): ?string
    {
        return $this->successUrl;
    }

    /**
     * @param string $successUrl
     * @return AuthorizePurchaseRequest
     */
    public function setSuccessUrl(string $successUrl): AuthorizePurchaseRequest
    {
        $this->successUrl = $successUrl;
        return $this;
    }

    /**
     * After successfully finishing the flow, this URL will receive a callback to indicate completion to the merchant.
     * @return string|null
     */
    public function getCallbackUrl(): ?string
    {
        return $this->callbackUrl;
    }

    /**
     * @param string $callbackUrl
     * @return AuthorizePurchaseRequest
     */
    public function setCallbackUrl(string $callbackUrl): AuthorizePurchaseRequest
    {
        $this->callbackUrl = $callbackUrl;
        return $this;
    }
}
