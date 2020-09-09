<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Test\Unit\Api;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response;
use Paysafe\PayLater\Api\PurchaseAuthorizationApi;
use Paysafe\PayLater\Communication\RequestBuilder;
use Paysafe\PayLater\Communication\RequestHeader;
use Paysafe\PayLater\Communication\RequestHeaderCollection;
use Paysafe\PayLater\Exception\ApiResponseException;
use Paysafe\PayLater\Exception\BuilderException;
use Paysafe\PayLater\Model\AuthorizePurchaseRequest;
use Paysafe\PayLater\Model\MethodType;
use Paysafe\PayLater\Model\PurchaseOperationResponse;

use function class_exists;

class PurchaseAuthorizationApiTest extends AbstractApiTest
{
    /**
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function testAuthorizePayLater(): void
    {
        $api = new PurchaseAuthorizationApi(
            $this->createPaySafePayLaterCommunicator(
                200,
                [],
                '{"result": {"status": "OK"},"purchase": {"purchaseId": "CID-test1234567890"}}'
            )
        );

        /** @var PurchaseOperationResponse $result */
        $result = $api->authorizePayLater(
            new AuthorizePurchaseRequest('CID-test1234567890', new MethodType(MethodType::URL)),
            'test-secret-key'
        );

        self::assertInstanceOf(PurchaseOperationResponse::class, $result);
    }

    /**
     * @param int $statusCode
     * @param string $exceptionClass
     * @dataProvider exceptionDataProvider
     * @throws BuilderException
     */
    // phpcs:ignore ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff
    public function testAuthorizePayLaterExceptions(
        int $statusCode,
        string $exceptionClass,
        string $message
    ): void {
        $purchaseAuthorizationApi = new PurchaseAuthorizationApi(
            $this->createPaySafePayLaterCommunicatorException(
                new RequestException(
                    'Error Communicating with Server',
                    new GuzzleRequest(
                        'POST',
                        '/purchase/authorize/paylater',
                        (new RequestHeaderCollection(
                            new RequestHeader('paysafe-pl-secret-key', 'test-secret-key')
                        )
                        )->getRequestHeadersAsArray(),
                        RequestBuilder::toJson(
                            new AuthorizePurchaseRequest('CID-test1234567890', new MethodType(MethodType::URL))
                        )
                    ),
                    new Response($statusCode, [], $exceptionClass)
                )
            )
        );

        try {
            $purchaseAuthorizationApi->authorizePayLater(
                new AuthorizePurchaseRequest('CID-test1234567890', new MethodType(MethodType::URL)),
                'test-secret-key'
            );
        } catch (ApiResponseException $exception) {
            if (class_exists($exceptionClass)) {
                self::assertInstanceOf($exceptionClass, $exception);
            }
            self::assertSame($statusCode, $exception->getCode());
            self::assertSame($exceptionClass, $exception->getResponseBody());
            self::assertSame($message, $exception->getMessage());
        }
    }

    /**
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function testAuthorizePayLaterWithAuthorization(): void
    {
        $api = new PurchaseAuthorizationApi(
            $this->createPaySafePayLaterCommunicator(
                200,
                [],
                '{"result": {"status": "OK"},"purchase": {"purchaseId": "CID-test1234567890"}}'
            )
        );

        /** @var PurchaseOperationResponse $result */
        $result = $api->authorizePayLaterWithAuthorization(
            new AuthorizePurchaseRequest('CID-test1234567890', new MethodType(MethodType::URL)),
            'test-authorization-key'
        );

        self::assertInstanceOf(PurchaseOperationResponse::class, $result);
    }

    /**
     * @param int $statusCode
     * @param string $exceptionClass
     * @dataProvider exceptionDataProvider
     * @throws BuilderException
     */
    // phpcs:ignore ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff
    public function testAuthorizePayLaterWithAuthorizationExceptions(
        int $statusCode,
        string $exceptionClass,
        string $message
    ): void {
        $purchaseAuthorizationApi = new PurchaseAuthorizationApi(
            $this->createPaySafePayLaterCommunicatorException(
                new RequestException(
                    'Error Communicating with Server',
                    new GuzzleRequest(
                        'POST',
                        '/purchase/authorize/paylater',
                        (new RequestHeaderCollection(
                            new RequestHeader('Authorization', 'Bearer test-authorization-key')
                        )
                        )->getRequestHeadersAsArray(true),
                        RequestBuilder::toJson(
                            new AuthorizePurchaseRequest('CID-test1234567890', new MethodType(MethodType::URL))
                        )
                    ),
                    new Response($statusCode, [], $exceptionClass)
                )
            )
        );

        try {
            $purchaseAuthorizationApi->authorizePayLaterWithAuthorization(
                new AuthorizePurchaseRequest('CID-test1234567890', new MethodType(MethodType::URL)),
                'test-authorization-key'
            );
        } catch (ApiResponseException $exception) {
            if (class_exists($exceptionClass)) {
                self::assertInstanceOf($exceptionClass, $exception);
            }
            self::assertSame($statusCode, $exception->getCode());
            self::assertSame($exceptionClass, $exception->getResponseBody());
            self::assertSame($message, $exception->getMessage());
        }
    }
}
