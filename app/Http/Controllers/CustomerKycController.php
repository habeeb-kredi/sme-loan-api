<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponseHelper;
use App\Helper\CustomerHelper;
use App\Http\Requests\CustomerKYCRequest;
use App\Jobs\UploadDocuments;
use App\Models\Customer;
use App\Models\Customer_kyc;
use App\Services\CBAService;
use App\Services\DocumentUploads;
use App\Services\PartnerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerKycController extends Controller
{
    use ApiResponseHelper, CustomerHelper;

    public function registerBusinessDetails(CustomerKYCRequest $request)
    {
        if(Auth::user()){
            $customerKyc = Customer_kyc::create([
                'business_name'=>$request->business_name,
                'phone'=>$request->phone,
                'date_of_incorporation'=>$request->date_of_incorporation,
                'address'=>$request->address,
                'email'=>$request->email,
                'nationality'=>$request->nationality,
                'rc_number'=>$request->rc_number,
                'business_type'=>$request->business_type
            ]);

            //relate business details to user
            $customer = Customer::find(Auth::user()->id);
            $customer->customer_kyc_id = $customerKyc->id;
            $customer->save();

            if($customerKyc){
                return $this->onSuccess(200, "Success", $customerKyc);
            }
        }

     return $this->onError('400', 'Unauthorized');
    }

    public function registerBusinessDocuments(Request $request, DocumentUploads $document)
    {
        //upload files
        $cacDocument=$document->upload($request, 'CAC', 'cac_documents');
        $utilityDocument=$document->upload($request, 'utility', 'utility_documents');
        $bankStatementDocument=$document->upload($request, 'bank_statement', 'bank_statement_documents');

        if(Auth::user()){
            $customerKyc = Customer_kyc::find(Auth::user()->customer_kyc_id);
            $customerKyc->CAC = $cacDocument;
            $customerKyc->utility = $utilityDocument;
            $customerKyc->bank_statement = $bankStatementDocument;
            $customerKyc->save();

//            create customer account and update CBA
            $generatedNubanDetails = $this->createAccountOnCBA($customerKyc);
            try {
                $customerKyc->nuban = $generatedNubanDetails->nubanNumber;
                $customerKyc->savings_id = $generatedNubanDetails->savingsId;
                $customerKyc->client_id = $generatedNubanDetails->clientId;
                $customerKyc->is_active = $generatedNubanDetails->nubanNumber == '' ? 0 : 1; //make the account inactive if nuban is not generated
                $customerKyc->save();
            }catch (\ErrorException  $e){
                echo $e->getMessage();
            }

            if($customerKyc){
                return $this->onSuccess(200, "Success", $customerKyc);
            }

        }

        return $this->onError('400', 'Unauthorized');
    }

    protected function createAccountOnCBA($customerKyc)
    {
        $payLoad = (Object) [
            "organization_name" => $customerKyc->business_name,
            "phone_no" => $customerKyc->phone,
            "email" => $customerKyc->email,
            "country" => $customerKyc->nationality,
            "address" => $customerKyc->address,
            "rc_number" => $customerKyc->rc_number,
            "type_of_business" => $customerKyc->business_type,
            "date_of_incorporation" => $customerKyc->date_of_incorporation,
            "cac_document" => $customerKyc->CAC
        ];
        $createPartnersOnCBA =  optional((new CBAService(new PartnerService, $payLoad))->registerClient())->clientAccountDetails();
        if(optional($createPartnersOnCBA)->status == '403') {
            return response()->json(
                $createPartnersOnCBA??["message"=>"Error Occurred"], 403);
        }
        return  $createPartnersOnCBA;
    }





}
