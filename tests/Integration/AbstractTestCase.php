<?php

/**
 * Purchase API
 * @copyright Copyright (c) 2020 Paysafe Pay Later
 * @license see LICENSE.TXT
 */

declare(strict_types=1);

namespace Paysafe\PayLater\Test\Integration;

use PHPUnit\Framework\TestCase;

use function array_key_exists;
use function file_exists;
use function getenv;
use function is_array;
use function is_string;
use function sprintf;

abstract class AbstractTestCase extends TestCase
{
    protected const SECRET_KEY_VAR = 'PAYSAFE_SECRET_KEY';

    /**
     * @var string
     */
    protected $baseUrl = '';

    /**
     * @var string
     */
    protected $secretKey = '';

    protected function setUp(): void
    {
        $secretKeyEnv = getenv(self::SECRET_KEY_VAR);
        if (is_string($secretKeyEnv)) {
            $this->secretKey = $secretKeyEnv;
            return;
        }

        $envFile = __DIR__ . '/../../.env.php';
        if (!file_exists($envFile)) {
            self::fail('.env.php not found. Please create one in order to run the API tests');
        }

        $configuration = include $envFile;
        if (!is_array($configuration)) {
            self::fail('Configuration in ".env.php" should return an array');
        }

        foreach (['api_base_url', 'secret_key'] as $field) {
            if (!array_key_exists($field, $configuration)) {
                self::fail(sprintf(
                    'Configuration key "%s" is missing in ".env.php"',
                    $field
                ));
            }
        }

        $this->baseUrl = $configuration['api_base_url'];
        $this->secretKey = $configuration['secret_key'];
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }
}
