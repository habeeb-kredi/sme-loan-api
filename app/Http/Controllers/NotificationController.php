<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Helper\ApiResponseHelper;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    use ApiResponseHelper;
    public function viewNotifications()
    {
        if(Auth::check()){ //customer
        
            return $this->onSuccess(200, "Success", Notification::CustomerKyc(Auth::user()->customer_kyc_id)->get());
        }
        return $this->onError('400', 'Unauthorized');
    }
}
