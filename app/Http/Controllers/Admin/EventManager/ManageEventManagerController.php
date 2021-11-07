<?php

namespace App\Http\Controllers\Admin\EventManager;

use App\Helpers\Common;
use App\Models\AccountGroup;
use App\Models\AccountType;
use App\Models\Address;
use App\Models\Admin;
use App\Models\EventChild;
use App\Models\EventParent;
use App\Models\EventTicket;
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

class ManageEventManagerController extends BaseController
{
    use AlertMessages, ResponseWithHttpStatus;

    public $module = "EventManager";

    public $permissions = Array(
        "index" => "read",
        "show" => "read",
        "create" => "create",
        "edit" => "update",
        "destroy" => "delete",
    );

    protected $mainViewFolder = 'admin.event-manager.manage-event-manager.';

    public function index(Request $request)
    {
        if($request->ajax()){
            return  Datatables::of(EventParent::getList())
                ->addColumn('action', function ($data){
                    return EventParent::actionButtons($data);
                })->addColumn('nested_events', function ($data){
                    return number_format($data->childEvent->count());
                })->addColumn('total_tickets_sold', function ($data){
                    return 0;
                })->addColumn('info', function ($data){
                    return "infos";
                })->rawColumns(['action','info'])->make(true);
        }

        return view($this->mainViewFolder . 'index');
    }

    public function getChildEvent(Request $request)
    {
        if($request->ajax()){
            return  Datatables::of(EventChild::getList())
                ->addColumn('action', function ($data){
                    return EventChild::actionButtons($data);
                })->addColumn('parent_name', function ($data){
                    return $data->parentEvent->name;
                })->editColumn('event_start', function ($data){
                    $date = Common::CTL($data->event_start,true);
                    return $date;
                })->addColumn('total_tickets_sold', function ($data){
                    return 0;
                })->rawColumns(['action'])->make(true);
        }

        return view($this->mainViewFolder . 'index');
    }

    public function create(Request $request)
    {
        $eventType = EventType::get();
        $ticketType = [];
        $model =  new EventParent();
        $childEvent = new EventChild();
        $tickets = new EventTicket();


        return view($this->mainViewFolder . 'form',compact('eventType','ticketType','model','childEvent','tickets'));
    }



