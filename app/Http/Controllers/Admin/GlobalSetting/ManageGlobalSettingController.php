<?php

namespace App\Http\Controllers\Admin\GlobalSetting;

use App\Models\AccountGroup;
use App\Models\AccountType;
use App\Models\Address;
use App\Models\Admin;
use App\Models\EventType;
use App\Models\Organization;
use App\Models\Service;
use App\Models\SpecialWalkUpType;
use App\Models\TicketType;
use App\TraitLibraries\AlertMessages;
use App\TraitLibraries\ResponseWithHttpStatus;
use Illuminate\Http\JsonResponse;
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
        $eventType = EventType::get();
        $ticketType = TicketType::get();
        $walkUpType = SpecialWalkUpType::get();

        return view($this->mainViewFolder . 'index',compact('eventType','ticketType','walkUpType'));
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
        if(!empty($request->event_type) && $request->event_type == 1){

            $request->validate(EventType::validationRules(), EventType::validationMsgs());
            DB::beginTransaction();
            try {
                $organizationId = Admin::loggedUserData()['organizationId'];
                foreach ($request->ETRow as $sr => $row) {
                    if (@$row['delete'] == 1) {
                        if(TicketType::where('event_type_id',$row['id'])->count() > 0){
                            $eventType = EventType::find($row['id']);
                            DB::rollBack();
                            return new JsonResponse(['errors'=>['event_type'=>['No record updated. Event type '.$eventType->name.' can not be deleted, It is using in ticket type. Please refresh the page and try again.']]], 422);
                        }
                        EventType::destroy($row['id']);
                    } else {
                        $row['organization_id'] = $organizationId;
                        $model = new EventType($row);

                        if (!empty(@$row['id'])) {
                            $model = EventType::find($row['id']);
                            $model->loadModel($row);
                        }

                        if (!$model->save()) {
                            return new JsonResponse(['errors'=>['saving_date'=>['Error in save data. Please refresh the page and try again.']]], 422);
                        }
                    }
                }
                DB::commit();
                $request->session()->flash('success','Event type data updated successfully.');
                if($request->wantsJson()){
                    return new JsonResponse(['status'=>'success','action'=>'redirect','url'=>'/admin/globalSetting'],200);
                }else{
                    return redirect()->route("globalSetting.index");
                }


            }catch (\Exception $ex) {
                DB::rollBack();
                if($request->wantsJson()){
                    return new JsonResponse(['errors'=>['exception'=>[$ex->getMessage()]]], 422);
                }else{
                    $request->session()->flash('error', $ex->getMessage());
                    return redirect()->route("globalSetting.index");
                }

            }
        }else if(!empty($request->ticket_type) && $request->ticket_type == 1){
            $request->validate(TicketType::validationRules(), TicketType::validationMsgs());
            DB::beginTransaction();
            try {
                $organizationId = Admin::loggedUserData()['organizationId'];
                foreach ($request->TTRow as $sr => $row) {
                    if (@$row['delete'] == 1) {
                        TicketType::destroy($row['id']);
                    } else {
                        $row['organization_id'] = $organizationId;
                        $model = new TicketType($row);

                        if (!empty(@$row['id'])) {
                            $model = TicketType::find($row['id']);
                            $model->loadModel($row);
                        }

                        if (!$model->save()) {
                            return new JsonResponse(['errors'=>['saving_date'=>['Error in save data. Please refresh the page and try again.']]], 422);
                        }
                    }
                }
                DB::commit();
                $request->session()->flash('success','Ticket type data updated successfully.');
                if($request->wantsJson()){
                    return new JsonResponse(['status'=>'success','action'=>'redirect','url'=>'/admin/globalSetting'],200);
                }else{
                    return redirect()->route("globalSetting.index");
                }


            }catch (\Exception $ex) {
                DB::rollBack();
                if($request->wantsJson()){
                    return new JsonResponse(['errors'=>['exception'=>[$ex->getMessage()]]], 422);
                }else{
                    $request->session()->flash('error', $ex->getMessage());
                    return redirect()->route("globalSetting.index");
                }

            }

        }else if(!empty($request->walkup_type) && $request->walkup_type == 1){
            $request->validate(SpecialWalkUpType::validationRules(), SpecialWalkUpType::validationMsgs());
            DB::beginTransaction();
            try {
                $organizationId = Admin::loggedUserData()['organizationId'];
                foreach ($request->WTRow as $sr => $row) {
                    if (@$row['delete'] == 1) {
                        SpecialWalkUpType::destroy($row['id']);
                    } else {
                        $row['organization_id'] = $organizationId;
                        $model = new SpecialWalkUpType($row);

                        if (!empty(@$row['id'])) {
                            $model = SpecialWalkUpType::find($row['id']);
                            $model->loadModel($row);
                        }

                        if (!$model->save()) {
                            return new JsonResponse(['errors'=>['saving_date'=>['Error in save data. Please refresh the page and try again.']]], 422);
                        }
                    }
                }
                DB::commit();
                $request->session()->flash('success','SPECIAL WALK-UP TYPES data updated successfully.');
                if($request->wantsJson()){
                    return new JsonResponse(['status'=>'success','action'=>'redirect','url'=>'/admin/globalSetting'],200);
                }else{
                    return redirect()->route("globalSetting.index");
                }


            }catch (\Exception $ex) {
                DB::rollBack();
                if($request->wantsJson()){
                    return new JsonResponse(['errors'=>['exception'=>[$ex->getMessage()]]], 422);
                }else{
                    $request->session()->flash('error', $ex->getMessage());
                    return redirect()->route("globalSetting.index");
                }

            }

        }
        return false;
    }

}
