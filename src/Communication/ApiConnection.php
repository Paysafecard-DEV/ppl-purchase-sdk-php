<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Paysafe\PayLater\Exception\BuilderException;
use Paysafe\PayLater\Exception\ResponseException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

use const PHP_EOL;

class ApiConnection implements Connection
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * @var bool
     */
    protected $debug;

    /**
     * @param Client $client
     * @param LoggerInterface $logger
     * @param bool $debug
     */
    private function __construct(Client $client, LoggerInterface $logger = null, bool $debug = false)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->debug = $debug;
    }

    /**
     * @param Configuration $configuration
     * @return ApiConnection
     */
    public static function create(Configuration $configuration): self
    {
        $messageFormat = $configuration->isDebug() ?
            MessageFormatter::CLF . PHP_EOL . MessageFormatter::DEBUG :
            MessageFormatter::CLF;

        $stack = HandlerStack::create();
        if ($configuration->getLogger() instanceof LoggerInterface) {
            $stack->push(
                Middleware::log(
                    $configuration->getLogger(),
                    new MessageAnonymizerFormatter($messageFormat)
                )
            );
        }

        return new self(
            new Client([
                'base_uri' => $configuration->getBaseUrl(),
                'handler' => $stack,
                'debug' => $configuration->isDebug(),
                'http_errors' => true,
            ]),
            $configuration->getLogger(),
            $configuration->isDebug()
        );
    }

    /**
     * @param Client $client
     * @param LoggerInterface|null $logger
     * @param bool $debug
     * @return ApiConnection
     */
    public static function createWithClient(
        Client $client,
        LoggerInterface $logger = null,
        bool $debug = false
    ): self {
        return new self($client, $logger, $debug);
    }

    /**
     * @inheritDoc
     * @see http://docs.guzzlephp.org/en/stable/quickstart.html#exceptions
     * @throws BuilderException
     * @throws ResponseException
     */
    public function execute(
        string $httpMethod,
        string $relativePath,
        RequestHeaderCollection $requestHeaders,
        ?Request $requestBody = null
    ): ResponseInterface {
        try {
            return $this->client->send(
                new GuzzleRequest(
                    $httpMethod,
                    $relativePath,
                    $requestHeaders->getRequestHeadersAsArray($requestBody !== null),
                    $requestBody !== null ? RequestBuilder::toJson($requestBody) : null
                )
            );
        } catch (RequestException $exception) {
            $response = $exception->hasResponse() ? $exception->getResponse() : null;
            if ($response instanceof GuzzleResponse) {
                throw new ResponseException(
                    $response->getStatusCode(),
                    (string) $response->getBody(),
                    ResponseHeaderCollection::buildFromArray($response->getHeaders()),
                    $exception
                );
            }
            throw $this->getApiResponseException($exception);
        } catch (GuzzleException $exception) {
            throw $this->getApiResponseException($exception);
        }
    }

    /**
     * @param Throwable $exception
     * @return ResponseException
     */
    private function getApiResponseException(Throwable $exception): ResponseException
    {
        return new ResponseException(
            $exception->getCode(),
            $exception->getMessage(),
            new ResponseHeaderCollection(),
            $exception
        );
    }
}
