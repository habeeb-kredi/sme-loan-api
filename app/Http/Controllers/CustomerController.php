<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponseHelper;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CustomerKYCRequest;
use App\Helper\CustomerHelper;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OTPRequest;
use App\Jobs\SendMail;
use App\Jobs\SendOTP;
use App\Mail\WelcomeMail;
use App\Models\Customer;
use App\Models\Role;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    use ApiResponseHelper, CustomerHelper;

    public function registerCustomer(CustomerRequest $request)
    {
        $otpCode = $this->generateOTP();
        $referrerCode = $this->generateReferrerCode();
        $roleId = optional(Role::first())->id ?? 1; //if role db not ready, use 1 for admin by default
        $customer = Customer::create([
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'password'=>bcrypt($request->input('password')),
            'otp_code'=>$otpCode,
            'role_id'=>$roleId,
            'referrer_code'=>$referrerCode,
            'is_active'=>1
        ]);
        $customer['token']= $customer->createToken('sme')->plainTextToken;
        if ($customer) {
            (new SMSService())->sendSMS($request->input('phone'), $otpCode); //Send OTP to phone
            SendOTP::dispatch($customer); //send message to mail
            return $this->onSuccess(200, "Success", $customer);
        }
        return $this->onError(400, "Failed");
    }

    public function loginCustomer(LoginRequest $request)
    {
        if (Auth::guard('customers')->attempt($request->input())) {
            $user = Auth::guard('customers')->user();
            $user['token'] = $user->createToken('sme')->plainTextToken;
            return $this->onSuccess(200, 'Success', $user);
        }
        return $this->onError(400, Auth::user());
    }

    /**
     * Verify Email on DB, generate and send OTP via SMS and Email
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmail(Request $request)
    {
        $otpCode = $this->generateOTP();
        $otpMessage = "Kredi Bank MFB OTP verification: {$otpCode}";
        $request->validate([
            "email"=>"required|email"
        ]);
        $customer = Customer::whereEmail($request->email)->first();
        if ($customer) {
            $customer->otp_code = $otpCode;
            $customer->save();

//            send code to mail or phone
            SendOTP::dispatch($customer);
            (new SMSService())->sendSMS($customer->phone, $otpMessage); //            Send OTP to phone

            //add token
            $customer['token'] = $customer->createToken('sme')->plainTextToken;
            return $this->onSuccess(200, "Success", $customer);
        }
        return $this->onError(400, "Failed");
    }

    /**
     * Verify OTP
     * @param OTPRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOTP(OTPRequest $request)
    {
        if (Auth::check() == true) {
            if (Auth::user()->otp_code == $request->otp_code) { //check otp updated on customer table
                return $this->onSuccess(200, "Success", Auth::user());
            }
            return $this->onError(400, "Incorrect OTP Code");
        }
        return $this->onError(400, "Unauthorized");
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if (Auth::user()) {
            //note authentication before generating password
            $customer = Customer::find(Auth::user()->id);
            $customer->password = bcrypt($request->password);
            $customer->save();
            return $this->onSuccess(200, "Success", $customer);
        }
        return $this->onError(400, "Unauthorized");
    }

    public function addTeamMember(CustomerRequest $request)
    {
        if (Auth::user()) {
            $customer = Customer::create([
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email'),
            'phone'=>$request->input('phone'),
            'password'=>bcrypt($request->input('password')),
            'role_id'=>$request->input('role_id'),
            'otp_code'=>$this->generateOTP(),
            'referrer_code'=>$this->generateReferrerCode(),
            'is_active'=>1,
            'customer_kyc_id'=>Auth::user()->customer_kyc_id
        ]);
            return $this->onSuccess(200, "Success", $customer);
        }
        return $this->onError(400, "Unauthorized");
    }

    public function editTeamMember($teamMemberId, CustomerRequest $request)
    {
        if (Auth::user()) {
            if(Auth::user()->id == $teamMemberId){
                $customer = Customer::find($teamMemberId); 
                $customer->first_name=$request->input('first_name');
                $customer->last_name=$request->input('last_name');
                $customer->email=$request->input('email');
                $customer->phone=$request->input('phone');  
                $customer->save();
            }else{
                $customer = Customer::find($teamMemberId); 
                $customer->first_name=$request->input('first_name');
                $customer->last_name=$request->input('last_name');
                $customer->email=$request->input('email');
                $customer->phone=$request->input('phone');
                $customer->password=bcrypt($request->input('password'));
                $customer->role_id=$request->input('role_id');
                $customer->save();
            } 
            
            return $this->onSuccess(200, "Success", $customer);
        }
        return $this->onError(400, "Unauthorized");
    }

    public function updateProfilePicture($teamMemberId, Request $request)
    {
        if (Auth::user()) {
            $customer = Customer::find($teamMemberId);
            $customer->image=$request->input('image');
            $customer->save();
            
            return $this->onSuccess(200, "Success", $customer);
        }
        return $this->onError(400, "Unauthorized");
    }

    public function deactivateTeamMember($teamMemberId,  Request $request)
    {
        if (Auth::user()) {
            $customer = Customer::find($teamMemberId);
            $customer->is_active=$request->input('is_active');
            $customer->save();
            return $this->onSuccess(200, "Success", $customer);
        }
        return $this->onError(400, "Unauthorized");
    }
}
