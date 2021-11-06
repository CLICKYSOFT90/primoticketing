@extends('adminlte::page')
@section('title', 'Parent Events')
@section('content_header')
@stop
@section('content')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-green">
                <i class="icon-user font-green"></i>
                <span class="caption-subject bold uppercase">@yield('title')</span>
            </div>
            <div class="actions">
                <div class="btn-group btn-group-devided">
                    @if(\Common::canCreate($module))
                        <a href="{{  route('eventManager.create') }}" class="btn green btn-outline">
                            Create Organization <i class="fa fa-plus"></i>
                        </a>
                    @endif
                    <a href="javascript:;" class="btn green btn-outline export_csv"> Export CSV <i
                                class="fa fa-file-excel-o"></i>
                    </a>

                </div>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed"
                   id="userTable" role="grid" aria-describedby="userTable_info" style="width: 100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Nested Events</th>
                    <th>Total Tickets Sold</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
            <!-- /.table-responsive -->
        </div>
        <!-- /.portlet -->
    </div>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-green">
                <i class="icon-user font-green"></i>
                <span class="caption-subject bold uppercase">UPCOMING EVENTS</span>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive dataTableChild no-footer dtr-inline collapsed"
                   id="userTables" role="grid" aria-describedby="userTable_info" style="width: 100%">
                <thead>
                <tr>
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Sub Event Title</th>
                    <th>Tickets Sold</th>
                    <th>Event Date</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
            <!-- /.table-responsive -->
        </div>
        <!-- /.portlet -->
    </div>
@stop

@section('css')
    <style>

         body .dt-button.buttons-csv { display: none}
        table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before{
            display: none;
        }
    </style>
@stop

@section('js')
    <script>

        $(function () {
            $('.export_csv').on('click', function(){
                $('body .buttons-csv').trigger('click');
            });
            var table = $('.dataTable').DataTable({
                serverSide: true,
                iDisplayLength: 100,
                aaSorting: [[0, "desc"]],
                ajax: {
                    url: "{{ route('eventManager.index') }}",
                },
                columns: [

                    {data: 'id'},
                    {data: 'name'},
                    {data: 'nested_events', searchable: false, sortable: false},
                    {data: 'total_tickets_sold', searchable: false, sortable: false},
                    {data: 'action', searchable: false, sortable: false},

                ],
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        footer: false,
                        exportOptions: {
                            columns: [0,1,2,3]
                        }

                    },

                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var row = $(nRow);
                    row.attr("id", 'user_' + aData['1']);

                }
            });

            var table2 = $('.dataTableChild').DataTable({
                serverSide: true,
                searching: false,
                iDisplayLength: 100,
                "bLengthChange": false,
                aaSorting: [[0, "desc"]],
                ajax: {
                    url: "{{ route('getChildEvent') }}",
                },
                columns: [

                    {data: 'id', searchable: false, sortable: false},
                    {data: 'parent_name', searchable: false, sortable: false},
                    {data: 'name', searchable: false, sortable: false},
                    {data: 'total_tickets_sold', searchable: false, sortable: false},
                    {data: 'event_start', searchable: false, sortable: false},
                    {data: 'action', searchable: false, sortable: false},

                ],

                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var row = $(nRow);
                    row.attr("id", 'user_' + aData['1']);

                }
            });

        });

    </script>
@section('plugins.Datatables', true)
@stop

