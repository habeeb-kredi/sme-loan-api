<?php

namespace Tests\Feature;

use App\Services\PhoneNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhoneNumberTest extends TestCase
{
     public function testvalidatePhoneNumber()
     {
         $phone = new PhoneNumber("08132371012");
         var_dump($phone->validatedPhone());
     }


}
