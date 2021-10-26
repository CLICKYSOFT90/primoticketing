@extends('adminlte::master')
@section('title', 'Login')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@stop

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', 'login')

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="javascript:;">
            <img class="loginlogo" src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png'))}}">

        </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content portlet">
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" method="POST" autocomplete="off">
            {{ csrf_field() }}
            <!--        <h3 class="form-title font-green">Sign In</h3>-->
            <div id="error"></div>
            <div class="form-group form-md-line-input">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                <input class="form-control" type="text" placeholder="Username" name="email" id="username" autocomplete="new-username">
                <span class="help-block help-block-error"> </span>
                <div class="form-control-focus"> </div>
            </div>
            <div class="form-group form-md-line-input">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control" type="password" placeholder="Password" name="password" id="password" autocomplete="new-password">
                <span class="help-block help-block-error"> </span>
                <div class="form-control-focus"> </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn green uppercase btn-xs btn-outline" onclick="login();return false;">Login</button>
                <span class="md-checkbox has-success logincheck">
                <input type="checkbox" id="remember" class="md-check" name="remember" value="1">
                    <label for="remember">
                    <span class="inc"></span>
                    <span class="check"></span>
                    <span class="box"></span> Remember </label>
            </span>
                <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
            </div>

            <!--
                    <div class="create-account">
                        <p>
                            <a href="javascript:;" id="register-btn" class="uppercase">Create an account</a>
                        </p>
                    </div>
            -->
        </form>
        <!-- END LOGIN FORM -->
        <!-- BEGIN FORGOT PASSWORD FORM -->
        <form class="forget-form" method="POST" action="{{route('admin.password.email')}}">
            {{csrf_field()}}
            <h3 class="font-green">Forget Password ?</h3>
            <p> Enter your email address below to reset your password. </p>
            <div id="errorForget"></div>
            <div class="form-group form-md-line-input forget">
                <input class="form-control placeholder-no-fix" type="text" placeholder="email" name="email" id="usernameForget">
                <div class="form-control-focus"> </div>
            </div>
            <div class="form-actions">
                <button type="button" id="back-btn" class="btn dark btn-outline">Back</button>
                <button type="submit" class="btn green uppercase btn-outline pull-right forget" onclick="forget();return false;" id="forget-btn">Submit</button>
            </div>
        </form>
        <!-- END FORGOT PASSWORD FORM -->
        <!-- BEGIN REGISTRATION FORM -->

        <form class="register-form">

            <h3 class="font-green">Sign Up</h3>
            <div id="errorRegister"></div>
            <p class="hint"> Enter your personal details below: </p>
            <div class="form-group form-md-line-input register">
                <input class="form-control" type="text" placeholder="Name" name="nameRegister" id="nameRegister">
                <label class="control-label visible-ie8 visible-ie9">Name</label>
                <span class="form-control-focus"> </span>
            </div>
            <div class="form-group form-md-line-input register">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <input class="form-control placeholder-no-fix" type="text" placeholder="Username" name="usernameRegister" id="usernameRegister">
                <label class="control-label visible-ie8 visible-ie9">Username</label>
                <span class="form-control-focus"> </span>
            </div>
            <div class="form-group form-md-line-input register">
                <input class="form-control" type="password" id="passwordRegister" placeholder="Password" name="passwordRegister">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <span class="form-control-focus"> </span>
            </div>
            <div class="form-group form-md-line-input register">
                <input class="form-control" type="password" placeholder="Re-type Your Password" name="cpasswordRegister" id="cpasswordRegister">
                <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                <span class="form-control-focus"> </span>
            </div>
            <div class="form-group form-md-line-input register">
                <input class="form-control" type="email" placeholder="Email" name="emailRegister" id="emailRegister">
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <span class="form-control-focus"> </span>
            </div>
            <div class="form-group register">
                <label class="control-label visible-ie8 visible-ie9">Recaptcha</label>
                <div class="g-recaptcha" data-sitekey="6Lf-9DYUAAAAAKZ5r2MUCo7twMd5y_kuVDS3vb-g"><div style="width: 304px; height: 78px;"><div><iframe title="reCAPTCHA" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6Lf-9DYUAAAAAKZ5r2MUCo7twMd5y_kuVDS3vb-g&amp;co=aHR0cHM6Ly9wZWxpY29ycC5jb206NDQz&amp;hl=en&amp;v=YhkYx1k-yvvb8OonJPmOpoJY&amp;size=normal&amp;cb=iwgjj1i7da3w" width="304" height="78" role="presentation" name="a-nqw424a14q80" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div>
            </div>
            <div class="form-actions">
                <button type="button" id="register-back-btn" class="btn dark btn-outline">Back</button>
                <button type="submit" id="register-submit-btn" class="btn green uppercase btn-outline pull-right register" onclick="register();return false;">Submit</button>
            </div>
        </form>
        <!-- END REGISTRATION FORM -->
    </div>


    {{--<div class="login-box">
        <div class="login-logo">
            <a href="{{ $dashboard_url }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('adminlte::adminlte.login_message') }}</p>
                <form action="{{ $login_url }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ __('adminlte::adminlte.password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">{{ __('adminlte::adminlte.remember_me') }}</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                {{ __('adminlte::adminlte.sign_in') }}
                            </button>
                        </div>
<!--                        <div class="col-8">
                            <div class="icheck-primary">
                                @if (Route::has('password.request'))
                                    <a href="{{ $password_reset_url }}"><p>Forgot password?</p></a>
                                @endif
                            </div>
                        </div>-->
                    </div>
                </form>
                <p class="mt-2 mb-1"></p>
                @if ($register_url)
                    <p class="mb-0"></p>
                @endif
            </div>
        </div>
    </div>--}}
@stop
@section('ie_js')
    <script src="{{ asset('js/ie8.fix.min.js') }}"></script>
@stop
@section('page_plugin_js')
    <script src="{{ asset('js/jquery.backstretch.min.js') }}"></script>
@stop
@section('page_helper_js')
<script src="{{ asset('js/helper.js') }}" type="text/javascript"></script>
@stop
@section('adminlte_js')
    @stack('js')
    @yield('js')
    <script>
        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
            $('.forget').each(function () {
                $(this).removeClass('hide').addClass('show');
                $('.forget-form').trigger("reset");
                $('#alert').addClass('hide');
            });
        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });
        jQuery('#register-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
            $('.register').each(function () {
                $(this).removeClass('hide').addClass('show');
                $('.register-form').trigger("reset");
                $('#alert').addClass('hide');
            });
        });

        jQuery('#register-back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });

        // Login Function
        function login() {
            $.easyAjax({
                url: "{{ $login_url }}",
                type: "POST",
                data: $(".login-form").serialize(),
                container: ".login-form",
                messagePosition: "inline",
            });
        }

        // Forget Password Function
        function forget() {
            $.easyAjax({
                url: "{{ route('admin.password.email') }}",
                type: "POST",
                data: $(".forget-form").serialize(),
                container: ".forget-form",
                messagePosition: "inline",
                success: function (response) {
                    if (response.status == "success") {
                        $('.forget').each(function () {
                            $(this).removeClass('show').addClass('hide');
                        });

                    }
                }
            });
        }

        // Register Function
        function register() {
            $.easyAjax({
                url: "ajax/register.php",
                type: "POST",
                data: $(".register-form").serialize(),
                container: ".register-form",
                messagePosition: "inline",
                success: function (response) {
                    if (response.status == "success") {
                        $('.register').each(function () {
                            $(this).removeClass('show').addClass('hide');
                        });

                    }
                }
            });
        }
    </script>
@stop
