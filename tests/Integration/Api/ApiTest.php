<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Test\Integration\Api;

use Paysafe\PayLater\Api\LegalDocumentsApi;
use Paysafe\PayLater\Api\PurchaseAuthorizationApi;
use Paysafe\PayLater\Api\PurchaseLifecycleApi;
use Paysafe\PayLater\Exception\ApiResponseException;
use Paysafe\PayLater\Exception\BuilderException;
use Paysafe\PayLater\Model\Amount;
use Paysafe\PayLater\Model\AuthorizePurchaseRequest;
use Paysafe\PayLater\Model\Consumer;
use Paysafe\PayLater\Model\Currency;
use Paysafe\PayLater\Model\InitializePurchaseRequest;
use Paysafe\PayLater\Model\MethodType;
use Paysafe\PayLater\Model\OperationResult;
use Paysafe\PayLater\Model\OperationStatus;
use Paysafe\PayLater\Model\Person;
use Paysafe\PayLater\Model\PurchaseInformation;
use Paysafe\PayLater\Model\PurchaseOperationResponse;
use Paysafe\PayLater\Model\PurchaseState;
use Paysafe\PayLater\Model\ResponseWithAuthorization;

// phpcs:disable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff

class ApiTest extends AbstractApiTest
{
    /**
     * @return ResponseWithAuthorization
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function testInitializePurchase(): ResponseWithAuthorization
    {
        $purchaseLifecycleApi = new PurchaseLifecycleApi($this->createPaySafePayLaterCommunicator());
        $result = $purchaseLifecycleApi->initializePurchase(
            new InitializePurchaseRequest(
                new Amount(25000, new Currency(Currency::EUR)),
                new Consumer(
                    new Person('Dhr', 'Test', 'Demo')
                )
            ),
            $this->getSecretKey()
        );

        // Make sure the authorization code is a valid JWT (using regex)
        self::assertRegExp('/^[A-Za-z0-9-_=]+\.[A-Za-z0-9-_=]+\.?[A-Za-z0-9-_.+\/=]*$/', $result->getAuthorization());

        /** @var PurchaseOperationResponse $response */
        $response = $result->getResponse();

        /** @var OperationResult $operationResult */
        $operationResult = $response->getResult();
        self::assertInstanceOf(OperationResult::class, $operationResult);

        /** @var OperationStatus $operationStatus */
        $operationStatus = $operationResult->getStatus();
        self::assertInstanceOf(OperationStatus::class, $operationStatus);
        self::assertSame(OperationStatus::OK, $operationStatus->getValue());

