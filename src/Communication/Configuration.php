<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Communication;

use Psr\Log\LoggerInterface;

interface Configuration
{
    /**
     * @return string
     */
    public function getBaseUrl(): string;

    /**
     * @return LoggerInterface|null
     */
    public function getLogger(): ?LoggerInterface;

    /**
     * @return bool
     */
    public function isDebug(): bool;

    /**
     * @return array<string, mixed>
     */
    public function getConfigurationArray(): array;
}
