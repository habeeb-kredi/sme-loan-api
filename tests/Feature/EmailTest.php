<?php

namespace Tests\Feature;

use App\Mail\WelcomeMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mail()
    {
        Mail::to("amobeeb1net@gmail.com")->send(new WelcomeMail(['name'=>"Habeeb", "age"=>12]));
    }
}
