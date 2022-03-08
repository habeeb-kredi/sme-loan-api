<?php

namespace App\Http\Controllers;

use App\Helper\ApiResponseHelper;
use App\Models\Customer_kyc;
use App\Models\CustomerLoanDetails;
use App\Models\LoanSetting;
use App\Models\LoanTracking;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanSettingController extends Controller
{
    use ApiResponseHelper;
    public function createLoan(Request $request)
    {
        if(Auth::check()){ //customer
            $customerLoanSettings = CustomerLoanDetails::whereCustomerKycId(Auth()->user()->customer_kyc_id)->first(); //get customer loan details
         $customerLoanApplication = (new LoanService($customerLoanSettings))->createLoan($request, Auth::user()->customerKycs);
             return $this->onSuccess(200, "Success", $customerLoanApplication);
        }
        return $this->onError('400', 'Unauthorized');
    }

    public function loanDetailsSummary()
    {
        if(Auth::check()){ //customer

            $customerLoanTracking = LoanTracking::whereCustomerKycId(Auth()->user()->customer_kyc_id)->latest()->first(); //get customer latest loan details
            $customerLoanApplication = (new LoanService())->loanSummary($customerLoanTracking->loanId);
            return $this->onSuccess(200, "Success", $customerLoanApplication);
        }
        return $this->onError('400', 'Unauthorized');
    }


    public function loanRepaymentSchedules()
    {
        if(Auth::check()){ //customer
            $customerLoanTracking = LoanTracking::whereCustomerKycId(Auth()->user()->customer_kyc_id)->latest()->first(); //get customer latest loan details
            $customerLoanApplication = (new LoanService())->loanRepaymentSchedule($customerLoanTracking->loanId);
            return $this->onSuccess(200, "Success", $customerLoanApplication->repaymentSchedule);
        }
        return $this->onError('400', 'Unauthorized');
    }

    public function disburseLoanToSavings()
    {
        if(Auth::check()){ //customer
            $customerLoanTracking = LoanTracking::whereCustomerKycId(Auth()->user()->customer_kyc_id)->latest()->first(); //get customer latest loan details
            $customerLoanApplication = (new LoanService())->disburseLoan($customerLoanTracking->loanId); //get the loan summary
            if(optional($customerLoanApplication)->httpStatusCode == "400"){
                return $this->onError(400, optional($customerLoanApplication->errors[0])->developerMessage);
            }
            $loanTracking = LoanTracking::where('loanId', $customerLoanTracking->loanId)->first();
            $loanTracking->status = 1;
            $loanTracking->save();
            return $this->onSuccess(200, "Success", $loanTracking);
        }
        return $this->onError('400', 'Unauthorized');
    }

}
