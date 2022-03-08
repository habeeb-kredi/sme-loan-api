<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BankDetailRequest;
use App\Helper\ApiResponseHelper;
use App\Models\BankDetails;
use Illuminate\Support\Facades\Auth;
class BankDetailsController extends Controller
{
    use ApiResponseHelper;
    public function addBankDetail(BankDetailRequest $request)
    {
        if(Auth::user()){
            $validated = $request->all();
            $validated['customer_kyc_id'] = Auth::user()->customer_kyc_id;
            $card =  BankDetails::create($validated);
             return $this->onSuccess(200, "Success", $card);
        }   
        return $this->onError(400, "Unauthorized");
    }

    public function viewBankDetails()
    {
        if(Auth::user()){
          
            $bankDetails =  BankDetails::where('customer_kyc_id', Auth::user()->customer_kyc_id)->get();
             return $this->onSuccess(200, "Success", $bankDetails);
        }   
        return $this->onError(400, "Unauthorized");
    }

    public function updateBankDetails($id, BankDetailRequest $request)
    {
        if(Auth::user()){
            $details = BankDetails::find($id); 
            $details->bank_name = $request->bank_name;
            $details->account_number = $request->account_number;
            $details->organization_name = $request->organization_name;
            $details->repayment_code = $request->repayment_code;
            $details->customer_kyc_id=Auth::user()->customer_kyc_id;
            $details->save();
            return $this->onSuccess(200, "Success", $details);
        }   
        return $this->onError(400, "Unauthorized");
    }

    public function deleteBankDetails($id)
    {
        if(Auth::user()){
            $card = BankDetails::find($id);
            $card->delete(); 
            return $this->onSuccess(200, "Success", []);
        }   
        return $this->onError(400, "Unauthorized");
    }
}
