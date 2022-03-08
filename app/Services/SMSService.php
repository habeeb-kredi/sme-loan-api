<?php

namespace App\Services;

class SMSService
{
    public static function sendSMS($phone, $message)
    {
        $phone = (new PhoneNumber($phone))->validatedPhone();
        if($phone){
            $payload =   array("to" => [$phone], "from" => "KrediBank",
                "sms" => $message, "type" => "plain", "channel" => "dnd",
                "api_key" => env('SMS_API_KEY') );
            $response = HttpService::httpPost(env('SMS_API').'/sms/send/bulk', $payload, []);
            return $response;
        }
         }
}