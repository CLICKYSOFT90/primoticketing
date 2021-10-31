@extends('adminlte::page')
@section('title', (($model->exists)?'Edit':'New').' Role '.(($model->exists)?'#'.$model->id:''))
@section('content_header')
@stop
@section('content')
  <div class="portlet light bordered">
    <div class="portlet-title">
      <div class="caption font-green">
        <i class="icon-user font-green"></i>
        <span class="caption-subject bold uppercase">{{$model->exists ? "Update" :"Create"}} Role</span>
      </div>
    </div>
    <div class="portlet-body">
      <form method="post" class="form"
            enctype="multipart/form-data"
            action="{{ ($model->exists)? route('roles.update', [$model->id]): route('roles.store') }}">
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
                <label class="control-label visible-ie8 visible-ie9">Role Name</label>
                <input class="form-control" type="text" placeholder="Role Name" name="roleName" value="{{ old('roleName',$model->roleName)}}">
                <span class="help-block help-block-error">Role Name</span>
                <div class="form-control-focus"> </div>
              </div>
              <div class="form-group form-md-line-input col-md-6">
                <label class="control-label visible-ie8 visible-ie9">Role Type</label>
                @if($model->exists)
                  <input class="form-control" disabled="" type="text" placeholder="Role Type"value="{{ old('roleType',$model->roleType)}}">
                  <input type="hidden" id="users_roleType"  name="roleType" value="{{ old('roleType',$model->roleType)}}">
                @else
                <select id="users_roleType" name="roleType"
                        class="form-control" style="width: 100%">
                  @foreach(['Organization', 'Other'] as  $title)
                    <option value="{{$title}}" {{ (old('roleType') == $title) ? 'selected=""':'' }} {{ ($model->roleType == $title) ? 'selected=""':''}} >
                      {{ str_replace('_',' ',$title) }}</option>
                  @endForeach
                </select>
                @endif
                <span class="help-block help-block-error">Role Type</span>
                <div class="form-control-focus"> </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-center">
                <h3>Permissions</h3>
              </div>
              <div class="col-md-12">
                <table class="table table-striped table-bordered table-hover dt-responsive dataTable role-table collapsed">
                  <thead>
                  <tr>
                    <th>&nbsp;</th>
                    <th>
                      <input type="checkbox" id="check-all"/>
                    </th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach(config('permissions') as $permission)
                    @if($permission['show']==false)
                      @continue
                    @endif
                    <?php

                    $checked =false;
                    if(!empty($model->permissions)){
                      $permissions = json_decode($model->permissions);
                      if (in_array(strtolower($permission['module'].$permission['key']), $permissions)) {
                        $checked = true;
                      }else{
                        $checked = false;
                      }
                    }
                    ?>
                    @if($permission['module'] != @$prevModule)
                      <tr data-organization="{{$permission['organization']}}" data-other="{{$permission['other']}}">
                        <th class="text-left">
                          <h2><strong>{{ ucwords($permission['module']) }}</strong></h2>
                        </th>
                        <th>
                          <input type="checkbox" value="<?php echo $permission['module']; ?>"
                                 onclick="moduleCheck(this);"/>
                        </th>
                      </tr>
                    @endif
                    <tr data-organization="{{$permission['organization']}}" data-other="{{$permission['other']}}">
                      <td>{{ $permission['name'] }}</td>
                      <td>
                        <input type="checkbox" class="check-single check-single-<?php echo $permission['module']; ?>" name="permissions[]" value="{{ strtolower($permission['module'].$permission['key']) }}" <?php if($checked){ echo 'checked'; }else{ echo ''; } ?> />
                      </td>
                    </tr>
                    @php
                      $prevModule = $permission['module'];
                    @endphp
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="pbut btn green uppercase btn-outline">{{$model->exists ? "Update" :"Create"}} Role</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('css')
@stop
@section('js')
<script type="text/javascript">
  function moduleCheck(obj){
    var moduleName = $(obj).val();
    $('.check-single-'+moduleName).each(function(){
        if ($(obj).is(':checked')){
            $(this).prop('checked', true);
        }else{
            $(this).prop('checked', false);
        }
    });
  }
  function showPermissionItemByRoleType(){
    var role_type = $("#users_roleType").val();
    $(".role-table").find("tr").hide();
    if(role_type=="Organization"){

      $(".role-table").find("[data-organization='1']").show();
    }else{
      $(".role-table").find("[data-other='1']").show();

    }
  }
  $(window).on('load', function() {
    showPermissionItemByRoleType();
  });
  $('#users_roleType').change(function(){
    showPermissionItemByRoleType();
  });
</script>
@stop
