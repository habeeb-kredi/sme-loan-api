<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankDetailRequest extends FormRequest
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
            'bank_name'=>'required',
            'account_number'=>'required',
            'organization_name'=>'required',
            'repayment_code'=>'required',
            "customer_kyc_id"=>'nullable'
        ];
    }
}
