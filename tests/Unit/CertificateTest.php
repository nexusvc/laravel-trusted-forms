<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms\Tests\Unit;

use BayAreaWebPro\TrustedForms\Certificate;
use BayAreaWebPro\TrustedForms\TrustedForms;
use BayAreaWebPro\TrustedForms\Tests\TestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class CertificateTest extends TestCase
{
    public function test_valid_certificate()
    {
        Http::fake(fn($request) => Http::response($this->jsonFixture('certificate-valid.json'), 200));

        $certificate = TrustedForms::readCertificate('XXX');

        $this->assertInstanceOf(
            Certificate::class, $certificate,
        );

        $this->assertInstanceOf(
            Collection::class,$certificate->certificateUrls(),
            "Certificate URLs are collection."
        );

        $this->assertTrue(
            $certificate->hasValidExpiration(),
            "Certificate is not expired."
        );

        $this->assertTrue(
            $certificate->hasValidClaims(),
            "Claims are not expired."
        );

        $this->assertTrue(
            $certificate->isValid(),
            "Certificate is valid."
        );

        $this->assertSame(
            'fallback-value',
            $certificate->get('some.nested.key', 'fallback-value'),
            "Certificate getters can fallback to defaults."
        );
    }

    public function test_invalid_certificate()
    {

        Http::fake(fn($request) => Http::response($this->jsonFixture('certificate-invalid.json'), 200));

        $certificate = TrustedForms::readCertificate('XXX');

        $this->assertFalse(
            $certificate->hasValidExpiration(),
            "Certificate is expired."
        );

        $this->assertFalse(
            $certificate->hasValidClaims(),
            "Claims are expired."
        );

        $this->assertFalse(
            $certificate->isValid(),
            "Certificate is invalid."
        );

    }
}
