<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BayAreaWebPro\TrustedForms\TrustedFormsService
 * @method static Certificate readCertificate(string $token)
 * @method static Claim claimCertificate(array $data)
 * @method static TrustedFormsService make()
 */
class TrustedForms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'trusted-forms';
    }
}
