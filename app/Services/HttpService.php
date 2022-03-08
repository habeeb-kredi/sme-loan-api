<?php
namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class HttpService {

    /**
     * handles connection to POST endpoint
     * @return Object
     */
    public static function httpPost($endPoint, Array $payLoad, Array $endpointHeader)
    {
        $response = Http::withHeaders(
            $endpointHeader
        )->post($endPoint, $payLoad);
        return $response->body();
    }

    /**
     * @param $endPoint
     * @param array $endpointHeader
     * @return string
     */
    public static function httpGet($endPoint,  Array $endpointHeader)
    {
        $response = Http::withHeaders(
            $endpointHeader
        )->get($endPoint);
        return $response->body();
    }
}