    public function edit($id)
    {

        $model = EventParent::find($id);

        if(empty($model->id)){
            request()->session()->flash('error', 'No record found');
            return redirect()->route("eventManager.index");
        }
        $eventType = EventType::get();
        $ticketType = TicketType::whereIN('event_type_id',[$model->event_type_id,-1])->get();
        $childEvent = EventChild::where('parent_event_id',$model->id)->get();
        $tickets = EventTicket::where('parent_event_id',$model->id)->get();
        return view($this->mainViewFolder . 'form',compact('eventType','ticketType','model','childEvent','tickets'));
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
        $request->validate(EventParent::validationRules((!empty(@$request->input('id')) ? $request->input('id') : 0)), EventParent::validationMsgs());

        DB::beginTransaction();
        try {
            $organizationId = Admin::loggedUserData()['organizationId'];

            if ($request->file('event_photo_file')) {
                $imagePath = $request->file('event_photo_file');
                $ext = $imagePath->getClientOriginalExtension();
                //$imageName = $imagePath->getClientOriginalName();
                $imageName = "event_photo_".uniqid()."_".date('YmdHis').".".$ext;
                $request->file('event_photo_file')->storeAs('uploads', $imageName, 'public');
                $request->merge(['event_photo'=> $imageName]);
            }
            if ($request->file('event_gallery_file')) {
                $imagePath = $request->file('event_gallery_file');
                $ext = $imagePath->getClientOriginalExtension();
                //$imageName = $imagePath->getClientOriginalName();
                $imageName = "event_gallery_".uniqid()."_".date('YmdHis').".".$ext;
                $request->file('event_gallery_file')->storeAs('uploads', $imageName, 'public');
                $request->merge(['event_gallery'=> $imageName]);
            }
            $model = new EventParent($request->all());
            $action = "created";
            $redirect = 'eventManager.index';

            if(!empty(@$request->input('id'))){
                $model = EventParent::find($request->input('id'));
                if(empty($model->id)){
                    DB::rollBack();
                    return new JsonResponse(['errors'=>['event_parent'=>['The record does not exist in system. Please refresh the page and try again.']]], 422);
                }
                $model->loadModel($request->all());
                $action = "updated";
                $redirect = 'eventManager.index';
            }
            $model->organization_id = $organizationId;
            if (!$model->save()){
                DB::rollBack();
                return new JsonResponse(['errors'=>['event_parent'=>['Error in save record. Please refresh the page and try again.']]], 422);

            }
            $parent_id = $model->id;
            foreach ($request->CERow as $sr => $row) {

                if (@$row['delete'] == 1) {
                    EventChild::destroy($row['id']);
                } else {
                    $row['organization_id'] = $organizationId;
                    $row['parent_event_id'] = $parent_id;
                    $row['event_start'] = Common::CFL($row['event_start']);
                    $row['event_end'] = Common::CFL($row['event_end']);
                    $modelChildEvent = new EventChild($row);
                    if (!empty(@$row['id'])) {
                        $modelChildEvent = EventChild::find($row['id']);
                        if(empty($modelChildEvent->id)){
                            DB::rollBack();
                            return new JsonResponse(['errors'=>['event_child'=>['The event list record('.$row['name'].') does not exist in system. Please refresh the page and try again.']]], 422);
                        }
                        $modelChildEvent->loadModel($row);
                    }
                    if(!empty($request->file('CERow')[$sr]['event_icon'])) {
                        $file = $request->file('CERow')[$sr]['event_icon'];
                        $ext = $file->getClientOriginalExtension();
                        $imageName = "event_icon_".uniqid()."_".date('YmdHis').".".$ext;
                        $file->storeAs('uploads',$imageName, 'public');
                        $modelChildEvent->event_icon = $imageName;
                    }

                    if (!$modelChildEvent->save()) {
                        DB::rollBack();
                        return new JsonResponse(['errors'=>['saving_date'=>['Error in save data. Please refresh the page and try again.']]], 422);
                    }
                }
            }

            foreach ($request->TTRow as $sr => $row) {
                if (@$row['delete'] == 1) {
                    EventTicket::destroy($row['id']);
                } else {
                    $row['organization_id'] = $organizationId;
                    $row['parent_event_id'] = $parent_id;
                    $ticketTypeName = TicketType::find($row['ticket_type_id']);
                    if(empty($ticketTypeName->name)){
                        return new JsonResponse(['errors'=>['ticket'=>['The selected ticket name record does not exist in system. Please refresh the page and try again.']]], 422);

                    }
                    $row['ticket_type_name'] = $ticketTypeName->name;
                    $modelTicket = new EventTicket($row);

                    if (!empty(@$row['id'])) {
                        $modelTicket = EventTicket::find($row['id']);
                        if(empty($modelTicket->id)){
                            DB::rollBack();
                            return new JsonResponse(['errors'=>['ticket'=>['The provided ticket record does not exist in system. Please refresh the page and try again.']]], 422);
                        }
                        $modelTicket->loadModel($row);
                    }

                    if (!$modelTicket->save()) {
                        return new JsonResponse(['errors'=>['saving_date'=>['Error in save data. Please refresh the page and try again.']]], 422);
                    }
                }
            }
            DB::commit();
            $request->session()->flash('success','Event '.$action.' successfully.');
            if($request->wantsJson()){
                return new JsonResponse(['status'=>'success','action'=>'redirect','url'=>'/admin/eventManager'],200);
            }else{
                return redirect()->route("eventManager.index");
            }


        }catch (\Exception $ex) {
            DB::rollBack();
            if($request->wantsJson()){
                return new JsonResponse(['errors'=>['exception'=>[$ex->getMessage()]]], 422);
            }else{
                $request->session()->flash('error', $ex->getMessage());
                return redirect()->route("eventManager.index");
            }

        }
        return false;
    }

    public function getEventTypeTicket(Request $request)
    {
        if(!empty(@$request->input('event_type_id'))){
            $result =  TicketType::whereIn('event_type_id',[-1,$request->input('event_type_id')])
                ->where('active',1)
                ->select('id','name','default_price','default_limit')
                ->get();
            return json_encode($result);
        }
    }


}
