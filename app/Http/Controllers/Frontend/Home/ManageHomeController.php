<?php

namespace App\Http\Controllers\Frontend\Home;

use App\BusinessPersonalLoan;
use App\ContactUs;
use App\Helpers\Common;
use App\HomePage;
use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;

class ManageHomeController extends Controller
{
    protected $mainViewFolder = 'frontend.';
    //
    public function index()
    {
        echo "Welcome to website.";
        return false;

        return view($this->mainViewFolder .'index');
        
    }


    public function ajaxCall(Request $request,$slug){

        switch ($slug) {
            case "contact_form":
                $input = $request->all();
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'phone' => 'required',
                    'email' => 'required|email',
                    'message' => 'required',
                ]);


                if ($validator->passes()) {
                    $input['ip'] = $request->ip();
                    return response()->json(['success'=>'Added new records.']);
                }

                return response()->json(['error'=>"Please fill out all fields"]);
                //return response()->json(['error'=>$validator->errors()->all()]);
                break;
            default:
                echo "";
        }
    }
}
