<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 *
 * This class is based on the Paysafe Pay Later OpenAPI specification, version 1.0.0.
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Api;

use Paysafe\PayLater\Communication\HttpMethod;
use Paysafe\PayLater\Communication\RequestHeader;
use Paysafe\PayLater\Communication\RequestHeaderCollection;
use Paysafe\PayLater\Communication\Response;
use Paysafe\PayLater\Exception\ApiResponseException;
use Paysafe\PayLater\Exception\BuilderException;
use Paysafe\PayLater\Exception\ResponseException;
use Paysafe\PayLater\Model\CapturePurchaseRequest;
use Paysafe\PayLater\Model\InitializePurchaseRequest;
use Paysafe\PayLater\Model\PurchaseOperationResponse;
use Paysafe\PayLater\Model\RefundPurchaseRequest;
use Paysafe\PayLater\Model\ResponseWithAuthorization;

class PurchaseLifecycleApi extends BaseApi
{
    /**
     * Confirm a capture(=shipping) of the purchased goods.
     *
     * @param CapturePurchaseRequest $capturePurchaseRequest Contains all data needed to process a capture(=shipping) of purchased goods.
     * @param string $paysafePlSecretKey Secret key which can be requested from your account manager. Only use this for server-to-server communication.
     * @return Response PurchaseLifecycle endpoints always return the same object with the latest state of the purchase and different fields populated. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null.
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function capturePurchase(
        CapturePurchaseRequest $capturePurchaseRequest,
        string $paysafePlSecretKey
    ): Response {
        $uri = '/purchase/capture';

        $requestHeaderCollection = new RequestHeaderCollection(
            new RequestHeader('paysafe-pl-secret-key', $paysafePlSecretKey)
        );

        try {
            return $this->communicator->getGenericResponse(
                HttpMethod::POST,
                $uri,
                $requestHeaderCollection,
                $capturePurchaseRequest,
                PurchaseOperationResponse::class
            );
        } catch (ResponseException $exception) {
            throw $this->createApiResponseException($exception);
        }
    }

    /**
     * Query for a purchase for a given purchaseId.
     *
     * @param string $purchaseId PurchaseId received from initializePurchase or authorizePurchase response.
     * @param string $authorization The access token received from the initialize request. Provide this for client-side requests in the Bearer format.
     * @return Response PurchaseLifecycle endpoints always return the same object with the latest state of the purchase and different fields populated. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null.
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function getPurchaseWithAuthorization(
        string $purchaseId,
        string $authorization
    ): Response {
        $uri = '/purchase/info/{purchaseId}';
        $uri = $this->populateUri($uri, 'purchaseId', $purchaseId);

        $requestHeaderCollection = new RequestHeaderCollection(
            new RequestHeader('Authorization', 'Bearer ' . $authorization)
        );

        try {
            return $this->communicator->getGenericResponse(
                HttpMethod::GET,
                $uri,
                $requestHeaderCollection,
                null,
                PurchaseOperationResponse::class
            );
        } catch (ResponseException $exception) {
            throw $this->createApiResponseException($exception);
        }
    }

    /**
     * Query for a purchase for a given purchaseId.
     *
     * @param string $purchaseId PurchaseId received from initializePurchase or authorizePurchase response.
     * @param string $paysafePlSecretKey Secret key which can be requested from your account manager. Only use this for server-to-server communication.
     * @return Response PurchaseLifecycle endpoints always return the same object with the latest state of the purchase and different fields populated. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null.
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function getPurchase(
        string $purchaseId,
        string $paysafePlSecretKey
    ): Response {
        $uri = '/purchase/info/{purchaseId}';
        $uri = $this->populateUri($uri, 'purchaseId', $purchaseId);

        $requestHeaderCollection = new RequestHeaderCollection(
            new RequestHeader('paysafe-pl-secret-key', $paysafePlSecretKey)
        );

        try {
            return $this->communicator->getGenericResponse(
                HttpMethod::GET,
                $uri,
                $requestHeaderCollection,
                null,
                PurchaseOperationResponse::class
            );
        } catch (ResponseException $exception) {
            throw $this->createApiResponseException($exception);
        }
    }

    /**
     * Initializes a purchase for a given amount and returns a response with all pre-configured (non-binding) payment options.
     *
     * @param InitializePurchaseRequest $initializePurchaseRequest Contains the data needed to initialize a purchase.
     * @param string $paysafePlSecretKey Secret key which can be requested from your account manager. Only use this for server-to-server communication.
     * @return ResponseWithAuthorization PurchaseLifecycle endpoints always return the same object with the latest state of the purchase and different fields populated.  In addition, the initialize operation returns a single-purchase authentication token in the response header <<access_token>>. This token has to be used by client-side callers. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null.
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function initializePurchase(
        InitializePurchaseRequest $initializePurchaseRequest,
        string $paysafePlSecretKey
    ): ResponseWithAuthorization {
        $uri = '/purchase/initialize';

        $requestHeaderCollection = new RequestHeaderCollection(
            new RequestHeader('paysafe-pl-secret-key', $paysafePlSecretKey)
        );

        try {
            return $this->communicator->getResponseWithAuthorization(
                HttpMethod::POST,
                $uri,
                $requestHeaderCollection,
                $initializePurchaseRequest,
                PurchaseOperationResponse::class
            );
        } catch (ResponseException $exception) {
            throw $this->createApiResponseException($exception);
        }
    }

    /**
     * Refund part of or the full purchase amount in case consumer returned purchased goods.
     *
     * @param RefundPurchaseRequest $refundPurchaseRequest All data needed to process a refund of a purchase.
     * @param string $paysafePlSecretKey Secret key which can be requested from your account manager. Only use this for server-to-server communication.
     * @return Response PurchaseLifecycle endpoints always return the same object with the latest state of the purchase and different fields populated. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null.
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function refundPurchase(
        RefundPurchaseRequest $refundPurchaseRequest,
        string $paysafePlSecretKey
    ): Response {
        $uri = '/purchase/refund';

        $requestHeaderCollection = new RequestHeaderCollection(
            new RequestHeader('paysafe-pl-secret-key', $paysafePlSecretKey)
        );

        try {
            return $this->communicator->getGenericResponse(
                HttpMethod::POST,
                $uri,
                $requestHeaderCollection,
                $refundPurchaseRequest,
                PurchaseOperationResponse::class
            );
        } catch (ResponseException $exception) {
            throw $this->createApiResponseException($exception);
        }
    }
}
