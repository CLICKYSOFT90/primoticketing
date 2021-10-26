<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\AccountType;
use App\Models\Address;
use App\Models\AccountGroup;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $acountType = AccountType::get();
        $serviceableAddress = Address::whereNull('addressable_id')->get();
        $accountGroup = AccountGroup::get();
        return view('frontend.auth.login', ['url' => '','accountTypes'=>$acountType,'serviceableAddress'=>$serviceableAddress,'accountGroups'=>$accountGroup]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'emailAddressRegistration' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone_type' => ['required', 'numeric'],
            'phone_numbers' => ['required', 'numeric'],
            'registration_password' => ['required', 'string', 'min:8','confirmed'],
            'accountType' => ['required'],
            'baseLocation' => ['required'],
            'dormsOrHouses' => ['required'],
            'roomOrHouseNumber' => ['required'],
            'city' => ['required'],
            'stateProvince' => ['required'],
            'zip' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create($request)
    {
         return  Website::userCreateOrUpdate(0, $request);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request)));

        session()->flash('success', 'Account Registered successfully');

        //$this->guard('web')->login($user);

        if ($response = $this->registered($request, $user)) {
            return redirect(route("front"));
        }


        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
      //auth()->loginUsingId($user->id);
      Auth::guard('web')->loginUsingId($user->id);
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

}
