<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityTracker;
use App\Http\Requests\ActivityTrackerRequest;
use Illuminate\Support\Facades\Auth;
use App\Helper\ApiResponseHelper;
class ActivityTrackerController extends Controller
{
    use ApiResponseHelper;
    public function storeActivity(ActivityTrackerRequest $request)
    {
        if(Auth::user()){
           $activity =  ActivityTracker::create($request->all());
           return $this->onSuccess(200, "Success", $activity);
        }   
               return $this->onError(400, "Unauthorized");
    }
}
