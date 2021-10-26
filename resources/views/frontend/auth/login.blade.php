@extends('layouts.layoutfront')
@section('title', 'Register/Login')
@section('content')
<main class="login-form mt-5">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <p>Please first login or register for add to cart and checkout functionality.</p>
                <p>The website is in development mode, please login after registered your self.</p>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                         @if($errors->has('sonarError'))
                         <div class="alert alert-danger mt-3">
                            {{$errors->first('sonarError')}}
                         </div> 
                         @endif
                        <form action="{{ route('register') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-7">
                                    <input type="text" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}" name="name" required autofocus>
                                     @if($errors->has('name'))
                                     <div class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emailAddressRegistration" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-7">
                                    <input type="email" id="emailAddressRegistration" class="form-control {{ $errors->has('emailAddressRegistration') ? 'is-invalid' : '' }}" value="{{ old('emailAddressRegistration') }}" name="emailAddressRegistration" required autofocus>
                                     @if($errors->has('emailAddressRegistration'))
                                     <div class="invalid-feedback">
                                        <strong>{{ $errors->first('emailAddressRegistration') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="registration_password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-7">
                                    <input type="password" id="registration_password" class="form-control {{ $errors->has('registration_password') ? 'is-invalid' : '' }}" name="registration_password" value="" required>
                                     @if($errors->has('registration_password'))
                                     <div class="invalid-feedback">
                                        <strong>{{ $errors->first('registration_password') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="registration_password_confirmation" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-7">
                                    <input type="password" id="registration_password_confirmation" class="form-control {{ $errors->has('registration_password_confirmation') ? 'is-invalid' : '' }}" value="" name="registration_password_confirmation" required>
                                     @if($errors->has('registration_password_confirmation'))
                                     <div class="invalid-feedback">
                                        <strong>{{ $errors->first('registration_password_confirmation') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone_numbers" class="col-md-4 col-form-label text-md-right">Phone</label>
                                <div class="col-md-7">
                                    <select name="phone_type" class="form-control {{ $errors->has('phone_type') ? 'is-invalid' : '' }}" id="phone_type" required>
                                        <option>Select Type</option>
                                        <option value="1" {{old('phone_type')==1 ? "selected" : ""}}>Home</option>
                                        <option value="2" {{old('phone_type')==2 ? "selected" : ""}}>Work</option>
                                        <option value="3" {{old('phone_type')==3 ? "selected" : ""}}>Mobile</option>
                                    </select>
                                    <input type="number" id="phone_numbers" class="form-control {{ $errors->has('phone_numbers') ? 'is-invalid' : '' }}" value="{{old('phone_numbers')}}" name="phone_numbers" required>
                                    @if($errors->has('phone_numbers'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('phone_numbers') }}</strong>
                                        </div>
                                    @endif
                                    @if($errors->has('phone_type'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('phone_type') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="accountType" class="col-md-4 col-form-label text-md-right">Account Type</label>
                                <div class="col-md-7">
                                    <select required="" id="accountType" name="accountType" class="form-control {{ $errors->has('accountType') ? 'is-invalid' : '' }}">
                                        <option value="">Select</option>
                                        @foreach($accountTypes as $type)
                                        <option value="{{$type->sonar_id}}" {{old('accountType')==$type->sonar_id ? "selected" : "" }}>{{$type->name}}</option>
                                        @endforeach
                                    </select>
                                     @if($errors->has('accountType'))
                                     <div class="invalid-feedback">
                                        <strong>{{ $errors->first('accountType') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <h4>Address:</h4>
                            <hr>
                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right">Country</label>
                                <div class="col-md-7">
                                    <input type="text" disabled=""  value="United Kingdom"  class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="baseLocation" class="col-md-4 col-form-label text-md-right">Base Location</label>
                                <div class="col-md-7">
                                    <select required="" id="baseLocation" name="baseLocation" class="form-control {{ $errors->has('baseLocation') ? 'is-invalid' : '' }}">
                                        <option value="">Select</option>
                                        <option value="RAF Alconbury"  {{old('baseLocation')=="RAF Alconbury" ? "selected" : ""}}>RAF Alconbury</option>
                                        <option value="RAF Lakenheath" {{old('baseLocation')=="RAF Lakenheath" ? "selected" : ""}}>RAF Lakenheath</option>
                                        <option value="RAF Mildenhall" {{old('baseLocation')=="RAF Mildenhall" ? "selected" : ""}}>RAF Mildenhall</option>
                                        <option value="RAF Feltwell" {{old('baseLocation')=="RAF Feltwell" ? "selected" : ""}}>RAF Feltwell</option>

                                    </select>
                                     @if($errors->has('baseLocation'))
                                     <div class="invalid-feedback">
                                        <strong>{{ $errors->first('baseLocation') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dormsOrHouses" class="col-md-4 col-form-label text-md-right">Dorms or Houses</label>
                                <div class="col-md-7">
                                    <select required="" id="dormsOrHouses" name="dormsOrHouses" class="form-control {{ $errors->has('dormsOrHouses') ? 'is-invalid' : '' }}">
                                        <option value="">Select</option>
                                        @foreach($accountGroups as $group)
                                        <option  {{old('dormsOrHouses')==$group->sonar_id ? "selected" : "" }} value="{{$group->sonar_id}}">{{$group->name}}</option>
                                        @endforeach
                                    </select>
                                     @if($errors->has('dormsOrHouses'))
                                     <div class="invalid-feedback">
                                        <strong>{{ $errors->first('dormsOrHouses') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="roomOrHouseNumber" class="col-md-4 col-form-label text-md-right">Room/House Number</label>
                                <div class="col-md-7">
                                    <input type="text" required="" value="{{old('roomOrHouseNumber')}}" id="roomOrHouseNumber" name="roomOrHouseNumber" class="form-control {{ $errors->has('roomOrHouseNumber') ? 'is-invalid' : '' }}">
                                    @if($errors->has('roomOrHouseNumber'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('roomOrHouseNumber') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right">City Name</label>
                                <div class="col-md-7">
                                    <input type="text" required="" value="{{old('city')}}" id="city" name="city" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}">
                                    @if($errors->has('city'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stateProvince" class="col-md-4 col-form-label text-md-right">State/Province</label>
                                <div class="col-md-7">
                                    <select required="" id="stateProvince" name="stateProvince" class="form-control {{ $errors->has('stateProvince') ? 'is-invalid' : '' }}">
                                        <option value="">Select</option>
                                        @foreach(\App\Helpers\Common::subdivision() as $stateKey=>$stateValue)
                                            <option  {{old('stateProvince')==$stateValue ? "selected" : "" }} value="{{$stateValue}}">{{$stateKey}}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('stateProvince'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('stateProvince') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="zip" class="col-md-4 col-form-label text-md-right">Zip</label>
                                <div class="col-md-7">
                                    <input type="text" required="" value="{{old('zip')}}" id="zip" name="zip" class="form-control {{ $errors->has('zip') ? 'is-invalid' : '' }}">
                                    @if($errors->has('zip'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('zip') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                    </form>
                </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Login</div>
                    <form action="{{ route('login') }}" method="post">
                    <div class="card-body">

                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-7">
                                    <input type="text" id="email_address" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" name="email" required autofocus>
                                     @if($errors->has('email'))
                                     <div class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-7">
                                    <input type="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" required>
                                     @if($errors->has('password'))
                                     <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type=submit class="btn btn-block btn-primary">
                                   Login
                               </button>
                                <a href="{{route('password.request')}}" class="btn btn-link">
                                    Forgot Your Password?
                                </a>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection

