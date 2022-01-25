<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerKYCRequest;
use App\Helper\CustomerHelper;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use CustomerHelper;

    public function registerCustomer(Customer $request)
    {
        $customer = $request->create([
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'password'=>bcrypt($request->input('password')),
            'role_id'=>Role::first()->id,
            'referrer_code'=>$this->generateReferrerCode(),
        ]);
    }
}
