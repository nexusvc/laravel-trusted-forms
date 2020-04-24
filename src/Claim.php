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
     * Has Valid Claims
     * @return bool
     */
    public function isValid(): bool
    {
        return $this
                ->collect('claims')
                ->pluck('expires_at')
                ->reject(fn($timestamp)=>Carbon::createFromTimestamp($timestamp)->greaterThan(Carbon::now()))
                ->count() > 0
            ;
    }
}
