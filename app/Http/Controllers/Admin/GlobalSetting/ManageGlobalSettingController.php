<?php

namespace App\Http\Controllers\Admin\GlobalSetting;

use App\Models\AccountGroup;
use App\Models\AccountType;
use App\Models\Address;
use App\Models\Organization;
use App\Models\Service;
use App\TraitLibraries\AlertMessages;
use App\TraitLibraries\ResponseWithHttpStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Models\Flag;
use App\Models\FlagType;

class ManageGlobalSettingController extends BaseController
{
    use AlertMessages, ResponseWithHttpStatus;

    public $module = "GlobalSettings";

    public $permissions = Array(
        "index" => "read",
        "show" => "read",
        "create" => "create",
        "edit" => "update",
        "destroy" => "delete",
    );

    protected $mainViewFolder = 'admin.global-setting.manage-global-setting.';

    public function index(Request $request)
    {


        return view($this->mainViewFolder . 'index');
    }

    public function create()
    {
        $model = new Organization();
        return view($this->mainViewFolder . 'form',compact('model'));
    }

    public function edit($id)
    {
        $model = Organization::find($id);
        if(empty($model->id)){
            request()->session()->flash('error', 'No record found');
            return redirect()->route("organization.index");
        }
        return view($this->mainViewFolder . 'form',compact('model'));
    }

    public function show($id,Request $request)
    {
        $model = Organization::find($id);
        if(empty($model->id)){
            request()->session()->flash('error', 'No record found');
            return redirect()->route("organization.index");
        }
        return view($this->mainViewFolder.'show', compact('model'));
    }

    public function destroy(Request $request, $id)
    {
        $record = Customer::find($id);
        if($record->salesLead()->count() > 0){
            $request->session()->flash('error', 'The customer # '.$id.' can not be deleted, It is linked with Sales Lead.');
        }else{
            if(Customer::where('userId',$record->userId)->withoutGlobalScope('customerType')->count() > 1){
                $role = Role::where('roleName','Customer')->first();
                UserRole::where('user_id',$record->userId)->where('role_id',@$role->id)->forceDelete();
                $record->delete();
            }else{
                $role = Role::where('roleName','Customer')->first();
                UserRole::where('user_id',$record->userId)->where('role_id',@$role->id)->forceDelete();
                User::where('id',$record->userId)->delete();
                $record->delete();

            }
            $request->session()->flash('success', $this->setAlertSuccess('Customer', 'delete', $id));
        }

        return redirect(route('customer.index'));
    }

    public function store(Request $request)
    {
        $request->validate(Organization::validationRules(@$request->id));
        $unique_name = str_replace(" ","",strtolower($request->organization_icon));
        $unique_name = str_replace("-","_",strtolower($unique_name));
        $unique_name = preg_replace('/[^A-Za-z0-9\_]/', '', $unique_name);
        $request->merge(['organization_unique_url' => $unique_name]);

        $model = new Organization($request->all());
        $action = "create";
        $redirect = 'organization.index';

        if(!empty(@$request->input('id'))){
            $model = Organization::find($request->input('id'));
            $model->loadModel($request->all());
            $action = "update";
            $redirect = 'organization.index';
        }
        DB::beginTransaction();
        try{
            if (!$model->save())
                throw new \Exception($this->setAlertError('Organization', $action));

            $request->session()->flash('success', $this->setAlertSuccess('Organization', $action, $model->id));

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            $request->session()->flash('error', $ex->getMessage());
            return redirect()->route($redirect);
        }
        return redirect()->route($redirect);
    }

}
