<?php
namespace App\Services;

use App\Services\Interfaces\ClientServiceFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class PartnerService implements ClientServiceFactory
{
    private $partnerDetails;

    /**
     * prepare the partner payload in CBA format
     * @arg $request
     * @return self
     */
    public function setDetails(Object $request): self
    {
        $externalId= $this->generatedExternalId();
        $this->partnerDetails = [
            "officeId"=>1,
            "legalFormId"=>2,
            "fullname"=>$request->organization_name,
            "mobileNo"=>$request->phone_no,
            "emailAddress"=>$request->address,
            "address"=> [
                "addressLine1"=>$request->address,
                "isActive"=>true,
                "street"=>$request->address,
            ],
            "clientNonPersonDetails"=>[
                "incorpNumber"=>"",
                "locale"=>"en",
                "dateFormat"=>"dd MMMM yyyy",
                "incorpValidityTillDate"=>$request->date_of_incorporation
            ],
            "externalId"=>$externalId,
            "active"=>true,
            "savingsProductId"=>"10",
            "locale"=> "en",
            "dateFormat"=> "dd MMMM yyyy",
            "submittedOnDate"=> now()->format('d F Y'),
            "activationDate"=> now()->format('d F Y'),
        ];
        return $this;
    }

    /**
     * Get CBA formatted partner payload
     *
     * @return array
     */
    public function getDetails():array
    {
        return $this->partnerDetails;
    }

    /**
     * Use randomized number for Partner External Id
     *
     * @return int
     */
    public function generatedExternalId():int
    {
       $randomizeNumber  = rand(100000000, 999999999);
       return $randomizeNumber;
    }

    public function activatePartner(int $clientId)
    {
        $response = Http::withHeaders(
            [
                'Authorization'=>env('CBA_AUTH'),
                'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                'Content-Type'=> 'application/json'
            ]
        )->post(env('CBA_BASE_URL').'/clients/'.$clientId.'?command=activate', [
                "locale"=> "en",
              "dateFormat"=> "dd MMMM yyyy",
              "activationDate"=>Carbon::now()->format('d F Y')
            ]);
        return json_decode($response->body());
    }

    public function rejectPartner(int $clientId)
    {
        $response = Http::withHeaders(
            [
                'Authorization'=>env('CBA_AUTH'),
                'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
                'Content-Type'=> 'application/json'
            ]
        )->post(env('CBA_BASE_URL').'clients/'.$clientId.'?command=reject', [
        "rejectionDate"=>Carbon::now()->format('d F Y'),
        "rejectionReasonId"=>16,
        "locale"=>"en",
        "dateFormat"=>"dd MMMM yyyy"
        ]);
        return json_decode($response->body());
    }

}
