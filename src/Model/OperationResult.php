<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 *
 * This class is based on the Paysafe Pay Later OpenAPI specification, version 1.0.0.
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Model;

use DateTime;

// phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
// phpcs:disable ObjectCalisthenics.Metrics.PropertyPerClassLimit

/**
 * Describes the result of an operation performed on a purchase.
 */
class OperationResult
{
    /**
     * @var string|null
     */
    private $operationId;

    /**
     * @var OperationStatus|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $statusCode;

    /**
     * @var string|null
     */
    private $statusMessage;

    /**
     * @var DateTime|null
     */
    private $processingStart;

    /**
     * @var DateTime|null
     */
    private $processingEnd;

    /**
     * @param string|null $operationId
     * @param OperationStatus|null $status
     * @param string|null $statusCode
     * @param string|null $statusMessage
     * @param DateTime|null $processingStart
     * @param DateTime|null $processingEnd
     */
    public function __construct(
        string $operationId = null,
        OperationStatus $status = null,
        string $statusCode = null,
        string $statusMessage = null,
        DateTime $processingStart = null,
        DateTime $processingEnd = null
    ) {
        $this->operationId = $operationId;
        $this->status = $status;
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
        $this->processingStart = $processingStart;
        $this->processingEnd = $processingEnd;
    }

    /**
     * Unique identifier of the operation performed.
     * @return string|null
     */
    public function getOperationId(): ?string
    {
        return $this->operationId;
    }

    /**
     * @param string $operationId
     * @return OperationResult
     */
    public function setOperationId(string $operationId): OperationResult
    {
        $this->operationId = $operationId;
        return $this;
    }

    /**
     * @return OperationStatus|null
     */
    public function getStatus(): ?OperationStatus
    {
        return $this->status;
    }

    /**
     * @param OperationStatus $status
     * @return OperationResult
     */
    public function setStatus(OperationStatus $status): OperationResult
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Code:  * `0.0.0` - \"Operation performed sucessfully\"  * `0.0.1` - \"Duplicate request: Operation already performed sucessfully\"  * `1.0.0` - \"Operation performed sucessfully. Final result pending\"  * `2.0.0` - \"Operation permanently declined\"  * `2.1.0` - \"Operation declined (retryable)\"  * `2.1.1` - \"Customer has exceeded limit\"  * `3.0.0` - \"Missing field\"  * `3.1.0` - \"Invalid input data\"  * `4.0.0` - \"Incorrect workflow state\"  * `4.1.0` - \"Wrong purchase state\"  * `4.2.0` - \"Unknown reference\"  * `4.3.0` - \"Invalid product\"  * `4.4.0` - \"Duplicate request\"  * `4.5.0` - \"User not authorized\"  * `4.5.1` - \"User not authorized. Product inactive\"  * `5.0.0` - \"Internal error\"  * `5.1.0` - \"Processing service unavailable (retryable)\"  * `6.0.0` - \"Internal error: Operation result undefined\"
     * @return string|null
     */
    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    /**
     * @param string $statusCode
     * @return OperationResult
     */
    public function setStatusCode(string $statusCode): OperationResult
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * A human-readable description giving additional information about the result status.
     * @return string|null
     */
    public function getStatusMessage(): ?string
    {
        return $this->statusMessage;
    }

    /**
     * @param string $statusMessage
     * @return OperationResult
     */
    public function setStatusMessage(string $statusMessage): OperationResult
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }

    /**
     * Timestamp when operation processing has started.
     * @return DateTime|null
     */
    public function getProcessingStart(): ?DateTime
    {
        return $this->processingStart;
    }

    /**
     * @param DateTime $processingStart
     * @return OperationResult
     */
    public function setProcessingStart(DateTime $processingStart): OperationResult
    {
        $this->processingStart = $processingStart;
        return $this;
    }

    /**
     * Timestamp when operation processing has finished.
     * @return DateTime|null
     */
    public function getProcessingEnd(): ?DateTime
    {
        return $this->processingEnd;
    }

    /**
     * @param DateTime $processingEnd
     * @return OperationResult
     */
    public function setProcessingEnd(DateTime $processingEnd): OperationResult
    {
        $this->processingEnd = $processingEnd;
        return $this;
    }
}
