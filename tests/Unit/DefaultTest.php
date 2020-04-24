<?php declare(strict_types=1);

namespace BayAreaWebPro\TrustedForms\Tests\Unit;

use BayAreaWebPro\TrustedForms\TrustedForms;
use BayAreaWebPro\TrustedForms\Tests\TestCase;

class DefaultTest extends TestCase
{
    public function test_can_generate_certificate()
    {
        TrustedForms::make();
    }
}
