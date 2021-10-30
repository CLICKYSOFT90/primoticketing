@extends('adminlte::page')
@section('title', 'Users')
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
                        <a href="{{  route('users.create') }}" class="btn green btn-outline">
                            Create User <i class="fa fa-plus"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <table class="table table-striped table-bordered table-hover dt-responsive dataTable no-footer dtr-inline collapsed"
                   id="userTable" role="grid" aria-describedby="userTable_info" style="width: 1186px;">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Organization</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Created</th>


                </tr>
                </thead>
            </table>
            <!-- /.table-responsive -->
        </div>
        <!-- /.portlet -->
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(function () {
            $('.dataTable').DataTable({
                serverSide: true,
                iDisplayLength: 100,
                aaSorting: [[0, "desc"]],
                ajax: "{{ route('users.index') }}",
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'username'},
                    {data: 'email'},
                    {data: 'organization_name',name:'organization.organization_name'},
                    {data: 'active'},
                    {
                        data: 'action', searchable: false, sortable: false
                    },
                    {data: 'created_at'},


                ]
            });
        });
    </script>
@stop

@section('plugins.Datatables', true)