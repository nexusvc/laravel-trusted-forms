<?php

namespace BayAreaWebPro\TrustedForms;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BayAreaWebPro\TrustedForms\TrustedFormsService
 * @method static TrustedFormsService make(array $data = [])
 */
class TrustedForms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'trusted-forms';
    }
}
