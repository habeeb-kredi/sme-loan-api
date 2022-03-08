<?php

namespace App\Helper;

trait CustomerHelper
{
    public function generateReferrerCode()
    {
         return uniqid();
    }

    public function generateOTP() {
        return substr(mt_rand(0000000, 9999999).mt_rand(00000, 99999), 0, 5);
    }

}

