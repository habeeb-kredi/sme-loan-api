<?php
namespace App\Services;
use App\Services\Interfaces\ClientServiceFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
class CBAService
{
    protected $payload;
    protected $registerClientDetails;
    public function __construct(ClientServiceFactory $client, Object $request)
    {
        $this->payload = $client->setDetails($request)->getDetails();
    }

    /**
     * Send Customer or Partner details to CBA to register
     * @return self
     */
    public function registerClient()
    {

        try {
            $response = Http::withHeaders(
                [
                    'Authorization' => env('CBA_AUTH'),
                    'Fineract-Platform-TenantId' => env('CBA_HEADER'),
                    'Content-Type' => 'application/json'
                ]
            )->post(env('CBA_BASE_URL') . '/clients', $this->payload);
        $this->registerClientDetails = json_decode($response->body());
        $this->registerClientDetails->externalId = $this->payload['externalId'];
        }catch(\Exception $e){
           return   json_encode($e->getMessage());

        }
        return $this;

    }

    /**
     * @return false|mixed|string|void
     * Get customer account created details
     */
    public function clientAccountDetails()
    {

        if(optional($this->registerClientDetails)->httpStatusCode == 403 ){
            unset($this->registerClientDetails->externalId);
            return json_decode(json_encode([
                'status' => 403,
                'message' => $this->registerClientDetails->defaultUserMessage,
            ]));
        }
//        check SavingsId generated
        try{
        if(optional($this->registerClientDetails)->savingsId){
            $response = Http::withHeaders(
                [
                    'Authorization'=>env('CBA_AUTH'),
                    'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                    'Content-Type'=> 'application/json'
                ]
            )->get(env('CBA_BASE_URL').'/savingsaccounts/'.$this->registerClientDetails->savingsId);

            $clientResponse = json_decode($response->body());
            $clientResponse->externalId = optional($this->registerClientDetails)->externalId; //add client externalId
            $clientResponse->savingsId = optional($this->registerClientDetails)->savingsId; //add client savingsId
            return json_decode(json_encode($clientResponse));
        }
        }catch (\Exception $e){
            return json_encode($e->getMessage());
        }
    }


    /**
     * @param $clientId
     * @return $this|string
     * Create saving's account for partner's customer
     */
    public function clientRegisterSavingsAccount($clientId)
    {
        try{
                $response = Http::withHeaders(
                    [
                        'Authorization'=>env('CBA_AUTH'),
                        'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                        'Content-Type'=> 'application/json'
                    ]
                )->post(env('CBA_BASE_URL').'/savingsaccounts', [
                    "clientId"=> $clientId,
                    "productId"=> $this->payload['savingsProductId'],
                    "locale"=> $this->payload['locale'],
                    "dateFormat"=> $this->payload['dateFormat'],
                    "submittedOnDate"=> $this->payload['activationDate']
                ]);

            $this->registerClientDetails = json_decode($response->body());
            $this->registerClientDetails->externalId = $this->payload['externalId'];
        }catch (\Exception $e){
            return $e->getMessage();
        }
        return $this;
    }


    public static function clientBasicAccountDetails(int $savingsId)
    {
        try{
            if($savingsId){
                $response = Http::withHeaders(
                    [
                        'Authorization'=>env('CBA_AUTH'),
                        'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                        'Content-Type'=> 'application/json'
                    ]
                )->get(env('CBA_BASE_URL').'/savingsaccounts/'.$savingsId);

                $clientResponse = json_decode($response->body());
                return json_decode(json_encode($clientResponse));
            }
        }catch (\Exception $e){

        }
    }


    public static function clientInward($savingsId)
    {
        try{
            if($savingsId){
                $response = Http::withHeaders(
                    [
                        'Authorization'=>env('CBA_AUTH'),
                        'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                        'Content-Type'=> 'application/json'
                    ]
                )->get(env('CBA_BASE_URL').'/inward/'.$savingsId);

                $clientResponse = json_decode($response->body());
                return json_decode(json_encode($clientResponse));
            }
        }catch (\Exception $e){

        }
    }

    /**
     * @param $savingsId
     * @return mixed|void
     * Approve Customer Savings Account
     */
    public static function approveSavingsAccount($savingsId)
    {
        try{
            if($savingsId){
                $response = Http::withHeaders(
                    [
                        'Authorization'=>env('CBA_AUTH'),
                        'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                        'Content-Type'=> 'application/json'
                    ]
                )->post(env('CBA_BASE_URL').'/savingsaccounts/'.$savingsId.'?command=approve',
                [
                    "locale"=> "en",
                      "dateFormat"=> "dd MMMM yyyy",
                      "approvedOnDate"=> now()->format('d F Y')
                ]);

                $clientResponse = json_decode($response->body());
                return json_decode(json_encode($clientResponse));
            }
        }catch (\Exception $e){
                return $e->getMessage();
        }
    }

    /**
     * @param $savingsId
     * @return mixed|void
     * Disapprove customer saving's account
     */
    public static function disapproveSavingsAccount($savingsId)
    {
        try{
            if($savingsId){
                $response = Http::withHeaders(
                    [
                        'Authorization'=>env('CBA_AUTH'),
                        'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                        'Content-Type'=> 'application/json'
                    ]
                )->post(env('CBA_BASE_URL').'/savingsaccounts/'.$savingsId.'?command=undoApproval',
                    []);
                $clientResponse = json_decode($response->body());
                return json_decode(json_encode($clientResponse));
            }
        }catch (\Exception $e){

        }
    }

    public static function activateSavingsAccount($savingsId)
    {
        try{
            if($savingsId){
                $response = Http::withHeaders(
                    [
                        'Authorization'=>env('CBA_AUTH'),
                        'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                        'Content-Type'=> 'application/json'
                    ]
                )->post(env('CBA_BASE_URL').'/savingsaccounts/'.$savingsId.'?command=activate',
                    [
                        "locale"=> "en",
                        "dateFormat"=> "dd MMMM yyyy",
                        "activatedOnDate"=> now()->format('d F Y')
                    ]);

                $clientResponse = json_decode($response->body());
                return json_decode(json_encode($clientResponse));
            }
        }catch (\Exception $e){

        }
    }


    /**
     * @param $savingsId
     * @return mixed|void
     * Reject Customer Saving's account
     */
    public static function rejectSavingsAccount($savingsId)
    {
        try{
            if($savingsId){
                $response = Http::withHeaders(
                    [
                        'Authorization'=>env('CBA_AUTH'),
                        'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                        'Content-Type'=> 'application/json'
                    ]
                )->post(env('CBA_BASE_URL').'/savingsaccounts/'.$savingsId.'?command=reject',
                    [
                        "locale"=> "en",
                      "dateFormat"=> "dd MMMM yyyy",
                      "rejectedOnDate"=> now()->format('d F Y')
                    ]);

                $clientResponse = json_decode($response->body());
                return json_decode(json_encode($clientResponse));
            }
        }catch (\Exception $e){

        }
    }


}
