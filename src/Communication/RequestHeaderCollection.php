<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

class RequestHeaderCollection
{
    public const JSON_HEADERS = [
        'content-type' => 'application/json',
        'Accept' => 'application/json',
    ];

    /**
     * @var RequestHeader[]
     */
    protected $requestHeaders;

    public function __construct(RequestHeader ...$requestHeaders)
    {
        $this->requestHeaders = [];
        foreach ($requestHeaders as $requestHeader) {
            $this->addRequestHeader($requestHeader);
        }
    }

    public function addRequestHeader(RequestHeader $requestHeader): self
    {
        $this->requestHeaders[$requestHeader->getKey()] = $requestHeader;
        return $this;
    }

    /**
     * @return RequestHeader[]
     */
    public function getRequestHeaders(): array
    {
        return $this->requestHeaders;
    }

    /**
     * @param bool $withJsonHeaders
     * @return array<string, string>
     */
    public function getRequestHeadersAsArray(bool $withJsonHeaders = false): array
    {
        $result = $withJsonHeaders === true ? static::JSON_HEADERS : [];
        foreach ($this->requestHeaders as $requestHeader) {
            $result[$requestHeader->getKey()] = $requestHeader->getValue();
        }
        return $result;
    }
}
