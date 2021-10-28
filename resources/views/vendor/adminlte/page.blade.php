@if(@$printMode == 1)

    @section('adminlte_css')
        @stack('css')
        @yield('css')
        <style type="text/css">
            .card-header{
              display: none !important;
            }
            .card-body {
                padding: 0 !important;
            }
            .card{
              background: white !important;
              box-shadow: none;
            }

            thead { display: table-header-group !important; }
            tfoot { display: table-row-group !important; }
            table, tr, td, th, tbody, thead, tfoot, td div {
                page-break-inside: avoid !important;
            }
            .table-responsive { overflow-x: visible !important; }
        </style>
    @stop

    @yield('content')

@else

@extends('adminlte::master')

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body','page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md')


@section('body_data',
(config('adminlte.sidebar_scrollbar_theme', 'os-theme-light') != 'os-theme-light' ? 'data-scrollbar-theme=' . config('adminlte.sidebar_scrollbar_theme')  : '') . ' ' . (config('adminlte.sidebar_scrollbar_auto_hide', 'l') != 'l' ? 'data-scrollbar-auto-hide=' . config('adminlte.sidebar_scrollbar_auto_hide')   : ''))

@php( $logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout') )
@php( $profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $logout_url = $logout_url ? route($logout_url) : '' )
    @php( $profile_url = $profile_url ? route($profile_url) : '' )
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $logout_url = $logout_url ? url($logout_url) : '' )
    @php( $profile_url = $profile_url ? url($profile_url) : '' )
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <img class="alogo" src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png'))}}">
                <div class="menu-toggler sidebar-toggler">
                    <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
            <!-- END RESPONSIVE MENU TOGGLER -->

            <!-- BEGIN PAGE TOP -->
            <div class="page-top">
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="separator hide"> </li>
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user dropdown-dark">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                                <span class="username username-show-on-mobile"> {{ Auth::user()->name }}  </span>
                                <i class="fa fa-angle-down"></i>
                                <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="https://pelicorp.com/primo/user/user_profile.php">
                                        <i class="icon-user"></i> My Profile </a>
                                </li>
                                <li class="divider"> </li>

                                <li>
                                    <form id="logout-form" action="{{ $logout_url }}" method="POST"
                                          style="display: none;">
                                        @if(config('adminlte.logout_method'))
                                            {{ method_field(config('adminlte.logout_method')) }}
                                        @endif
                                        {{ csrf_field() }}
                                    </form>
                                    <a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon-key"></i> Log Out </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END PAGE TOP -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"></div>
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>

                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->

            {{--@if(!config('adminlte.layout_topnav') && !View::getSection('layout_topnav'))
                <aside class="main-sidebar {{config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4')}}">
                    @if(config('adminlte.logo_img_xl'))
                        <a href="{{ $dashboard_url }}" class="brand-link text-center logo-switch">
                            <img
                                src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
                                alt="{{config('adminlte.logo_img_alt', 'AdminLTE')}}"
                                class="{{config('adminlte.logo_img_class', 'brand-image-xl')}} logo-xs">
                            <img src="{{ asset(config('adminlte.logo_img_xl')) }}"
                                 alt="{{config('adminlte.logo_img_alt', 'AdminLTE')}}"
                                 class="{{config('adminlte.logo_img_xl_class', 'brand-image-xs')}} logo-xl">
                        </a>
                    @else
                        <a href="{{ $dashboard_url }}" class="brand-link text-center {{ config('adminlte.classes_brand') }}">
                            <img
                                src="{{ asset(config('adminlte.logo_img', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
                                alt="{{config('adminlte.logo_img_alt', 'AdminLTE')}}"
                                class="{{ config('adminlte.logo_img_class', 'brand-image img-circle elevation-3') }}"
                                style="opacity: .8">
                            <span class="brand-text font-weight-light {{ config('adminlte.classes_brand_text') }}">
                        {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                    </span>
                        </a>
                    @endif
                    <div class="sidebar">
                        <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                            <div class="info">
                              <a href="#" class="d-block"><i class="fa fa-circle text-success"></i> {{ !empty(auth()->user()->name) ?  auth()->user()->name : "" }} </a>
                            </div>
                        </div> -->

                        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                            <div class="form-inline">
                                <div class="input-group" data-widget="sidebar-search">
                                  <input class="form-control form-control-sidebar" placeholder="Search" aria-label="Search" id="search-menu-term">
                                  <div class="input-group-append">
                                    <button class="btn btn-sidebar">
                                      <i class="fas fa-search fa-fw"></i>
                                    </button>
                                  </div>
                                </div>
                            </div>
                        </div>

                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column {{config('adminlte.classes_sidebar_nav', '')}}"
                                data-widget="treeview" role="menu" id="menu-tree"
                                @if(config('adminlte.sidebar_nav_animation_speed') != 300) data-animation-speed="{{config('adminlte.sidebar_nav_animation_speed')}}"
                                @endif @if(!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
                                @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                            </ul>
                        </nav>
                    </div>
                </aside>
            @endif
--}}
            <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="">
                            @if(!empty($errors) && count(@$errors) > 0 )
                                <div class="alert alert-danger alert-dismissible show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <ul class="p-0 m-0" style="list-style: none;">
                                        @foreach($errors->all() as $error)
                                            <li><strong>Error: </strong> {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        ×
                                    </button>
                                    <strong>Error: </strong> {!!  session('error') !!}
                                </div>
                            @endif
                            @if (session('warning'))
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        ×
                                    </button>
                                    <strong>Warning: </strong> {!! session('warning') !!}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                        ×
                                    </button>
                                    <strong>Success: </strong> {!! session('success') !!}
                                </div>
                            @endif
                            @yield('content_header')
                        </div>
                        @yield('content')
                    </div>
            </div>
            <!--End page-container-->
            <div class="page-footer">
                <div class="page-footer-inner"> 2021© Build in partnership with Primo Ticketing and BCI Media</div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>


@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
@endif
