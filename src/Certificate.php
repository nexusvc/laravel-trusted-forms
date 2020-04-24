<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Certificate extends ApiResponse
{
    /**
     * Get Certificate URLs
     * @return Collection
     */
    public function certificateUrls(): Collection
    {
        return $this->collect('claims')->pluck('masked_cert_url');
    }

    /**
     * Is Valid
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->hasValidExpiration() && $this->hasValidClaims();
    }

    /**
     * Has Valid Certificate
     * @return bool
     */
    public function hasValidExpiration(): bool
    {
        return Carbon::parse($this->get('expires_at', Carbon::now()))->greaterThan(Carbon::now());
    }

    /**
     * Has Valid Claims
     * @return bool
     */
    public function hasValidClaims(): bool
    {
        return $this
                ->collect('claims')
                ->pluck('expires_at')
                ->filter(fn($timestamp) => Carbon::parse($timestamp)->greaterThan(Carbon::now()))
                ->count() > 0;
    }
}
