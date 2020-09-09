<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Exception;

use Paysafe\PayLater\Communication\ResponseHeaderCollection;
use Paysafe\PayLater\Model\OperationResult;
use Throwable;

class ReferenceException extends ApiResponseException
{
    /**
     * @param int $statusCode
     * @param string $responseBody
     * @param ResponseHeaderCollection $responseHeaders
     * @param string|null $errorId
     * @param string|null $errorMessage
     * @param OperationResult|null $operationResult
     * @param Throwable|null $previous
     */
    public function __construct(
        int $statusCode,
        string $responseBody,
        ResponseHeaderCollection $responseHeaders,
        ?string $errorId,
        ?string $errorMessage,
        ?OperationResult $operationResult,
        ?Throwable $previous = null
    ) {
        $message = $errorMessage !== null ?
            $errorMessage :
            'the Paysafe Pay Later platform returned a reference error response';

        parent::__construct(
            $message,
            $statusCode,
            $responseBody,
            $responseHeaders,
            $errorId,
            $operationResult,
            $previous
        );
    }
}
