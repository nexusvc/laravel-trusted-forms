<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms;

use Illuminate\Contracts\Support\Arrayable;

class Fingerprint implements Arrayable
{
    /**
     * Fingerprint Response Data
     */
    protected array $fingerprint;

    /**
     * Fingerprint constructor.
     * @param array $fingerprint
     */
    public function __construct(?array $fingerprint = null)
    {
        $this->fingerprint = $fingerprint ?? [];
    }

    /**
     * Get Fingerprint Value
     * @param string $field
     * @param null $fallback
     * @return array|string|float|int|bool
     */
    public function get(string $field, $fallback = null)
    {
        return data_get($this->fingerprint, $field, $fallback);
    }

    /**
     * Get Certificate URL
     * @param null $fallback
     * @return string
     */
    public function certificateUrl($fallback = null)
    {
        return $this->get('masked_cert_url', $fallback);
    }

    /**
     * Get the instance as an array.
     * @return array
     */
    public function toArray()
    {
        return $this->fingerprint;
    }
}
