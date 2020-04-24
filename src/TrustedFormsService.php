<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\Client\PendingRequest as Client;

class TrustedFormsService
{
    /**
     * The config repository.
     */
    protected Config $config;

    /**
     * The Http client.
     */
    protected Client $client;

    /**
     * TrustedFormsService constructor.
     * @param Config $config
     */
    public function __construct(Config $config, Client $client)
    {
        $this->config = $config;
        $this->client = $client;
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
            $this->client
                ->asJson()
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
            $this->client
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
     * @param array<int, mixed> $segments
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
