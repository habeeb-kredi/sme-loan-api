<?php

namespace App\Services;

class PhoneNumber
{
    protected $phone;
    public function __construct($phone)
    {
        return $this->phone = $phone;
    }

    /**
     * Validate Phone Number
     * @return string
     */
    public function validatedPhone()
    {
        if(preg_match("/^234/", $this->phone)){
            return $this->phone;
        }elseif(preg_match("/^0/", $this->phone)){
            $originPhoneNumber = "234".substr($this->phone, 1);
            return $originPhoneNumber;
        }
        return false;

    }
}