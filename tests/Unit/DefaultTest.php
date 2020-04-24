<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms\Tests\Unit;

use Illuminate\Support\Facades\Config;
use BayAreaWebPro\TrustedForms\Fingerprint;
use BayAreaWebPro\TrustedForms\TrustedForms;
use BayAreaWebPro\TrustedForms\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class DefaultTest extends TestCase
{
    public function test_can_generate_certificate()
    {
        Config::set('trusted-forms.api_url', 'https://test.local');

        Http::fake([
            'test.local/*' => Http::response(['foo' => 'bar'], 200, ['Headers']),
        ]);

        $fingerprint = TrustedForms::capture([
            'vendor' => 'MY-CO',
            'email' => 'test@test.local',
            'phone' => '1-000-000-0000',
            'address' => '123 Untitled St.',
            'city' => 'San Francisco',
            'state' => 'CA',
            'zip' => '12345',
        ]);

        $this->assertInstanceOf(Fingerprint::class, $fingerprint);
       // $this->assertStringContainsString($fingerprint->certificateUrl('fallback-value'), 'fallback-value');

        //dump($fingerprint->certificateUrl('fallback-value'));
        //dump($fingerprint->get('some.nested.key', 'fallback-value'));
    }
}
