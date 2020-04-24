<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BayAreaWebPro\TrustedForms\TrustedFormsService
 * @method static Fingerprint capture(array $data = [])
 */
class TrustedForms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'trusted-forms';
    }
}
