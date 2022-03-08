<?php

namespace Tests\Feature;

use App\Helper\CustomerHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelperTest extends TestCase
{
    use CustomerHelper;
    public function test_otp_code()
    {
        $otp = $this->generateOTP();
        var_dump($otp);
        $this->assertIsNumeric($otp);
    }
}
