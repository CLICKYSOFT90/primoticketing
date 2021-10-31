@extends('adminlte::page')
@section('title', (($model->exists)?'Edit':'New').' User '.(($model->exists)?'#'.$model->id:''))
@section('content_header')
@stop
@section('content')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-green">
                <i class="icon-user font-green"></i>
                <span class="caption-subject bold uppercase">{{$model->exists ? "Update" :"Create"}} User</span>
            </div>
        </div>
        <div class="portlet-body">
            <form method="post" class="form"
                  enctype="multipart/form-data"
                  action="{{ ($model->exists)? route('users.update', [$model->id]): route('users.store') }}">
                <input type="hidden" name="userType" value="Admin">
                @if ($model->exists)
                    @method('PUT')
                @endif
                @csrf
                <div class="row">
                    @csrf
                    @if($model->exists)
                        <input type="hidden" name="id" id="id" value="{{ $model->id }}">
                    @endif
                    <div class="col-md-12">
                        <div class="formbox row">
                            <div class="form-group form-md-line-input col-md-6">
                                <label class="control-label visible-ie8 visible-ie9">Full Name</label>
                                <input class="form-control" type="text" placeholder="Name" name="name" value="{{ old('name',$model->name)}}">
                                <span class="help-block help-block-error">Full Name</span>
                                <div class="form-control-focus"> </div>
                            </div>
                            <div class="form-group form-md-line-input col-md-6">
                                <label class="control-label visible-ie8 visible-ie9">Email</label>
                                <input class="form-control" id="user_email" type="text" placeholder="Email" name="email" value="{{ old('email',$model->email)}}">
                                <span class="help-block help-block-error">Email</span>
                                <div class="form-control-focus"> </div>
                            </div>
                            <div class="form-group form-md-line-input col-md-6">
                                <label class="control-label visible-ie8 visible-ie9">Username</label>
                                <input class="form-control" type="text" placeholder="Username" name="username" value="{{ old('username',$model->username)}}">
                                <span class="help-block help-block-error">Username</span>
                                <div class="form-control-focus"> </div>
                            </div>
                            <div class="form-group form-md-line-input col-md-6">
                                <label class="control-label visible-ie8 visible-ie9">Password</label>
                                <input class="form-control" type="text" placeholder="Password" name="password" value="{{ old('password',$model->password)}}">
                                <span class="help-block help-block-error">Password</span>
                                <div class="form-control-focus"> </div>
                            </div>
                            <div class="form-group form-md-line-input col-md-6">
                                <label class="control-label visible-ie8 visible-ie9">Contact Number</label>
                                <input class="form-control" type="text" placeholder="Contact Number" name="contactNumber" value="{{ old('contactNumber',$model->contactNumber)}}">
                                <span class="help-block help-block-error">Contact Number</span>
                                <div class="form-control-focus"> </div>
                            </div>
                            <div class="form-group form-md-line-input col-md-6">
                                <label class="control-label visible-ie8 visible-ie9">Status</label>
                                <select class="form-control" name="active">
                                    <option value="">Select Status</option>
                                    <option value="1" {{  old('active',$model->active == "1") ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{  old('active',($model->exists && $model->active === "0") ? 'selected' : '') }}>InActive</option>
                                </select>
                                <span class="help-block help-block-error">Status</span>
                                <div class="form-control-focus"> </div>
                            </div>
                            <div class="form-group form-md-line-input col-md-6">
                                <label class="control-label visible-ie8 visible-ie9">Alpha Role</label>
                                <select id="users_alphaRole" name="alphaRole"
                                        class="form-control select2" style="width: 100%">
                                    <option value="">Select Alpha Role</option>
                                    @foreach(['SUPER', 'USERS'] as  $title)
                                        <option value="{{$title}}" {{ (old('alphaRole') == $title) ? 'selected=""':'' }} {{ ($model->alphaRole == $title) ? 'selected=""':''}} >
                                            {{ str_replace('_',' ',$title) }}</option>
                                    @endForeach
                                </select>
                                <span class="help-block help-block-error">Alpha Role</span>
                                <div class="form-control-focus"> </div>
                            </div>
                            <div class="form-group form-md-line-input col-md-6 req-by-user" id="selected_rold">
                                <label class="control-label visible-ie8 visible-ie9">Role</label>
                                <select id="role_id" name="role_id[]" class="form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }} select2"  style="width: 100%;">
                                    <option value="">Select Role</option>
                                    @foreach($roles as  $role)
                                        <option data-role-type="{{$role->roleType}}" value="{{$role->id}}" {{ (old('role_id') == null) ? '' : (in_array($role->id, old('role_id')) ? "selected" : "") }} {{in_array($role->id,$assigned_role_array) ? "selected" : "" }}>{{ $role->roleName." - ".$role->roleType }}</option>
                                    @endForeach
                                </select>
                                <span class="help-block help-block-error">Role</span>
                                <div class="form-control-focus"> </div>
                            </div>

                            <div class="form-group form-md-line-input req-by-user col-md-6" id="organization">
                                <label class="control-label visible-ie8 visible-ie9">Organization</label>
                                <select id="organizationId" name="organizationId" class="form-control select2-ajax" style="width: 100%;" data-select2-source="organization" data-select2-value="{{ old('organizationId',$model->organizationId) }}">
                                </select>
                                <span class="help-block help-block-error">Organization</span>
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="pbut btn green uppercase btn-outline">{{$model->exists ? "Update" :"Create"}} User</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('css')
    <style>
        .select2-container--default .select2-selection--single{
            background-color: transparent;
            border: 0;
            border-bottom: 1px solid #aaa;
        }
    </style>
@stop
@section('plugins.Select2', true)
@section('js')
<script>

    $('document').ready(function () {
        $("#role_id").change(function () {
            var option = $('option:selected', this).attr('data-role-type');
            if(option)
            {
                if (option=="Organization") {
                    $('#organization').show();
                }else{
                    $('#organization').hide();
                }
            }

        });

        $(window).on('load', function() {
            var option = $('#role_id').find(":selected").attr('data-role-type');
            $('#organization').hide();

            if(option)
            {
                if (option=="Organization") {
                    $('#organization').show();
                }
            }
        });
    });
    $('#users_alphaRole').change(function(){
        if($(this).val() == "SUPER"){
            $('.req-by-user').addClass('hidden');
            emptyUserField();
        }else{
            $('.req-by-user').removeClass('hidden');
        }
    });

    if($('#users_alphaRole').val() == "USERS"){
        $('.req-by-user').removeClass("hidden");
    }else{
        $('.req-by-user').addClass("hidden");
        emptyUserField();
    }

    function emptyUserField(){
        $('#role_id').val('').trigger('change');
        $('#organizationId').val('').trigger('change');
    }
</script>
@stop
