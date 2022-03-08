<?php

namespace Tests\Feature;

use App\Services\SMSService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SMSTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sms()
    {
        $sms = (new SMSService())->sendSMS("08132371012", "0129");
        var_dump($sms);
    }
}
