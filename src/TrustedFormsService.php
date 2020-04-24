<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\Http;

class TrustedFormsService
{
    /**
     * The data to be certified.
     */
    protected array $data;

    /**
     * The config repository.
     */
    protected Config $config;

    /**
     * Make TrustedFormsService & Capture Fingerprint.
     * @param array $data
     * @return mixed
     */
    public static function capture(array $data = []): Fingerprint
    {
        return app(static::class, compact('data'))->toFingerprint();
    }

    /**
     * TrustedFormsService constructor.
     * @param Config $config
     * @param array $data
     */
    public function __construct(Config $config, array $data = [])
    {
        $this->config = $config;
        $this->data = $data;
    }

    /**
     * Generate Fingerprint from Data
     */
    public function toFingerprint(): Fingerprint
    {
        return new Fingerprint(
            Http::asJson()
                ->retry($this->getApiRetryTimes(),$this->getApiRetryDelay())
                ->withBasicAuth($this->getApiUser(), $this->getApiKey())
                ->post($this->getApiUrl(), $this->data)
                ->json()
        );
    }

    /**
     * Amount of times to retry the request.
     */
    protected function getApiRetryTimes(): int
    {
        return $this->config->get('trusted-forms.api_retry.times', 1);
    }

    /**
     * Amount of time to wait before retrying the request.
     */
    protected function getApiRetryDelay(): int
    {
        return $this->config->get('trusted-forms.api_retry.delay', 2);
    }

    /**
     * Get the API URL.
     */
    protected function getApiUrl(): string
    {
        return $this->config->get('trusted-forms.api_url', '');
    }

    /**
     * Get the API key string.
     */
    protected function getApiKey(): string
    {
        return $this->config->get('trusted-forms.api_key', '');
    }

    /**
     * Get the API username.
     */
    protected function getApiUser(): string
    {
        return $this->config->get('trusted-forms.api_user', 'API');
    }
}
