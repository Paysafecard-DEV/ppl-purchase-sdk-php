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
use Paysafe\PayLater\Model\AuthorizePurchaseRequest;
use Paysafe\PayLater\Model\PurchaseOperationResponse;

class PurchaseAuthorizationApi extends BaseApi
{
    /**
     * Authorize a consumer to complete a transaction with our hosted solution. Can be started via SMS or URL.
     *
     * @param AuthorizePurchaseRequest $authorizePurchaseRequest Contains everything needed to start the Authorization Process.
     * @param string $authorization The access token received from the initialize request. Provide this for client-side requests in the Bearer format.
     * @return Response PurchaseAuthorization endpoints always return the same object with different state of the purchase and different fields populated. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null.
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function authorizePayLaterWithAuthorization(
        AuthorizePurchaseRequest $authorizePurchaseRequest,
        string $authorization
    ): Response {
        $uri = '/purchase/authorize/paylater';

        $requestHeaderCollection = new RequestHeaderCollection(
            new RequestHeader('Authorization', 'Bearer ' . $authorization)
        );

        try {
            return $this->communicator->getGenericResponse(
                HttpMethod::POST,
                $uri,
                $requestHeaderCollection,
                $authorizePurchaseRequest,
                PurchaseOperationResponse::class
            );
        } catch (ResponseException $exception) {
            throw $this->createApiResponseException($exception);
        }
    }

    /**
     * Authorize a consumer to complete a transaction with our hosted solution. Can be started via SMS or URL.
     *
     * @param AuthorizePurchaseRequest $authorizePurchaseRequest Contains everything needed to start the Authorization Process.
     * @param string $paysafePlSecretKey Secret key which can be requested from your account manager. Provide this for server-to-server communication.
     * @return Response PurchaseAuthorization endpoints always return the same object with different state of the purchase and different fields populated. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null. PurchaseLifecycle endpoints also return the same object when an error occurs. The purchase object however will be null.
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function authorizePayLater(
        AuthorizePurchaseRequest $authorizePurchaseRequest,
        string $paysafePlSecretKey
    ): Response {
        $uri = '/purchase/authorize/paylater';

        $requestHeaderCollection = new RequestHeaderCollection(
            new RequestHeader('paysafe-pl-secret-key', $paysafePlSecretKey)
        );

        try {
            return $this->communicator->getGenericResponse(
                HttpMethod::POST,
                $uri,
                $requestHeaderCollection,
                $authorizePurchaseRequest,
                PurchaseOperationResponse::class
            );
        } catch (ResponseException $exception) {
            throw $this->createApiResponseException($exception);
        }
    }
}
