<?php

namespace App\Http\Controllers\Admin\Auth;
use Common;

use App\Http\Controllers\Controller;
use App\managers\UserManager;
use App\Providers\RouteServiceProvider;
use App\TraitLibraries\RolePermissionEngine;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware('guest:admin')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $user = \auth('admin')->user();
        $role = $user->role;
        if ($role != UserManager::AlphaRoleSuper) {
            $this->setMergeRolePermissions($user->roles);

            if (!empty($this->permissions))
                $request->session()->put('permissions', $this->permissions);
        }

        /*$user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);*/
        $request->session()->put('user_role', $role);


    }
    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse(['status'=>'success','action'=>'redirect','url'=>'/admin/dashboard'], 200)
            : redirect()->intended($this->redirectPath());
    }

    public function attemptLogin(Request $request)
    {
        return Auth::guard('admin')->attempt(
            ['username' => $request->username, 'password' => $request->password, 'active' => 1],
            $request->filled('remember')
        );
    }
    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
