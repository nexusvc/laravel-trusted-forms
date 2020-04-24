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

    public function jsonFixture(string $filename): array
    {
        return json_decode(file_get_contents(__DIR__."/Fixtures/$filename"), true);
    }

    protected function getPackageAliases($app)
    {
        return [
            'TrustedForms' => TrustedForms::class,
        ];
    }
}
