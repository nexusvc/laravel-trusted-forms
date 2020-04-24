<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms;

use Illuminate\Support\Facades\Http;

class TrustedFormsService
{
    /**
     * The array of data to be certified.
     * @var array
     */
    protected array $data;

    /**
     * Make TrustedFormsService & generate certificate.
     * @param array $data
     * @return mixed
     */
    public static function make(array $data = [])
    {
        return app(static::class, compact('data'))->generate();
    }

    /**
     * TrustedFormsService constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function generate(){

    }
}
