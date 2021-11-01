@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 white" href="javascript:;">
                <div class="visual">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup">16,221</span></div>
                    <div class="desc"> Total Tickets Sold </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 white" href="javascript:;">
                <div class="visual">
                    <i class="far fa-calendar-alt"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup">18</span>
                    </div>
                    <div class="desc"> Active Events </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 white" href="javascript:;">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup">3,749</span>
                    </div>
                    <div class="desc"> Total Orders </div>
                </div>
            </a>
        </div>
    </div>

    <div class="portlet light bordered">
        <div class="portlet-body">
            <div class="note note-success">
                <p> Welcome  <strong>{{$userData['name']}}</strong> to the Dashboard</p>
            </div>
        </div>

    </div>
@stop
@section('css')
@stop
{{--@section('plugins.Chartjs', true)--}}
@section('js')
@stop