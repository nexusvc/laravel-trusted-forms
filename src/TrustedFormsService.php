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
     * Make TrustedFormsService & Capture Fingerprint.
     * @return self
     */
    public static function make(): self
    {
        return app(static::class);
    }

    /**
     * Generate Fingerprint from Data
     * @param array $data
     * @return Claim
     */
    public function claimCertificate(array $data): Claim
    {
        return new Claim(
            Http::asJson()
                ->retry($this->getApiRetryTimes(),$this->getApiRetryDelay())
                ->withBasicAuth($this->getApiUser(), $this->getApiKey())
                ->post($this->getApiUrl(),$data)
                ->json()
        );
    }

    /**
     * Retrieve Certificate Details
     * A certificate may only be retrieved after it has been claimed.
     * Attempting to retrieve an unclaimed certificate will result in an HTTP 404 response.
     * @param string $token
     * @return Certificate
     */
    public function readCertificate(string $token): Certificate
    {
        return new Certificate(
            Http::asJson()
                ->retry($this->getApiRetryTimes(),$this->getApiRetryDelay())
                ->withBasicAuth($this->getApiUser(), $this->getApiKey())
                ->get($this->getApiUrl($token))
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
     * @param array $segments
     * @return string
     */
    protected function getApiUrl(...$segments): string
    {
        return join('/',array_merge([$this->config->get('trusted-forms.api_url', '')],$segments));
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
