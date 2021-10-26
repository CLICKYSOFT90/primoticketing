<?php

namespace App\Http\Controllers\Auth;
use Common;

use App\Http\Controllers\Controller;
use App\managers\UserManager;
use App\Providers\RouteServiceProvider;
use App\TraitLibraries\RolePermissionEngine;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountType;
use App\Models\Address;
use App\Models\AccountGroup;

class WebsiteLoginController extends Controller
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
        $this->middleware('guest', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        $acountType = AccountType::get();
        $serviceableAddress = Address::whereNull('addressable_id')->get();
        $accountGroup = AccountGroup::get();
        return view('frontend.auth.login', ['url' => '','accountTypes'=>$acountType,'serviceableAddress'=>$serviceableAddress,'accountGroups'=>$accountGroup]);
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password,'active'=>1], $request->get('remember'))) {

            return redirect('/');
        }
        return back()->withInput($request->only('email', 'remember'))->withErrors(['email'=>'These credentials do not match our records']);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
