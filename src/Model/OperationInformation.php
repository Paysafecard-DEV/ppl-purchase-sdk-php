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

class OperationInformation
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
     * @var DateTime|null
     */
    private $processingDate;

    /**
     * @var Amount|null
     */
    private $operationAmount;

    /**
     * @param string|null $operationId
     * @param OperationStatus|null $status
     * @param DateTime|null $processingDate
     * @param Amount|null $operationAmount
     */
    public function __construct(
        string $operationId = null,
        OperationStatus $status = null,
        DateTime $processingDate = null,
        Amount $operationAmount = null
    ) {
        $this->operationId = $operationId;
        $this->status = $status;
        $this->processingDate = $processingDate;
        $this->operationAmount = $operationAmount;
    }

    /**
     * @return string|null
     */
    public function getOperationId(): ?string
    {
        return $this->operationId;
    }

    /**
     * @param string $operationId
     * @return OperationInformation
     */
    public function setOperationId(string $operationId): OperationInformation
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
     * @return OperationInformation
     */
    public function setStatus(OperationStatus $status): OperationInformation
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getProcessingDate(): ?DateTime
    {
        return $this->processingDate;
    }

    /**
     * @param DateTime $processingDate
     * @return OperationInformation
     */
    public function setProcessingDate(DateTime $processingDate): OperationInformation
    {
        $this->processingDate = $processingDate;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getOperationAmount(): ?Amount
    {
        return $this->operationAmount;
    }

    /**
     * @param Amount $operationAmount
     * @return OperationInformation
     */
    public function setOperationAmount(Amount $operationAmount): OperationInformation
    {
        $this->operationAmount = $operationAmount;
        return $this;
    }
}
