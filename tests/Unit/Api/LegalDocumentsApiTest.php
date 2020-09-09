<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Test\Unit\Api;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Paysafe\PayLater\Api\LegalDocumentsApi;
use Paysafe\PayLater\Exception\ApiResponseException;
use Paysafe\PayLater\Exception\BuilderException;

use function class_exists;

class LegalDocumentsApiTest extends AbstractApiTest
{
    /**
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function testTermsAndConditions(): void
    {
        $legalDocumentsApi = new LegalDocumentsApi(
            $this->createPaySafePayLaterCommunicator(200, [], '<html>testTermsAndConditions</html>')
        );
        self::assertSame(
            '<html>testTermsAndConditions</html>',
            $legalDocumentsApi->getTermsAndConditions('test12345', 'test-key')
        );
    }

    /**
     * @param int $statusCode
     * @param string $exceptionClass
     * @dataProvider exceptionDataProvider
     * @throws BuilderException
     */
    public function testTermsAndConditionsExceptions(
        int $statusCode,
        string $exceptionClass,
        string $message
    ): void {
        $legalDocumentsApi = new LegalDocumentsApi(
            $this->createPaySafePayLaterCommunicatorException(
                new RequestException(
                    'Error Communicating with Server',
                    new Request('GET', '/termsandconditions/'),
                    new Response($statusCode, ['test-header' => $exceptionClass], $exceptionClass)
                )
            )
        );

        try {
            $legalDocumentsApi->getTermsAndConditions('test12345', 'test-key');
        } catch (ApiResponseException $exception) {
            if (class_exists($exceptionClass)) {
                self::assertInstanceOf($exceptionClass, $exception);
            }
            self::assertSame($statusCode, $exception->getCode());
            self::assertSame($exceptionClass, $exception->getResponseBody());
            self::assertSame($message, $exception->getMessage());
            self::assertTrue($exception->getResponseHeaders()->hasResponseHeader('test-header'));
        }
    }

    /**
     * @throws ApiResponseException
     * @throws BuilderException
     */
    public function testTermsAndConditionsWithAuthorization(): void
    {
        $legalDocumentsApi = new LegalDocumentsApi(
            $this->createPaySafePayLaterCommunicator(200, [], '<html>testTermsAndConditionsWithAuthorization</html>')
        );
        self::assertSame(
            '<html>testTermsAndConditionsWithAuthorization</html>',
            $legalDocumentsApi->getTermsAndConditionsWithAuthorization('test12345', 'test-authorization')
        );
    }

    /**
     * @param int $statusCode
     * @param string $exceptionClass
     * @dataProvider exceptionDataProvider
     * @throws BuilderException
     */
    public function testTermsAndConditionsWithAuthorizationExceptions(
        int $statusCode,
        string $exceptionClass,
        string $message
    ): void {
        $legalDocumentsApi = new LegalDocumentsApi(
            $this->createPaySafePayLaterCommunicatorException(
                new RequestException(
                    'Error Communicating with Server',
                    new Request('GET', '/termsAndConditionsWithAuthorization/'),
                    new Response($statusCode, ['test-header' => $exceptionClass], $exceptionClass)
                )
            )
        );

        try {
            $legalDocumentsApi->getTermsAndConditionsWithAuthorization('test12345', 'test-authorization');
        } catch (ApiResponseException $exception) {
            if (class_exists($exceptionClass)) {
                self::assertInstanceOf($exceptionClass, $exception);
            }
            self::assertSame($statusCode, $exception->getCode());
            self::assertSame($exceptionClass, $exception->getResponseBody());
            self::assertSame($message, $exception->getMessage());
            self::assertTrue($exception->getResponseHeaders()->hasResponseHeader('test-header'));
        }
    }
}
