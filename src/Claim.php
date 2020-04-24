<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms;

use Carbon\Carbon;

class Claim extends ApiResponse
{
    /**
     * Get the "Masked" Certificate URL
     * @return string|null
     */
    public function getMaskedCertificateUrl()
    {
        return $this->get('masked_cert_url');
    }

    /**
     * Get Certificate Token String
     * @return string|null
     */
    public function getCertificateToken()
    {
        return $this->get('cert.token');
    }

    /**
     * Is Valid
     * @return bool
     */
    public function isValid(): bool
    {
        return
            $this->hasValidExpiration() &&
            $this->hasValidCertificate() &&
            $this->hasValidClaims()
            ;
    }

    /**
     * Has Valid Expiration
     * @return bool
     */
    public function hasValidExpiration(): bool
    {
        return Carbon::parse($this->get('expires_at', Carbon::now()))->greaterThan(Carbon::now());
    }

    /**
     * Has Valid Certificate
     * @return bool
     */
    public function hasValidCertificate(): bool
    {
        return Carbon::parse($this->get('cert.expires_at', Carbon::now()))->greaterThan(Carbon::now());
    }

    /**
     * Has Valid Claims
     * @return bool
     */
    public function hasValidClaims(): bool
    {
        return $this
                ->collect('cert.claims')
                ->pluck('expires_at')
                ->filter(fn($timestamp)=>Carbon::parse($timestamp)->greaterThan(Carbon::now()))
                ->count() > 0
            ;
    }
}
