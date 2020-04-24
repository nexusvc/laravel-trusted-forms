<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms\Tests\Unit;

use BayAreaWebPro\TrustedForms\Claim;
use BayAreaWebPro\TrustedForms\Certificate;
use BayAreaWebPro\TrustedForms\TrustedForms;
use BayAreaWebPro\TrustedForms\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DefaultTest extends TestCase
{
    public function test_can_generate_claim()
    {
        Http::fake(fn($request) => Http::response($this->jsonFixture('claim-valid.json'), 201));

        $trustedForm = TrustedForms::make();
        $claim = $trustedForm->claimCertificate([
            'vendor' => 'MY-CO',
            'email' => 'test@test.local',
            'phone' => '1-000-000-0000',
            'address' => '123 Untitled St.',
            'city' => 'San Francisco',
            'state' => 'CA',
            'zip' => '12345',
        ]);
        $this->assertInstanceOf(Claim::class, $claim);
        $this->assertIsString($claim->getCertificateToken());
        $this->assertIsString($claim->isValid());
    }

    public function test_can_read_certificate()
    {

        Http::fake(fn($request) => Http::response($this->jsonFixture('certificate-valid.json'), 201));

        $trustedForm = TrustedForms::make();
        $certificate = $trustedForm->readCertificate('XXX');

        $this->assertInstanceOf(Certificate::class, $certificate);
        $this->assertInstanceOf(Collection::class,$certificate->certificateUrls());

        dd($certificate->isValid());

        //dump($fingerprint->certificateUrl('fallback-value'));
        //dump($fingerprint->get('some.nested.key', 'fallback-value'));
    }
}
