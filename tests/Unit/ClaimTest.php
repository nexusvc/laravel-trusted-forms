<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms\Tests\Unit;

use Illuminate\Support\Facades\Http;
use BayAreaWebPro\TrustedForms\Claim;
use BayAreaWebPro\TrustedForms\TrustedForms;
use BayAreaWebPro\TrustedForms\Tests\TestCase;

class ClaimTest extends TestCase
{
    public function test_valid_claim()
    {
        Http::fake(fn($request) => Http::response($this->jsonFixture('claim-valid.json'), 201));

        $claim = TrustedForms::claimCertificate([]);

        $this->assertInstanceOf(Claim::class, $claim);
        $this->assertIsString($claim->getCertificateToken());
        $this->assertIsString($claim->getMaskedCertificateUrl());

        $this->assertSame(
            'fallback-value',
            $claim->get('some.nested.key', 'fallback-value'),
            "Claim getter can fallback to defaults."
        );

        $this->assertTrue(
            $claim->hasValidExpiration(),
            "Claim is not expired."
        );

        $this->assertTrue(
            $claim->hasValidCertificate(),
            "Certificate is not expired."
        );

        $this->assertTrue(
            $claim->hasValidClaims(),
            "Claims are not expired."
        );

        $this->assertTrue(
            $claim->isValid(),
            "Claim is not invalid."
        );
    }

    public function test_invalid_claim()
    {
        Http::fake(fn($request) => Http::response($this->jsonFixture('claim-invalid.json'), 201));

        $claim = TrustedForms::claimCertificate([]);

        $this->assertFalse(
            $claim->hasValidExpiration(),
            "Claim is expired."
        );

        $this->assertFalse(
            $claim->hasValidCertificate(),
            "Certificate is expired."
        );

        $this->assertFalse(
            $claim->hasValidClaims(),
            "Claims are expired."
        );

        $this->assertFalse(
            $claim->isValid(),
            "Claim is invalid."
        );
    }
}