        return $result;
    }

    /**
     * @param ResponseWithAuthorization $responseWithAuthorization
     * @depends testInitializePurchase
     * @throws BuilderException
     * @throws ApiResponseException
     */
    public function testGetPurchaseWithAuthorization(ResponseWithAuthorization $responseWithAuthorization): void
    {
        $purchaseLifecycleApi = new PurchaseLifecycleApi($this->createPaySafePayLaterCommunicator());

        /** @var PurchaseOperationResponse $response */
        $response = $responseWithAuthorization->getResponse();

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $response->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        /** @var PurchaseOperationResponse $purchaseOperationResponse */
        $purchaseOperationResponse = $purchaseLifecycleApi->getPurchaseWithAuthorization(
            (string) $purchaseInformation->getPurchaseId(),
            $responseWithAuthorization->getAuthorization()
        );

        /** @var OperationResult $operationResult */
        $operationResult = $purchaseOperationResponse->getResult();
        self::assertInstanceOf(OperationResult::class, $operationResult);

        /** @var OperationStatus $operationStatus */
        $operationStatus = $operationResult->getStatus();
        self::assertInstanceOf(OperationStatus::class, $operationStatus);
        self::assertSame(OperationStatus::OK, $operationStatus->getValue());

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $purchaseOperationResponse->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        /** @var PurchaseState $purchaseState */
        $purchaseState = $purchaseInformation->getState();
        self::assertInstanceOf(PurchaseState::class, $purchaseState);
        self::assertSame(PurchaseState::INITIALIZED, $purchaseState->getValue());
    }

    /**
     * @param ResponseWithAuthorization $responseWithAuthorization
     * @depends testInitializePurchase
     * @throws BuilderException
     * @throws ApiResponseException
     */
    public function testGetPurchase(ResponseWithAuthorization $responseWithAuthorization): void
    {
        $purchaseLifecycleApi = new PurchaseLifecycleApi($this->createPaySafePayLaterCommunicator());

        /** @var PurchaseOperationResponse $response */
        $response = $responseWithAuthorization->getResponse();

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $response->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        /** @var PurchaseOperationResponse $purchaseOperationResponse */
        $purchaseOperationResponse = $purchaseLifecycleApi->getPurchase(
            (string) $purchaseInformation->getPurchaseId(),
            $this->getSecretKey()
        );

        /** @var OperationResult $operationResult */
        $operationResult = $purchaseOperationResponse->getResult();
        self::assertInstanceOf(OperationResult::class, $operationResult);

        /** @var OperationStatus $operationStatus */
        $operationStatus = $operationResult->getStatus();
        self::assertInstanceOf(OperationStatus::class, $operationStatus);
        self::assertSame(OperationStatus::OK, $operationStatus->getValue());

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $purchaseOperationResponse->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        /** @var PurchaseState $purchaseState */
        $purchaseState = $purchaseInformation->getState();
        self::assertInstanceOf(PurchaseState::class, $purchaseState);
        self::assertSame(PurchaseState::INITIALIZED, $purchaseState->getValue());
    }

    /**
     * @param ResponseWithAuthorization $responseWithAuthorization
     * @depends testInitializePurchase
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function testAuthorizePaylater(ResponseWithAuthorization $responseWithAuthorization): void
    {
        $purchaseAuthorizationApi = new PurchaseAuthorizationApi($this->createPaySafePayLaterCommunicator());

        /** @var PurchaseOperationResponse $response */
        $response = $responseWithAuthorization->getResponse();

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $response->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        /** @var PurchaseOperationResponse $purchaseOperationResponse */
        $purchaseOperationResponse = $purchaseAuthorizationApi->authorizePayLater(
            new AuthorizePurchaseRequest(
                (string) $purchaseInformation->getPurchaseId(),
                new MethodType(MethodType::URL)
            ),
            $this->getSecretKey()
        );

        /** @var OperationResult $operationResult */
        $operationResult = $purchaseOperationResponse->getResult();
        self::assertInstanceOf(OperationResult::class, $operationResult);

        /** @var OperationStatus $operationStatus */
        $operationStatus = $operationResult->getStatus();
        self::assertInstanceOf(OperationStatus::class, $operationStatus);
        self::assertSame(OperationStatus::OK, $operationStatus->getValue());

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $purchaseOperationResponse->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        /** @var PurchaseState $purchaseState */
        $purchaseState = $purchaseInformation->getState();
        self::assertInstanceOf(PurchaseState::class, $purchaseState);
        self::assertSame(PurchaseState::INITIALIZED, $purchaseState->getValue());

        /** @var array<string, string> $metaData */
        $metaData = $purchaseInformation->getMetaData();
        self::assertIsArray($metaData);
        self::assertArrayHasKey('INSTORE_SELFSERVICE_AUTH_URL', $metaData);
    }

    /**
     * @param ResponseWithAuthorization $responseWithAuthorization
     * @depends testInitializePurchase
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function testAuthorizePaylaterWithAuthorization(ResponseWithAuthorization $responseWithAuthorization): void
    {
        $purchaseAuthorizationApi = new PurchaseAuthorizationApi($this->createPaySafePayLaterCommunicator());

        /** @var PurchaseOperationResponse $response */
        $response = $responseWithAuthorization->getResponse();

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $response->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        /** @var PurchaseOperationResponse $purchaseOperationResponse */
        $purchaseOperationResponse = $purchaseAuthorizationApi->authorizePayLaterWithAuthorization(
            new AuthorizePurchaseRequest(
                (string) $purchaseInformation->getPurchaseId(),
                new MethodType(MethodType::URL)
            ),
            $responseWithAuthorization->getAuthorization()
        );

        /** @var OperationResult $operationResult */
        $operationResult = $purchaseOperationResponse->getResult();
        self::assertInstanceOf(OperationResult::class, $operationResult);

        /** @var OperationStatus $operationStatus */
        $operationStatus = $operationResult->getStatus();
        self::assertInstanceOf(OperationStatus::class, $operationStatus);
        self::assertSame(OperationStatus::OK, $operationStatus->getValue());

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $purchaseOperationResponse->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        /** @var PurchaseState $purchaseState */
        $purchaseState = $purchaseInformation->getState();
        self::assertInstanceOf(PurchaseState::class, $purchaseState);
        self::assertSame(PurchaseState::INITIALIZED, $purchaseState->getValue());

        /** @var array<string, string> $metaData */
        $metaData = $purchaseInformation->getMetaData();
        self::assertIsArray($metaData);
        self::assertArrayHasKey('INSTORE_SELFSERVICE_AUTH_URL', $metaData);
    }

    /**
     * @param ResponseWithAuthorization $responseWithAuthorization
     * @depends testInitializePurchase
     * @throws BuilderException
     * @throws ApiResponseException
     */
    public function testTermsAndConditions(ResponseWithAuthorization $responseWithAuthorization): void
    {
        $legalDocumentsApi = new LegalDocumentsApi($this->createPaySafePayLaterCommunicator());

        /** @var PurchaseOperationResponse $response */
        $response = $responseWithAuthorization->getResponse();

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $response->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        self::assertNotEmpty($legalDocumentsApi->getTermsAndConditions(
            (string) $purchaseInformation->getPurchaseId(),
            $this->getSecretKey()
        ));
    }

    /**
     * @param ResponseWithAuthorization $responseWithAuthorization
     * @depends testInitializePurchase
     * @throws BuilderException
     * @throws ApiResponseException
     */
    public function testTermsAndConditionsWithAuthorization(ResponseWithAuthorization $responseWithAuthorization): void
    {
        $legalDocumentsApi = new LegalDocumentsApi($this->createPaySafePayLaterCommunicator());

        /** @var PurchaseOperationResponse $response */
        $response = $responseWithAuthorization->getResponse();

        /** @var PurchaseInformation $purchaseInformation */
        $purchaseInformation = $response->getPurchase();
        self::assertInstanceOf(PurchaseInformation::class, $purchaseInformation);

        self::assertNotEmpty($legalDocumentsApi->getTermsAndConditionsWithAuthorization(
            (string) $purchaseInformation->getPurchaseId(),
            $responseWithAuthorization->getAuthorization()
        ));
    }
}
