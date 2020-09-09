<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

use function array_key_exists;
use function is_array;

class ResponseHeaderCollection
{
    /**
     * @var ResponseHeader[]
     */
    protected $responseHeaders;

    public function __construct(ResponseHeader ...$responseHeaders)
    {
        $this->responseHeaders = [];
        foreach ($responseHeaders as $responseHeader) {
            $this->addResponseHeader($responseHeader);
        }
    }

    /**
     * @param array<string, mixed> $headers
     * @return ResponseHeaderCollection
     */
    public static function buildFromArray(array $headers): ResponseHeaderCollection
    {
        $responseHeaderCollection = new self();
        foreach ($headers as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $headerValue) {
                    $responseHeaderCollection->addResponseHeader(
                        new ResponseHeader($key, $headerValue)
                    );
                }
                continue;
            }

            $responseHeaderCollection->addResponseHeader(
                new ResponseHeader($key, $value)
            );
        }
        return $responseHeaderCollection;
    }

    /**
     * @param ResponseHeader $responseHeader
     * @return ResponseHeaderCollection
     */
    public function addResponseHeader(ResponseHeader $responseHeader): self
    {
        $this->responseHeaders[$responseHeader->getKey()] = $responseHeader;
        return $this;
    }

    /**
     * @return ResponseHeader[]
     */
    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasResponseHeader(string $key): bool
    {
        return array_key_exists($key, $this->responseHeaders);
    }
}
