<?php

namespace BayAreaWebPro\TrustedForms\Tests;

use BayAreaWebPro\TrustedForms\TrustedForms;
use Orchestra\Testbench\TestCase as BaseTestCase;
use BayAreaWebPro\TrustedForms\TrustedFormsServiceProvider;

abstract class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app)
    {
        return [TrustedFormsServiceProvider::class];
    }

    /**
     * Load package alias
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'TrustedForms' => TrustedForms::class,
        ];
    }
}
