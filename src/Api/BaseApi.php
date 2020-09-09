<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Api;

use Paysafe\PayLater\Communication\Communicator;
use Paysafe\PayLater\Communication\ResponseBuilder;
use Paysafe\PayLater\Communication\ResponseHeaderCollection;
use Paysafe\PayLater\Exception\ApiResponseException;
use Paysafe\PayLater\Exception\AuthorizationException;
use Paysafe\PayLater\Exception\BuilderException;
use Paysafe\PayLater\Exception\ReferenceException;
use Paysafe\PayLater\Exception\ResponseException;
use Paysafe\PayLater\Exception\ServerErrorException;
use Paysafe\PayLater\Exception\ValidationException;
use Paysafe\PayLater\Model\OperationResult;
use Paysafe\PayLater\Model\PurchaseOperationResponse;
use Throwable;

use function json_decode;
use function json_last_error;
use function sprintf;
use function str_replace;

use const JSON_ERROR_NONE;

abstract class BaseApi
{
    /**
     * @var Communicator
     */
    protected $communicator;

    /**
     * @param Communicator $communicator
     */
    public function __construct(Communicator $communicator)
    {
        $this->communicator = $communicator;
    }

    /**
     * @param string $uri
     * @param string $key
     * @param string $value
     * @return string
     */
    protected function populateUri(string $uri, string $key, string $value): string
    {
        $key = sprintf('{%s}', $key);
        return str_replace($key, $value, $uri);
    }

    /**
     * @param ResponseException $responseException
     * @return ApiResponseException
     * @throws BuilderException
     */
    protected function createApiResponseException(ResponseException $responseException): ApiResponseException
    {
        $purchaseOperationResponse = null;
        if ($this->isJsonResponse($responseException->getBody()) === true) {
            $purchaseOperationResponse = ResponseBuilder::build(
                PurchaseOperationResponse::class,
                json_decode($responseException->getBody(), true)
            );
        }
        $operationResult = $purchaseOperationResponse instanceof PurchaseOperationResponse ?
            $purchaseOperationResponse->getResult() :
            null;

        return $this->getApiResponseException(
            $responseException->getStatusCode(),
            $responseException->getBody(),
            $responseException->getResponseHeaderCollection(),
            $operationResult,
            $responseException->getPrevious()
        );
    }

    /**
     * @param string $responseBody
     * @return bool
     */
    private function isJsonResponse(string $responseBody): bool
    {
        json_decode($responseBody, true);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    // phpcs:disable Generic.Metrics.CyclomaticComplexity.TooHigh
    // phpcs:disable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff

    /**
     * @param int $statusCode
     * @param string $responseBody
     * @param ResponseHeaderCollection $responseHeaders
     * @param OperationResult|null $operationResult,
     * @param Throwable|null $previous
     * @return ApiResponseException
     */
    private function getApiResponseException(
        int $statusCode,
        string $responseBody,
        ResponseHeaderCollection $responseHeaders,
        ?OperationResult $operationResult,
        ?Throwable $previous = null
    ): ApiResponseException {
        $errorId = $operationResult instanceof OperationResult ? $operationResult->getStatusCode() : null;
        $message = $operationResult instanceof OperationResult ? $operationResult->getStatusMessage() : null;
        switch ($statusCode) {
            case 400:
                return new ValidationException(
                    $statusCode,
                    $responseBody,
                    $responseHeaders,
                    $errorId,
                    $message,
                    $operationResult,
                    $previous
                );
            case 401:
            case 403:
                return new AuthorizationException(
                    $statusCode,
                    $responseBody,
                    $responseHeaders,
                    $errorId,
                    $message,
                    $operationResult,
                    $previous
                );
            case 404:
            case 409:
            case 410:
                return new ReferenceException(
                    $statusCode,
                    $responseBody,
                    $responseHeaders,
                    $errorId,
                    $message,
                    $operationResult,
                    $previous
                );
            case 500:
            case 502:
            case 503:
                return new ServerErrorException(
                    $statusCode,
                    $responseBody,
                    $responseHeaders,
                    $errorId,
                    $message,
                    $operationResult,
                    $previous
                );
            default:
                $message = $message !== null ? $message : '';
                return new ApiResponseException(
                    $message,
                    $statusCode,
                    $responseBody,
                    $responseHeaders,
                    $message,
                    $operationResult,
                    $previous
                );
        }
    }

    // phpcs:enable ObjectCalisthenics.Files.FunctionLength.ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff
    // phpcs:enable Generic.Metrics.CyclomaticComplexity.TooHigh
}
