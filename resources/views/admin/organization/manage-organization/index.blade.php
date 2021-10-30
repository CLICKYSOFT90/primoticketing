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
                    <a href="javascript:;" class="btn green btn-outline export_csv"> Export CSV <i
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
                    <th>ID</th>
                    <th>Organization</th>
                    <th>Contact Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Action</th>
                    <th>Status</th>

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
                    url: "{{ route('organization.index') }}",
                },
                columns: [

                    {data: 'id'},
                    {data: 'organization_name'},
                    {data: 'organization_contact_name'},
                    {data: 'organization_contact_phone_number'},
                    {data: 'email'},
                    {data: 'action', searchable: false, sortable: false},
                    {data: 'active'},

                ],
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'csv',
                        footer: false,
                        exportOptions: {
                            columns: [0,1,2,3,4,6]
                        }

                    },

                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                    var row = $(nRow);
                    row.attr("id", 'user_' + aData['7']);
                    var userID = aData['0'];

                   // var userImage = aData['2'];

//            if(userImage == null) {
//                userImage = '../images/avatar/no-image.png'
//            } else {
//                userImage = '../images/avatar/' + userImage;
//            }
//
//            $(row.find("td")['2']).html(
//                '<img style="width:9em ;height:8em;" src="' + userImage + '"/>'
//            );
                }
            });

        });

    </script>
@section('plugins.Datatables', true)
@stop

