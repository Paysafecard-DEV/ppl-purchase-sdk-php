<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;

// phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit.ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff

class ConnectionConfiguration implements Configuration
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var int
     * @see \GuzzleHttp\RequestOptions::CONNECT_TIMEOUT
     */
    protected $connectTimeout = 30;

    /**
     * @var int
     * @see \GuzzleHttp\RequestOptions::READ_TIMEOUT
     */
    protected $readTimeout = 10;

    /**
     * @var bool
     * @see \GuzzleHttp\RequestOptions::DEBUG
     */
    protected $debug = false;

    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * @param string $baseUrl
     * @param int $connectTimeout
     * @param int $readTimeout
     * @param bool $debug
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        string $baseUrl,
        int $connectTimeout = 30,
        int $readTimeout = 10,
        bool $debug = false,
        LoggerInterface $logger = null
    ) {
        $this->baseUrl = $baseUrl;
        $this->connectTimeout = $connectTimeout;
        $this->readTimeout = $readTimeout;
        $this->debug = $debug;
        $this->logger = $logger;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return int
     */
    public function getConnectTimeout(): int
    {
        return $this->connectTimeout;
    }

    /**
     * @param int $connectTimeout
     * @return ConnectionConfiguration
     */
    public function setConnectTimeout(int $connectTimeout): self
    {
        $this->connectTimeout = $connectTimeout;
        return $this;
    }

    /**
     * @return int
     */
    public function getReadTimeout(): int
    {
        return $this->readTimeout;
    }

    /**
     * @param int $readTimeout
     * @return ConnectionConfiguration
     */
    public function setReadTimeout(int $readTimeout): self
    {
        $this->readTimeout = $readTimeout;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     * @return ConnectionConfiguration
     */
    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * @return LoggerInterface|null
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface|null $logger
     * @return ConnectionConfiguration
     */
    public function setLogger(?LoggerInterface $logger): self
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfigurationArray(): array
    {
        return [
            RequestOptions::CONNECT_TIMEOUT => $this->connectTimeout,
            RequestOptions::READ_TIMEOUT => $this->readTimeout,
            RequestOptions::DEBUG => $this->debug,
        ];
    }
}
