<?php

namespace Tonysm\LocalTimeLaravel\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Tonysm\LocalTimeLaravel\LocalTimeLaravelServiceProvider;

class TestCase extends TestbenchTestCase
{
    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LocalTimeLaravelServiceProvider::class,
        ];
    }
}
