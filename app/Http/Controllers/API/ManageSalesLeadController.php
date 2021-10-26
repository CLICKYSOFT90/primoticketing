<?php

namespace App\Http\Controllers\API;

use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Models\Flag;
use App\Models\SalesLead;
use App\Models\VehicleType;
use App\TraitLibraries\ResponseWithHttpStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\SalesLead\ManageSalesLeadController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ManageSalesLeadController extends BaseController
{
    use ResponseWithHttpStatus;

    public function __construct(SalesLead $salesLead)
    {
        $this->model = $salesLead;
    }

    public function index(Request $request)
    {
        $result['vehicleTypes'] = VehicleType::where('active',1)->select('id','name')->get();
        $result['goodsType'] = Flag::where('flagType', 'goods_type')->select('name')->get()->pluck('name');
        $result['services'] = Flag::where('flagType', 'service')->select('name')->get()->pluck('name');
        return $this->responseSuccess(config('api.response.messages.200'), $result, 200);
    }

    public function show( $id)
    {
        return false;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
            try {

                $newUser =false;
                $customer = Customer::where('phone', '=', $request->phone)->where('active', '=', 1)->first();
                if (empty($customer->id)) {
                    $userRecord = User::where('contactNumber',$request->phone)->first();
                    if(empty($userRecord->id)){
                        $checkEmail = User::where('email',$request->email)->first();
                        if(!empty($checkEmail->id)){
                            return $this->responseFailure("This email address is linked with different phone number, please provide new email address", 422);
                        }
                        $request->merge(['roleName'=>'Customer','email'=>$request->email,'name'=>$request->name,'contactNumber'=>$request->phone,'alphaRole'=>'USERS']);
                        $userRecord = User::userCreateOrUpdate(0,$request);
                        $newUser =true;
                    }

                    $customer = new Customer();
                    $customer->fullName = $request->name;
                    $customer->phone = $request->phone;
                    $customer->email =  $request->email ;
                    $customer->active = 1;
                    $customer->userId = $userRecord['id'];
                    $customer->entryStatus = "Api";
                    $customer->type = $customer::$type;
                    $customer->save();
                }

                $validator = \Validator::make($request->all(), SalesLead::validationRules(0));
                if ($validator->fails()) {
                    return $this->responseFailure($validator->errors()->first(), 422);
                }
                $record =  parent::store($request);
                DB::commit();
                $result = ['newUser'=>$newUser,'userData'=>!empty($userRecord) ? $userRecord : [],'leadData'=>$record];
                return $this->responseSuccess(config('api.response.messages.200'), $result, 200);
            }
            catch (\Exception $ex)
            {
                DB::rollBack();
                return $this->responseFailure($ex->getMessage(), 422);
                return $this->responseFailure("There is something error to generate lead, please try again.", 422);
            }

    }
}
