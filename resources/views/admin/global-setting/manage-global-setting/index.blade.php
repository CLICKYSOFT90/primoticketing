@extends('adminlte::page')
@section('title', 'Global Setting')
@section('content_header')
@stop
@section('content')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-green">
                <i class="far fa-sliders-h font-green" style="font-weight: 900"></i>
                <span class="caption-subject bold uppercase">Global Settings</span>
            </div>
        </div>
        <div class="portlet-body">
                <br>
                @include('admin.global-setting.manage-global-setting._partials.event-types')
                <div class="clearfix"></div>
                @include('admin.global-setting.manage-global-setting._partials.ticket-types')
                <div class="clearfix"></div>
                @include('admin.global-setting.manage-global-setting._partials.special-walk-up-types')
                <div class="clearfix"></div>
        </div>
        <!-- /.portlet -->
    </div>
@stop

@section('css')

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

@section('plugins.Datatables', true)

