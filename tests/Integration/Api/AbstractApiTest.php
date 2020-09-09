<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Test\Integration\Api;

use Paysafe\PayLater\Communication\ApiConnection;
use Paysafe\PayLater\Communication\ConnectionConfiguration;
use Paysafe\PayLater\Communication\PaySafePayLaterCommunicator;
use Paysafe\PayLater\Test\Integration\AbstractTestCase;
use Psr\Log\Test\TestLogger;

abstract class AbstractApiTest extends AbstractTestCase
{
    /**
     * @return PaySafePayLaterCommunicator
     */
    protected function createPaySafePayLaterCommunicator(): PaySafePayLaterCommunicator
    {
        $configuration = new ConnectionConfiguration($this->baseUrl);
        $configuration->setLogger(new TestLogger());

        return new PaySafePayLaterCommunicator(
            ApiConnection::create($configuration)
        );
    }
}
