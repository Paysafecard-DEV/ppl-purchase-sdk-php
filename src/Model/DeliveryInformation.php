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

class DeliveryInformation
{
    /**
     * @var DateTime|null
     */
    private $expectedShippingDate;

    /**
     * @var LogisticsProvider|null
     */
    private $logisticsProvider;

    /**
     * @var string|null
     */
    private $trackingNumber;

    /**
     * @param DateTime|null $expectedShippingDate
     * @param LogisticsProvider|null $logisticsProvider
     * @param string|null $trackingNumber
     */
    public function __construct(
        DateTime $expectedShippingDate = null,
        LogisticsProvider $logisticsProvider = null,
        string $trackingNumber = null
    ) {
        $this->expectedShippingDate = $expectedShippingDate;
        $this->logisticsProvider = $logisticsProvider;
        $this->trackingNumber = $trackingNumber;
    }

    /**
     * @return DateTime|null
     */
    public function getExpectedShippingDate(): ?DateTime
    {
        return $this->expectedShippingDate;
    }

    /**
     * @param DateTime $expectedShippingDate
     * @return DeliveryInformation
     */
    public function setExpectedShippingDate(DateTime $expectedShippingDate): DeliveryInformation
    {
        $this->expectedShippingDate = $expectedShippingDate;
        return $this;
    }

    /**
     * @return LogisticsProvider|null
     */
    public function getLogisticsProvider(): ?LogisticsProvider
    {
        return $this->logisticsProvider;
    }

    /**
     * @param LogisticsProvider $logisticsProvider
     * @return DeliveryInformation
     */
    public function setLogisticsProvider(LogisticsProvider $logisticsProvider): DeliveryInformation
    {
        $this->logisticsProvider = $logisticsProvider;
        return $this;
    }

    /**
     * The tracking number of the logistics provider.
     * @return string|null
     */
    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    /**
     * @param string $trackingNumber
     * @return DeliveryInformation
     */
    public function setTrackingNumber(string $trackingNumber): DeliveryInformation
    {
        $this->trackingNumber = $trackingNumber;
        return $this;
    }
}
