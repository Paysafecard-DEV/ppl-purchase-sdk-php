<?php

declare(strict_types=1);

namespace Paysafe\PayLater\Exception;

use Paysafe\PayLater\Communication\ResponseHeaderCollection;
use Paysafe\PayLater\Model\OperationResult;
use Throwable;

class ApiResponseException extends PaysafePayLaterException
{
    /**
     * @var string
     */
    private $responseBody;

    /**
     * @var ResponseHeaderCollection
     */
    private $responseHeaders;

    /**
     * @var string|null
     */
    private $errorId;

    /**
     * @var OperationResult|null
     */
    private $operationResult;

    /**
     * @param string $errorMessage
     * @param int $statusCode
     * @param string $responseBody,
     * @param ResponseHeaderCollection $responseHeaders
     * @param Throwable|null $previous
     * @param string|null $errorId,
     * @param OperationResult|null $operationResult
     */
    public function __construct(
        string $errorMessage,
        int $statusCode,
        string $responseBody,
        ResponseHeaderCollection $responseHeaders,
        ?string $errorId,
        ?OperationResult $operationResult,
        ?Throwable $previous = null
    ) {
        parent::__construct($errorMessage, $statusCode, $previous);
        $this->responseBody = $responseBody;
        $this->responseHeaders = $responseHeaders;
        $this->errorId = $errorId;
        $this->operationResult = $operationResult;
    }

    /**
     * @return string
     */
    public function getResponseBody(): string
    {
        return $this->responseBody;
    }

    /**
     * @return ResponseHeaderCollection
     */
    public function getResponseHeaders(): ResponseHeaderCollection
    {
        return $this->responseHeaders;
    }

    /**
     * @return string|null
     */
    public function getErrorId(): ?string
    {
        return $this->errorId;
    }

    /**
     * @return OperationResult|null
     */
    public function getOperationResult(): ?OperationResult
    {
        return $this->operationResult;
    }
}
