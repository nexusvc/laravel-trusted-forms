<?php
return [
    /*
    |--------------------------------------------------------------------------
    | TrustedForm Endpoint
    |--------------------------------------------------------------------------
    | https://support.activeprospect.com/hc/en-us/articles/201325449
    | https://support.activeprospect.com/hc/en-us/articles/201325439
    |
    | TrustedForm will calculate the fingerprints on your behalf when you pass
    | some basic lead data in the capture method. TrustedForm will evaluate the
    | included data and calculate SHA1 hashes of any phone numbers and
    | email addresses, discarding the lead data once the hash is calculated.
    |
    */
    'api_url' => env('TRUSTEDFORMS_API_URL', ''),
    'api_user' => env('TRUSTEDFORMS_API_USER', 'API'),
    'api_key' => env('TRUSTEDFORMS_API_KEY', 'XXX'),
    'api_retry' => [
        'times' => env('TRUSTEDFORMS_API_RETRY_TIMES', 1),
        'delay' => env('TRUSTEDFORMS_API_RETRY_DELAY', 2),
    ],
];
