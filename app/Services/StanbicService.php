<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
class StanbicService
{
    public static function fetchGet(string $endpoint, array $payload)
    {
            $response = Http::get(env('STABIC_URL').$endpoint, $payload);
            return $response;

    }
    public static function fetchPost(string $endpoint, array $payload)
    {
        $response = Http::post(env('STABIC_URL').$endpoint, $payload);
        return $response;

    }
}
