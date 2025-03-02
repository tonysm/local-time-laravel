<?php

namespace Tonysm\LocalTimeLaravel\Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Tonysm\LocalTimeLaravel\LocalTimeLaravelServiceProvider::class,
        ];
    }
}
