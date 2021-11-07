<?php

namespace App\Http\Controllers\Frontend\MyAccount;

use App\BusinessPersonalLoan;
use App\ContactUs;
use App\HomePage;
use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Service;
use App\TraitLibraries\ResponseWithHttpStatus;

class ManageMyAccountController extends Controller
{
    use ResponseWithHttpStatus;
    protected $mainViewFolder = 'frontend.myaccount.';

    //
    public function index()
    {
        /*$data = [];
        $accountDetail = Website::getAccountDetail();
        //dd($accountDetail);
        if($accountDetail['success']==true){
            $data = $accountDetail['data'];
        }*/
        //dd($data);
        return view($this->mainViewFolder . 'myaccount',compact('data'));
    }

    public function removeService(Request $request)
    {
        if(empty($request->id)){
            return $this->responseFailure("Please provide account service id", 422);
        }
        $accountServiceRemove = Website::removeAccountService($request->id);
        if($accountServiceRemove['success']==true){
            session()->flash('success', 'Service deleted successfully');
            Website::where('id',auth('web')->user()->id)->update(['isServicePurchased'=>0]);
            return $this->responseSuccess('Service deleted successfully', [], 200);
        }else{
            return $this->responseFailure($accountServiceRemove['msg'], 422);
        }
    }
}
