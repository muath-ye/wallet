<?php

namespace Muathye\Wallet\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Muathye\Wallet\WalletServiceProvider;
use Muathye\Wallet\Facades\WalletFacade;

class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom('database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            WalletServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Wallet' => WalletFacade::class
        ];
    }
}
