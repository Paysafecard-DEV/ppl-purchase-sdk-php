<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Test\Unit\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Paysafe\PayLater\Communication\ApiConnection;
use Paysafe\PayLater\Communication\PaySafePayLaterCommunicator;
use Paysafe\PayLater\Exception\ApiResponseException;
use Paysafe\PayLater\Exception\AuthorizationException;
use Paysafe\PayLater\Exception\ReferenceException;
use Paysafe\PayLater\Exception\ServerErrorException;
use Paysafe\PayLater\Exception\ValidationException;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

abstract class AbstractApiTest extends TestCase
{
    /**
     * @param int $statusCode
     * @param array<string, string> $headers,
     * @param string $responseBody
     * @return PaySafePayLaterCommunicator
     */
    protected function createPaySafePayLaterCommunicator(
        int $statusCode = 200,
        array $headers = [],
        string $responseBody = ''
    ): PaySafePayLaterCommunicator {
        $mockHandler = new MockHandler([
            new Response($statusCode, $headers, $responseBody),
        ]);
        return $this->getPaySafePayLaterCommunicator($mockHandler);
    }

    /**
     * @param GuzzleException ...$exceptions
     * @return PaySafePayLaterCommunicator
     */
    protected function createPaySafePayLaterCommunicatorException(
        GuzzleException ...$exceptions
    ): PaySafePayLaterCommunicator {
        $mockHandler = new MockHandler($exceptions);
        return $this->getPaySafePayLaterCommunicator($mockHandler);
    }

    /**
     * @param MockHandler $mockHandler
     * @return PaySafePayLaterCommunicator
     */
    private function getPaySafePayLaterCommunicator(MockHandler $mockHandler): PaySafePayLaterCommunicator
    {
        return new PaySafePayLaterCommunicator(
            ApiConnection::createWithClient(
                new Client([
                    'handler' => HandlerStack::create($mockHandler),
                ]),
                new TestLogger(),
                false
            )
        );
    }

    /**
     * @return array<string, array>
     */
    // phpcs:ignore ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff
    public function exceptionDataProvider(): array
    {
        return [
            'ValidationException: 400' => [
                400,
                ValidationException::class,
                'the Paysafe Pay Later platform returned an incorrect request error response',
            ],
            'AuthorizationException: 401' => [
                401,
                AuthorizationException::class,
                'the Paysafe Pay Later platform returned an authorization error response',
            ],
            'AuthorizationException: 403' => [
                403,
                AuthorizationException::class,
                'the Paysafe Pay Later platform returned an authorization error response',
            ],
            'ReferenceException: 404' => [
                404,
                ReferenceException::class,
                'the Paysafe Pay Later platform returned a reference error response',
            ],
            'ReferenceException: 409' => [
                409,
                ReferenceException::class,
                'the Paysafe Pay Later platform returned a reference error response',
            ],
            'ReferenceException: 410' => [
                410,
                ReferenceException::class,
                'the Paysafe Pay Later platform returned a reference error response',
            ],
            'ServerErrorException: 500' => [
                500,
                ServerErrorException::class,
                'the Paysafe Pay Later platform returned an error response',
            ],
            'ServerErrorException: 502' => [
                502,
                ServerErrorException::class,
                'the Paysafe Pay Later platform returned an error response',
            ],
            'ServerErrorException: 503' => [
                503,
                ServerErrorException::class,
                'the Paysafe Pay Later platform returned an error response',
            ],
            'ApiResponseException' => [
                200,
                ApiResponseException::class,
                '',
            ],
        ];
    }
}
