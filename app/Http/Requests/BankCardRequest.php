<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required",
            "card_number"=>"required",
            "date"=>"required",
            "cvv"=>"required",
            "is_default"=>"required",
            "customer_kyc_id"=>"nullable"
        ];
    }
}
