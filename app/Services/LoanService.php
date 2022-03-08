<?php
namespace App\Services;

use App\Models\LoanSetting;
use App\Models\LoanTracking;
use Illuminate\Support\Facades\Auth;

class LoanService{

    protected $loanSettingDetails = [];
    protected $endpointHeader;
    protected $defaultLoanSettings;
    protected $loanAppliedDetails;

    /**
     * Intialize loanSettings and Loan Application endpoint
     * @param array $loanSettings
     */
    public function __construct($loanSettings=[])
    {
        $this->loanSettingDetails = $loanSettings;
        $this->endpointHeader = [
            'Authorization'=>env('CBA_AUTH'),
            'Fineract-Platform-TenantId'=> env('CBA_HEADER'),
            'Content-Type'=> 'application/json'
        ];
        return $this;
    }

    /**
     * create loan for customer
     * @param $request
     */
    public function createLoan($request, $customerKyc)
    {
        $defaultLoanDetails = (new LoanSettingsService())->getDefaultLoanDetails(); //loan set by kredi
        if(is_null($this->loanSettingDetails) || is_null($this->loanSettingDetails)){
            return false;
        }
       $payLoad = [
           "dateFormat" => "dd MMMM yyyy",
           "locale" => "en",
           "clientId" => $customerKyc->client_id,
           "productId" =>  $defaultLoanDetails->loan_product_id,
            "principal" => $request->principal,
           "loanTermFrequency" => $request->loanTermFrequency,
           "loanTermFrequencyType" => 1,
           "loanType" => "individual",
           "numberOfRepayments" => $request->loanTermFrequency,
           "repaymentEvery" => 1,
           "repaymentFrequencyType" => 1,
           "interestRatePerPeriod" => $this->loanSettingDetails->loan_interest,
           "amortizationType" => 1,
           "interestType" => 0,
           "linkAccountId" => $customerKyc->savings_id,
           "interestCalculationPeriodType" => 1,
           "transactionProcessingStrategyId" => 1,
           "expectedDisbursementDate" => now()->format('d F Y'),
           "submittedOnDate" => now()->format('d F Y'),
       ];

       $response =  HttpService::httpPost(env('CBA_BASE_URL').'/loans', $payLoad, $this->endpointHeader );
       $decodeResponse = json_decode($response);
       if(optional($decodeResponse)->httpStatusCode == 404){
           return $decodeResponse->errors[0]->developerMessage;
       }

//       save loan created
       LoanTracking::create([
           'customer_kyc_id'=>Auth::user()->customer_kyc_id,
           'loanId'=>$decodeResponse->loanId,
           'resourceId'=>$decodeResponse->resourceId,
           'status'=>false
       ]);
       $approveLoanResponse = $this->approveLoan($decodeResponse->loanId);
       return $approveLoanResponse;

    }

    /**
     * approve loan application
     * @param $loanId
     * @return mixed
     */
    public function approveLoan($loanId)
    {
        $response =  HttpService::httpPost(env('CBA_BASE_URL').'/loans/'.$loanId.'?command=approve',
            [
                "dateFormat" => "dd MMMM yyyy",
                "locale" => "en",
            "approvedOnDate"=>now()->format('d F Y')
        ], $this->endpointHeader );
        return json_decode($response);
    }

    /**
     * Loan details summary
     * @param $loanId
     * @return mixed
     */
    public function loanSummary($loanId)
    {
        $response =  HttpService::httpGet(env('CBA_BASE_URL').'/loans/'.$loanId,
            $this->endpointHeader );
        return json_decode($response);
    }

    /**
     * List loan repayment schedule
     * @param $loanId
     * @return mixed
     */
    public function loanRepaymentSchedule($loanId)
    {
        $response =  HttpService::httpGet(env('CBA_BASE_URL').'/loans/'.$loanId."?associations=all&exclude=guarantors,futureSchedule",
            $this->endpointHeader );
        return json_decode($response);
    }

    public function disburseLoan($loanId)
    {
        $loanSummary = $this->loanSummary($loanId); //get the loan summary - loanID
            $response =  HttpService::httpPost(env('CBA_BASE_URL').'/loans/'.$loanId."?command=disburseToSavings",
            [
                  "dateFormat"=> "dd MMMM yyyy",
                  "locale"=> "en",
                  "transactionAmount"=>$loanSummary->principal,
                  "actualDisbursementDate"=>now()->format('d F Y'),
                  "note"=> "Loan Disbursement"
            ],
            $this->endpointHeader);
        return json_decode($response);
    }

}
