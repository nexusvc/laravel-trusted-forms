<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms\Tests\Unit;

use BayAreaWebPro\TrustedForms\TrustedFormsServiceProvider;
use BayAreaWebPro\TrustedForms\TrustedFormsService;
use BayAreaWebPro\TrustedForms\Tests\TestCase;

class ProviderTest extends TestCase
{
    public function test_provider_is_registered()
    {
        $this->assertInstanceOf(
            TrustedFormsServiceProvider::class,
            $this->app->getProvider(TrustedFormsServiceProvider::class),
            'Provider is registered with container.');
    }

    public function test_container_can_resolve_instance()
    {
        $this->assertInstanceOf(
            TrustedFormsService::class,
            $this->app->make('trusted-forms'),
            'Container can make instance of service.');
    }

    public function test_facade_can_resolve_instance()
    {
        $this->assertInstanceOf(
            TrustedFormsService::class,
            \TrustedForms::getFacadeRoot(),
            'Facade can make instance of service.');
    }

    public function test_service_can_be_resolved()
    {
        $instance = app('trusted-forms');
        $this->assertTrue(($instance instanceof TrustedFormsService));
    }
}
