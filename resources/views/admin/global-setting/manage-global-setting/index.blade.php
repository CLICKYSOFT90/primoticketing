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
            <form method="post" action="#">
                <input type="submit" class="btn blue btn-outline right save_btn" value="Save"><br>
                <h4 class="font-green bold uppercase">Event Types</h4>
                <table class="table table-striped table-bordered table-hover dt-responsive" id="eventTable">
                    <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody><tr class="repeatingEventType">
                        <td><input name="event-name" value="Soccer"></td>
                        <td><a href="#">DELETE</a></td>
                    </tr>
                    <tr class="repeatingEventType">
                        <td><input name="event-name" value="Baseball"></td>
                        <td><a href="#">DELETE</a></td>
                    </tr>
                    </tbody></table>
                <a class="btn green btn-outline right addEventType" href="#">+ Add Event Type</a>

                <div class="clearfix"></div>

                <h4 class="font-green bold uppercase">Ticket Types <span>Please save all Event Types first.</span></h4>
                <table class="table table-striped table-bordered table-hover dt-responsive" id="eventTable">
                    <thead>
                    <tr>
                        <th>Ticket Name</th>
                        <th>Ticket Type</th>
                        <th>Event Type</th>
                        <th>Default Price</th>
                        <th>Default Limit</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody><tr class="repeatingTicketType">
                        <td><input name="ticket-name" value="General Admission"></td>
                        <td><select name="ticket-type"><option value="single">Single Event</option><option value="season">Season Ticket </option></select></td>
                        <td><select name="event-type"><option value="any">Any</option><option value="single">Soccer</option><option value="season">Baseball</option></select></td>
                        <td><input name="default-price" value="25"></td>
                        <td><input name="default-limit" value="150"></td>
                        <td><a href="#">DELETE</a></td>
                    </tr>
                    </tbody></table>
                <a class="btn green btn-outline right addTicketType" href="#">+ Add Ticket Type</a>
                <div class="clearfix"></div>

                <h4 class="font-green bold uppercase">Special Walk-up Types <span>Visible on the scanner app and used for special walk-ups</span></h4>
                <table class="table table-striped table-bordered table-hover dt-responsive" id="eventTable">
                    <thead>
                    <tr>
                        <th>Walk-up Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody><tr class="repeatingWalkUp">
                        <td><input name="walkup-name" value="Player Ticket"></td>
                        <td><a href="#">DELETE</a></td>
                    </tr>
                    <tr class="repeatingWalkUp">
                        <td><input name="walkup-name" value="Complimentary Ticket"></td>
                        <td><a href="#">DELETE</a></td>
                    </tr>
                    <tr class="repeatingWalkUp">
                        <td><input name="walkup-name" value="Booster Ticket"></td>
                        <td><a href="#">DELETE</a></td>
                    </tr>
                    </tbody></table>
                <a class="btn green btn-outline right addWalkUp" href="#">+ Add Walk-Up Type</a>
                <div class="clearfix"></div>

            </form>
        </div>
        <!-- /.portlet -->
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>

    </script>
@section('plugins.Datatables', true)
@stop

