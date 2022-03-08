<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BankCardRequest;
use App\Helper\ApiResponseHelper;
use App\Models\BankCard;
use Illuminate\Support\Facades\Auth;
class BankCardController extends Controller
{
    use ApiResponseHelper;
    public function addBankCard(BankCardRequest $request)
    {
        if(Auth::user()){
            $validated = $request->all();
            $validated['customer_kyc_id'] = Auth::user()->customer_kyc_id;
            $card =  BankCard::create($validated);
             return $this->onSuccess(200, "Success", $card);
        }   
        return $this->onError(400, "Unauthorized");
    }

    public function viewCards()
    {
        if(Auth::user()){
          
            $card =  BankCard::where('customer_kyc_id', Auth::user()->customer_kyc_id)->get();
             return $this->onSuccess(200, "Success", $card);
        }   
        return $this->onError(400, "Unauthorized");
    }

    public function updateBankCard($id, BankCardRequest $request)
    {
        if(Auth::user()){
            $card = BankCard::find($id);
            $card->card_number = $request->card_number;
            $card->date = $request->date;
            $card->cvv = $request->cvv;
            $card->is_default = $request->is_default;
            $card->customer_kyc_id=Auth::user()->customer_kyc_id;
            $card->save();
            return $this->onSuccess(200, "Success", $card);
        }   
        return $this->onError(400, "Unauthorized");
    }

    public function deleteBankCard($id)
    {
        if(Auth::user()){
            $card = BankCard::find($id);
            $card->delete(); 
            return $this->onSuccess(200, "Success", []);
        }   
        return $this->onError(400, "Unauthorized");
    }
}
