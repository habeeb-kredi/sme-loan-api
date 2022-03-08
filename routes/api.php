<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix'=>'v1'], function(){
    Route::post('/register', [\App\Http\Controllers\CustomerController::class, 'registerCustomer']);

    Route::post('/login', [\App\Http\Controllers\CustomerController::class, 'loginCustomer']);
    Route::post('/verify-email', [\App\Http\Controllers\CustomerController::class, 'verifyEmail']);

    Route::middleware('auth:sanctum')->group(function () {
//    return $request->user();
        Route::post('/register-kyc', [\App\Http\Controllers\CustomerKycController::class, 'registerBusinessDetails']);
        Route::post('/register-documents', [\App\Http\Controllers\CustomerKycController::class, 'registerBusinessDocuments']);

        Route::patch('/account/{id}', [\App\Http\Controllers\CustomerController::class, 'editTeamMember']); 
        Route::patch('/account/{id}/upload', [\App\Http\Controllers\CustomerController::class, 'updateProfilePicture']); 
        Route::patch('/account/deactivate/{id}', [\App\Http\Controllers\CustomerController::class, 'deactivateTeamMember']); 


        Route::post('/verify-otp', [\App\Http\Controllers\CustomerController::class, 'verifyOTP']);

        // Loan
        Route::post('/loan', [\App\Http\Controllers\LoanSettingController::class, 'createLoan']); 
        Route::get('/loan/summary', [\App\Http\Controllers\LoanSettingController::class, 'loanDetailsSummary']);
        Route::get('/loan/repayments/schedule', [\App\Http\Controllers\LoanSettingController::class, 'loanRepaymentSchedules']);
        Route::get('/loan/disbursement', [\App\Http\Controllers\LoanSettingController::class, 'disburseLoanToSavings']);

        // Team
        Route::post('/team', [\App\Http\Controllers\CustomerController::class, 'addTeamMember']); 
        Route::patch('/team/{id}', [\App\Http\Controllers\CustomerController::class, 'editTeamMember']); 
        Route::patch('/team/{id}/upload', [\App\Http\Controllers\CustomerController::class, 'updateProfilePicture']); 
        Route::patch('/team/deactivate/{id}', [\App\Http\Controllers\CustomerController::class, 'deactivateTeamMember']); 
         
        // Bank Card
        Route::post('/card', [\App\Http\Controllers\BankCardController::class, 'addBankCard']); 
        Route::get('/cards/{customer_kyc_id}/customer-kyc', [\App\Http\Controllers\BankCardController::class, 'viewCards']); 
        Route::patch('/card/{id}', [\App\Http\Controllers\BankCardController::class, 'updateBankCard']); 
        Route::delete('/card/{id}/delete', [\App\Http\Controllers\BankCardController::class, 'deleteBankCard']); 

        // Bank Details
        Route::post('/bank-details', [\App\Http\Controllers\BankDetailsController::class, 'addBankDetail']); 
        Route::get('/bank-detail/{customer_kyc_id}/customer-kyc', [\App\Http\Controllers\BankDetailsController::class, 'viewBankDetails']); 
        Route::patch('/bank-detail/{id}', [\App\Http\Controllers\BankDetailsController::class, 'updateBankDetails']); 
        Route::delete('/bank-detail/{id}/delete', [\App\Http\Controllers\BankDetailsController::class, 'deleteBankDetails']); 
        
        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'viewNotifications']); 
        
        // Activity
        Route::post('/activity', [\App\Http\Controllers\ActivityTrackerController::class, 'storeActivity']); 
       
       
        Route::post('/upload', [\App\Http\Controllers\UploadController::class, 'upload']); 
        
        

    });

});
