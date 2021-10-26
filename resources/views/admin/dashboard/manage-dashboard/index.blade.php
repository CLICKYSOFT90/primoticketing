@extends('adminlte::page')
@section('title', 'Dashboard')
@section('content_header')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 white" href="javascript:;">
                        <div class="visual">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup">472</span>
                            </div>
                            <div class="desc"> Online Organizations </div>
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
                                <span data-counter="counterup">1,838</span></div>
                            <div class="desc"> Active Events </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 white" href="javascript:;">
                        <div class="visual">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup">15,282</span>
                            </div>
                            <div class="desc">Tickets Sold Today </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered" style="padding-bottom: 3.5em;">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <span class="caption-subject font-green bold uppercase">Recent Organizations</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">

                        <table class="table table-striped table-bordered table-hover" id="userTable">
                            <thead>
                            <tr>
                                <th>Organization</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            <tbody><tr class="" id="row1">


                                <td>BCI Events</td>
                                <td>Matthew David Graff</td>
                                <td>mg@graffx.com</td>
                            </tr>

                            </tbody></table>

                    </div> <!-- /.table-responsive -->
                    <a href="#">
                                <span class="pull-right btn btn-circle green btn-outline">
                                View More...
                            </span>
                    </a>
                </div>

            </div>
        </div>
    </div>
@stop
@section('css')
@stop
@section('plugins.Chartjs', true)
@section('js')
@stop