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
