@extends('adminlte::page')
@section('title', 'Organizations')
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
                        <a href="{{  route('organization.create') }}" class="btn green btn-outline">
                            Create Organization <i class="fa fa-plus"></i>
                        </a>
                    @endif
                    <a href="#" class="btn green btn-outline"> Export CSV <i
                                class="fa fa-file-excel-o"></i>
                    </a>

                </div>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed"
                   id="userTable" role="grid" aria-describedby="userTable_info" style="width: 1186px;">
                <thead>
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Organization</th>
                    <th>Contact Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
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
        .details-control{
            font-weight: bold; text-align: center; cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script>
        function format ( d ) {
            // `d` is the original data object for the row
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr class="child">' +
                '<td class="child" >' +
                '<ul data-dtr-index="0">' +
                '<li data-dtr-index="5" data-dt-row="0" data-dt-column="5">' +
                '<span class="dtr-title">Status</span> ' +
                '<span class="dtr-data">' +
                 d.active +
                '</span>' +
                '</li>' +
                '</ul>' +
                '</td>' +
                '</tr>'+
                '</table>';
        }
        $(function () {
            var table = $('.dataTable').DataTable({
                serverSide: true,
                iDisplayLength: 100,
                aaSorting: [[1, "desc"]],
                ajax: {
                    url: "{{ route('organization.index') }}",
                },
                columns: [
                    {
                        "className":    'details-control',
                        "orderable":      false,
                        "data":           "",
                        "defaultContent": '+'
                    },
                    {data: 'id'},
                    {data: 'organization_name'},
                    {data: 'organization_contact_name'},
                    {data: 'organization_contact_phone_number'},
                    {data: 'email'},
                    {data: 'action', searchable: false, sortable: false},
                ]
            });
            $('body .dataTable tbody').on('click', '.details-control', function () {

                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            });
        });

    </script>
@section('plugins.Datatables', true)
@stop

