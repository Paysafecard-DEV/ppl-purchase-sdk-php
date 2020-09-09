<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

use Paysafe\PayLater\Exception\ResponseException;
use Paysafe\PayLater\Model\ResponseWithAuthorization;

use function count;
use function json_decode;
use function reset;

class PaySafePayLaterCommunicator implements Communicator
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritDoc
     */
    public function getStringResponse(
        string $httpMethod,
        string $relativePath,
        RequestHeaderCollection $requestHeaderCollection,
        ?Request $requestBody
    ): string {
        $response = $this->connection->execute($httpMethod, $relativePath, $requestHeaderCollection, $requestBody);
        return (string) $response->getBody();
    }

    /**
     * @inheritDoc
     */
    public function getGenericResponse(
        string $httpMethod,
        string $relativePath,
        RequestHeaderCollection $requestHeaderCollection,
        ?Request $requestBody,
        string $responseClass
    ): Response {
        $response = $this->connection->execute($httpMethod, $relativePath, $requestHeaderCollection, $requestBody);
        return ResponseBuilder::build($responseClass, json_decode((string) $response->getBody(), true));
    }

    /**
     * @inheritDoc
     */
    public function getResponseWithAuthorization(
        string $httpMethod,
        string $relativePath,
        RequestHeaderCollection $requestHeaderCollection,
        ?Request $requestBody,
        string $responseClass
    ): ResponseWithAuthorization {
        $response = $this->connection->execute($httpMethod, $relativePath, $requestHeaderCollection, $requestBody);

        $accessToken = null;
        $accessTokenArray = $response->getHeader('access_token');
        if (count($accessTokenArray) === 1) {
            $accessToken = reset($accessTokenArray);
        }

        if ($accessToken === null) {
            throw new ResponseException(
                500,
                'Response does not contain a access_token header',
                ResponseHeaderCollection::buildFromArray($response->getHeaders())
            );
        }

        return new ResponseWithAuthorization(
            $accessToken,
            ResponseBuilder::build($responseClass, json_decode((string) $response->getBody(), true))
        );
    }
}
