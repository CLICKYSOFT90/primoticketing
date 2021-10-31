<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\Admin;
use App\Models\Customer;
use App\TraitLibraries\AlertMessages;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use App\Models\Role;
use App\Models\User;
use App\Models\Flag;
use App\Models\Parties;
use Common;

class ManageUsersController extends Controller
{
    use AlertMessages;

    public $module = "User";

    protected $mainViewFolder = 'admin.users.manage-users.';

    protected $_user;

    public $permissions = Array(
        "index" => "read",
        "show" => "read",
        "create" => "create",
        "update" => "update",
        "edit" => "update",
        "destroy" => "delete",
    );

    public function __construct(User $user)
    {
        $this->_user = $user;
        if(isset($this->module)){
            \View::share('module', $this->module);
        }
    }


    public function index(Request $request)
    {
        if($request->ajax()){
            return  Datatables::of(Admin::getList())
                    ->addColumn('action', function ($data){
                        return Admin::actionButtons($data);
                    })->editColumn('created_at', function ($data){
                        return \App\Helpers\Common::CTL($data->created_at);
                    })->editColumn('organization_name', function ($data){
                        if(!empty($data->organization->organization_name)){
                            return $data->organization->organization_name;
                        }else{
                            return '';
                        }
                    })->addColumn('active', function ($data){
                    if($data->active==1){
                        return '<span class="label label-success">Active</span>';
                    }else{
                        return '<span class="label label-danger">InActive</span>';
                    }
                })->rawColumns(['action','active'])->make(true);
        }
        return view($this->mainViewFolder . 'index');
    }

    public function create()
    {
        $model = new Admin();
        $roles = Role::all();
        $assigned_role_array = [];
        return view($this->mainViewFolder . 'form', compact('model','roles', 'assigned_role_array'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(Admin::validationRules(0),[],['active'=>'Status']);
        $request->merge(['timezone'=>'US/Central']);

        $this->_user = new Admin($request->all());

        $role = $request->get('role_id');

        if (!$this->_user->save())
            throw new \Exception($this->setAlertError('User'));

        if($request->alphaRole=="USERS" && !empty($role)){
        // assign Role to user
            $this->addRoles(array_diff($request->get('role_id'), $this->_user->roleIds));
        }
        $request->session()->flash('success', $this->setAlertSuccess('User', 'create'));

        $redirect = 'users.index';

        if($request->save_btn && $request->save_btn == config('constants.SAVE_ADD_MORE')){
            $redirect = 'users.create';
        }

        return redirect()->route($redirect);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $model = Admin::find($id);
        if(!empty($model)){
            $roles = Role::all();
            $assigned_role_array = [];
            foreach ($model->roles as $assigned_role){
                $assigned_role_array[] =  $assigned_role->id;
            }
            return view($this->mainViewFolder.'show', compact('model', 'roles', 'assigned_role_array'));
        }
        else{
            $request->session()->flash('warning', $this->setAlertError('User', 'none'));
            return redirect(route('users.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Admin::find($id);
        $model->password = null;
        $roles = Role::all();
        $assigned_role_array = [];
        foreach ($model->roles as $assigned_role){
            $assigned_role_array[] =  $assigned_role->id;
        }

        return view($this->mainViewFolder . 'form', compact('model','roles','assigned_role_array'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate(Admin::validationRules($id));


        try {
            // Start Transaction

            DB::beginTransaction();
            $user_input = $request->all();
            $this->_user = $this->_user->findOrFail($id);

            //set Alpha Role
            $this->_user->alphaRole = $request->input('alphaRole');
            if($this->_user->alphaRole == "USERS"){
                // assign Role to user
                $this->addRoles(array_diff($request->get('role_id'), $this->_user->roleIds));
                // remove assign roles to user
                $this->removesRoles(array_diff($this->_user->roleIds, $request->get('role_id')));
            }

            if($request->input('password')==""){
                unset($user_input['password']);
            }

            if (!$this->_user->update($user_input))
                throw new \Exception($this->setAlertError('User', 'update'));


            DB::commit();

            $request->session()->flash('success', $this->setAlertSuccess('User', 'update'));
            return redirect(route('users.index'));

        } catch (\Exception $exception) {
            DB::rollBack();
            $request->session()->flash('error', $exception->getMessage());
        }

        return back()->withInput($request->all());


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = Admin::find($id);
        if ($user->delete()) {
            $request->session()->flash('success', $this->setAlertSuccess('User', 'delete'));
        }
        return redirect(route('users.index'));
    }


    protected function addRoles(Array $adds)
    {
        // assign Role to user
        foreach ($adds as $roleId):
            $role = Role::findOrFail($roleId);
            if (!empty($role))
                $this->_user->roles()->attach($role);
        endforeach;
    }

    /**
     * Remove Role from the User.
     * @param  array $removes
     */
    protected function removesRoles(Array $removes)
    {
        // remove assign permission to Role
        foreach ($removes as $roleId):
            $role = Role::findOrFail($roleId);
            if (!empty($role))
                $this->_user->roles()->detach($role);
        endforeach;
    }
}
