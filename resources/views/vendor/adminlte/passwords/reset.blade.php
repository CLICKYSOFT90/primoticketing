@extends('adminlte::master')

@section('adminlte_css')
    @yield('css')
@stop

@section('title', 'Login')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@stop

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', 'login')



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
        <!-- BEGIN RESET FORM -->
        <form class="reset-form" method="POST" autocomplete="off">
        {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">

            <!--        <h3 class="form-title font-green">Sign In</h3>-->
            <div id="error"></div>
            <div class="form-group form-md-line-input">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <input class="form-control" type="text" placeholder="Email" name="email" id="email">
                <span class="help-block help-block-error"> </span>
                <div class="form-control-focus"> </div>
            </div>
            <div class="form-group form-md-line-input">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control" type="password" placeholder="Password" name="password" id="password" >
                <span class="help-block help-block-error"> </span>
                <div class="form-control-focus"> </div>
            </div>
            <div class="form-group form-md-line-input">
                <label class="control-label visible-ie8 visible-ie9">Retype Password</label>
                <input class="form-control" type="password" placeholder="Retype Password" name="password_confirmation" id="password_confirmation">
                <span class="help-block help-block-error"> </span>
                <div class="form-control-focus"> </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn green uppercase btn-xs btn-outline" onclick="resetPassword();return false;">Reset Password</button>
                <span class="md-checkbox has-success logincheck">

            </span>
                <a href="{{route('admin.login')}}"  class="forget-password">Login</a>
            </div>

            <!--
                    <div class="create-account">
                        <p>
                            <a href="javascript:;" id="register-btn" class="uppercase">Create an account</a>
                        </p>
                    </div>
            -->
        </form>
        <!-- END RESET FORM -->
    </div>

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

        // Login Function
        function resetPassword() {
            $.easyAjax({
                url: "{{ route('admin.password.verify') }}",
                type: "POST",
                data: $(".reset-form").serialize(),
                container: ".reset-form",
                messagePosition: "inline",
            });
        }


    </script>
@stop
