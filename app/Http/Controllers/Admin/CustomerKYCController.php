<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Mail\WelcomeMail;
use App\Models\Customer_kyc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;


class CustomerKYCController extends Controller
{
    public function index()
    {
        return Inertia::render('Customer/CustomerKYCList')->with('customerKYCs', Customer_kyc::get());
    }
    public function show(Customer_kyc $customer)
    {
        return Inertia::render('Customer/CustomerKYCDetails')
            ->with('customerKYCDetails', $customer);
    }
    public function mail()
    {
        $customer = (object) [
            'first_name'=>"Hebaeb",
            'last_name'=>"Amode",
            'email'=>"amobeeb1net@gmail.com",
            'phone'=>"08123939393",
            'password'=>bcrypt("habeeb"),
            'otp_code'=>"01883",
            'role_id'=>1,
            'referrer_code'=>"23223",
            'is_active'=>1
        ];
        SendMail::dispatch($customer);
//        Mail::to("amobeeb1net@gmail.com")->send(new WelcomeMail(['name'=>"Habeeb", "age"=>12]));
    }

}
