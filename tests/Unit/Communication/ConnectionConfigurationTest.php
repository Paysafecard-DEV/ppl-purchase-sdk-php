<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Test\Unit\Communication;

use Paysafe\PayLater\Communication\ConnectionConfiguration;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\Test\TestLogger;

class ConnectionConfigurationTest extends TestCase
{
    public function testConnectionConfiguration(): void
    {
        $configuration = new ConnectionConfiguration('');

        self::assertSame(30, $configuration->getConnectTimeout());
        $configuration->setConnectTimeout(60);
        self::assertSame(60, $configuration->getConnectTimeout());

        self::assertSame(10, $configuration->getReadTimeout());
        $configuration->setReadTimeout(15);
        self::assertSame(15, $configuration->getReadTimeout());

        self::assertFalse($configuration->isDebug());
        $configuration->setDebug(true);
        self::assertTrue($configuration->isDebug());

        self::assertNull($configuration->getLogger());
        $configuration->setLogger(new TestLogger());
        self::assertInstanceOf(LoggerInterface::class, $configuration->getLogger());

        $result = [
            'connect_timeout' => 60,
            'read_timeout' => 15,
            'debug' => true,
        ];
        self::assertSame($result, $configuration->getConfigurationArray());
    }
}
