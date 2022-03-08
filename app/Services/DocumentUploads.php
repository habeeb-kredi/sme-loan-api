<?php

namespace App\Services;

class DocumentUploads
{
        public function upload($request, $request_name, $file_path)
        {
            if($request->hasFile($request_name)){
                $uniqueFileName = md5(time());
                $randomNumber = mt_rand(0, 99999999);
                $getExtension = $request->file($request_name)->getClientOriginalExtension();
                $fullFilePath = $uniqueFileName.$randomNumber.'.'.$getExtension;
                $filePath = $request->file($request_name)->storeAs(
                    $file_path, $fullFilePath
                );
                return $fullFilePath;
            }

        }

    //        if($request->hasFile('CAC')){
//            $uniqueFileName = md5(time());
//            $getExtension = $request->file('CAC')->getClientOriginalExtension();
//            $cacFile = $request->file('CAC')->storeAs(
//                'cac_documents', $uniqueFileName.'.'.$getExtension
//            );
//        }
//        if($request->hasFile('utility')){
//            $uniqueFileName = md5(time());
//            $getExtension = $request->file('utility')->getClientOriginalExtension();
//            $cacFile = $request->file('utility')->storeAs(
//                'utility_documents', $uniqueFileName.'.'.$getExtension
//            );
//        }
//        if($request->hasFile('bank_statement')){
//            $uniqueFileName = md5(time());
//            $getExtension = $request->file('bank_statement')->getClientOriginalExtension();
//            $cacFile = $request->file('bank_statement')->storeAs(
//                'bank_statement_documents', $uniqueFileName.'.'.$getExtension
//            );
//        }

}