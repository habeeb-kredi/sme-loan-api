<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerKYCRequest extends FormRequest
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
            'business_name'=>'required',
            'phone'=>'required',
            'date_of_incorporation'=>'required',
            'address'=>'required',
            'nationality'=>'required',
            'rc_number'=>'required',
            'business_type'=>'required',
            'CAC'=>'nullable',
            'utility'=>'nullable',
            'bank_statement'=>'nullable'
        ];
    }
}
