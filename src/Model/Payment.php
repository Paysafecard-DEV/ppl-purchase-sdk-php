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

class Payment
{
    /**
     * @var DateTime|null
     */
    private $dueDate;

    /**
     * @var Amount|null
     */
    private $paymentAmount;

    /**
     * @param DateTime|null $dueDate
     * @param Amount|null $paymentAmount
     */
    public function __construct(
        DateTime $dueDate = null,
        Amount $paymentAmount = null
    ) {
        $this->dueDate = $dueDate;
        $this->paymentAmount = $paymentAmount;
    }

    /**
     * @return DateTime|null
     */
    public function getDueDate(): ?DateTime
    {
        return $this->dueDate;
    }

    /**
     * @param DateTime $dueDate
     * @return Payment
     */
    public function setDueDate(DateTime $dueDate): Payment
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @return Amount|null
     */
    public function getPaymentAmount(): ?Amount
    {
        return $this->paymentAmount;
    }

    /**
     * @param Amount $paymentAmount
     * @return Payment
     */
    public function setPaymentAmount(Amount $paymentAmount): Payment
    {
        $this->paymentAmount = $paymentAmount;
        return $this;
    }
}
