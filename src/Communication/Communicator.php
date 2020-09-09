<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

use Paysafe\PayLater\Exception\BuilderException;
use Paysafe\PayLater\Exception\ResponseException;
use Paysafe\PayLater\Model\ResponseWithAuthorization;

interface Communicator
{
    /**
     * @param string $httpMethod
     * @param string $relativePath
     * @param RequestHeaderCollection $requestHeaderCollection ,
     * @param Request|null $requestBody
     * @return string
     * @throws BuilderException
     * @throws ResponseException
     */
    public function getStringResponse(
        string $httpMethod,
        string $relativePath,
        RequestHeaderCollection $requestHeaderCollection,
        ?Request $requestBody
    ): string;

    /**
     * @param string $httpMethod
     * @param string $relativePath
     * @param RequestHeaderCollection $requestHeaderCollection
     * @param Request|null $requestBody
     * @param string $responseClass
     * @return Response
     * @throws BuilderException
     * @throws ResponseException
     */
    public function getGenericResponse(
        string $httpMethod,
        string $relativePath,
        RequestHeaderCollection $requestHeaderCollection,
        ?Request $requestBody,
        string $responseClass
    ): Response;

    /**
     * @param string $httpMethod
     * @param string $relativePath
     * @param RequestHeaderCollection $requestHeaderCollection
     * @param Request|null $requestBody
     * @param string $responseClass
     * @return ResponseWithAuthorization
     * @throws BuilderException
     * @throws ResponseException
     */
    public function getResponseWithAuthorization(
        string $httpMethod,
        string $relativePath,
        RequestHeaderCollection $requestHeaderCollection,
        ?Request $requestBody,
        string $responseClass
    ): ResponseWithAuthorization;
}
