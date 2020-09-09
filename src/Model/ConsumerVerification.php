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

// phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
// phpcs:disable ObjectCalisthenics.Metrics.PropertyPerClassLimit

/**
 * Consumer verification possibilities.
 */
class ConsumerVerification
{
    /**
     * @var string|null
     */
    private $initializeUrl;

    /**
     * @var string|null
     */
    private $verifyUrl;

    /**
     * @var bool|null
     */
    private $consumerDataAvailable;

    /**
     * @param string|null $initializeUrl
     * @param string|null $verifyUrl
     * @param bool|null $consumerDataAvailable
     */
    public function __construct(
        string $initializeUrl = null,
        string $verifyUrl = null,
        bool $consumerDataAvailable = null
    ) {
        $this->initializeUrl = $initializeUrl;
        $this->verifyUrl = $verifyUrl;
        $this->consumerDataAvailable = $consumerDataAvailable;
    }

    /**
     * @return string|null
     */
    public function getInitializeUrl(): ?string
    {
        return $this->initializeUrl;
    }

    /**
     * @param string $initializeUrl
     * @return ConsumerVerification
     */
    public function setInitializeUrl(string $initializeUrl): ConsumerVerification
    {
        $this->initializeUrl = $initializeUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVerifyUrl(): ?string
    {
        return $this->verifyUrl;
    }

    /**
     * @param string $verifyUrl
     * @return ConsumerVerification
     */
    public function setVerifyUrl(string $verifyUrl): ConsumerVerification
    {
        $this->verifyUrl = $verifyUrl;
        return $this;
    }

    /**
     * Flag to state that consumer data are available.
     * @return bool|null
     */
    public function getConsumerDataAvailable(): ?bool
    {
        return $this->consumerDataAvailable;
    }

    /**
     * @param bool $consumerDataAvailable
     * @return ConsumerVerification
     */
    public function setConsumerDataAvailable(bool $consumerDataAvailable): ConsumerVerification
    {
        $this->consumerDataAvailable = $consumerDataAvailable;
        return $this;
    }
}
