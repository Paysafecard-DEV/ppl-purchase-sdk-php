<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Exception;

use Paysafe\PayLater\Communication\ResponseHeaderCollection;
use Throwable;

class ResponseException extends PaysafePayLaterException
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $body;

    /**
     * @var ResponseHeaderCollection
     */
    private $responseHeaderCollection;

    /**
     * @param int $statusCode
     * @param string $body
     * @param ResponseHeaderCollection $responseHeaderCollection
     * @param Throwable|null $previous
     */
    public function __construct(
        int $statusCode,
        string $body,
        ResponseHeaderCollection $responseHeaderCollection,
        ?Throwable $previous = null
    ) {
        parent::__construct('The Paysafe Pay Later platform returned an error response', 0, $previous);
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->responseHeaderCollection = $responseHeaderCollection;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return ResponseHeaderCollection
     */
    public function getResponseHeaderCollection(): ResponseHeaderCollection
    {
        return $this->responseHeaderCollection;
    }
}
