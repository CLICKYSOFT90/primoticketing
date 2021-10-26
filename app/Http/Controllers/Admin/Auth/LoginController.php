<?php

namespace App\Http\Controllers\Admin\Auth;
use Common;

use App\Http\Controllers\Controller;
use App\managers\UserManager;
use App\Providers\RouteServiceProvider;
use App\TraitLibraries\RolePermissionEngine;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers,RolePermissionEngine;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        if ($user->alphaRole != UserManager::AlphaRoleSuper) {
            $this->setMergeRolePermissions($user->roles);

            if (!empty($this->permissions))
                $request->session()->put('permissions', $this->permissions);
        }

        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);
        $request->session()->put('user_role', $user->alphaRole);


    }

    public function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            ['email' => $request->email, 'password' => $request->password, 'active' => 1],
            $request->filled('remember')
        );
    }
}
