@extends('adminlte::page')
@section('title', 'Roles')
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
                        <a href="{{  route('roles.create') }}" class="btn green btn-outline">
                            Create Role <i class="fa fa-plus"></i>
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
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Created</th>
                    <th>Action</th>
                    <th>Modified</th>
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
                ajax: "{{ route('roles.index') }}",
                columns: [
                    {data: 'id'},
                    {data: 'roleName'},
                    {data: 'created_at'},
                    {data: 'action', searchable: false, sortable: false},
                    {data: 'updated_at'},
                ]
            });
        });
    </script>
@stop

@section('plugins.Datatables', true)