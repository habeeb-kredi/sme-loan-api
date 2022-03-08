<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
            if($request->hasFile('cv'))
            {
                $request->file('cv')->store('cv');
            }
            if($request->hasFile('st'))
            {
                $request->file('st')->store('st');
            }
    }
}
