<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Dashboard;
use Illuminate\Support\Facades\Auth;

class ManageDashboardController extends BaseController
{
    public $module = "Dashboard";

    protected $mainViewFolder = 'admin.dashboard.manage-dashboard.';

    public function index(Request $request)
    {
        $userData = Admin::loggedUserData();
        if($userData['organizationId'] > 0){
            return view($this->mainViewFolder . 'organization_index',compact('userData'));

        }else{
            return view($this->mainViewFolder . 'index',compact('userData'));
        }


    }


}
