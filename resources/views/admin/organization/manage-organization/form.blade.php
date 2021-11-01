@extends('adminlte::page')
@section('title', (($model->exists)?'Edit ':'New ').'Organization')
@section('content_header')

@stop

@section('content')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-green">
                <i class="icon-user font-green"></i>
                <span class="caption-subject bold uppercase">{{$model->exists ? "Update" :"Create"}} Organization</span>
            </div>
        </div>
        <div class="portlet-body">
            <form class="scannerlogin" action="{{ route('organization.store') }}" method="POST" autocomplete="off">
        <div class="row">
            @csrf
            @if($model->exists)
                <input type="hidden" name="id" id="id" value="{{ $model->id }}">
            @endif
            <div class="col-md-6">
                <div class="formbox">
                    <strong>Primo Agent Information</strong>
                    <div class="form-group form-md-line-input">
                        <label class="control-label visible-ie8 visible-ie9">Name</label>
                        <input class="form-control" type="text" placeholder="Name" name="agent_name" value="{{ old('agent_name',$model->agent_name)}}">
                        <span class="help-block help-block-error">Primo Agent Name</span>
                        <div class="form-control-focus"> </div>

                    </div>
                    <div class="form-group form-md-line-input">
                        <label class="control-label visible-ie8 visible-ie9">Phone Number</label>
                        <input class="form-control" type="text" placeholder="Phone" name="agent_phone_number" value="{{ old('agent_phone_number',$model->agent_phone_number)}}">
                        <span class="help-block help-block-error">Primo Agent Phone Number</span>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="formbox">
                    <strong>Organization Information</strong>
                    <div class="form-group form-md-line-input">
                        <label class="control-label visible-ie8 visible-ie9">Contact Name</label>
                        <input class="form-control" type="text" placeholder="Contact Name" name="organization_contact_name" value="{{ old('organization_contact_name',$model->organization_contact_name)}}">
                        <span class="help-block help-block-error">Organization Contact Name</span>
                        <div class="form-control-focus"> </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label class="control-label visible-ie8 visible-ie9">Contact Phone Number</label>
                        <input class="form-control" type="text" placeholder="Contact Phone" name="organization_contact_phone_number" value="{{ old('organization_contact_phone_number',$model->organization_contact_phone_number)}}">
                        <span class="help-block help-block-error">Organization Contact Phone Number</span>
                        <div class="form-control-focus"> </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label class="control-label visible-ie8 visible-ie9">Contact Email Address</label>
                        <input class="form-control" type="text" placeholder="Contact Email" name="email" value="{{ old('email',$model->email)}}">
                        <span class="help-block help-block-error">Organization Contact Email Address</span>
                        <div class="form-control-focus"> </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label class="control-label visible-ie8 visible-ie9">Name</label>
                        <input class="form-control" type="text" placeholder="Name" name="organization_name" value="{{ old('organization_name',$model->organization_name)}}">
                        <span class="help-block help-block-error">Organization Name</span>
                        <div class="form-control-focus"> </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label class="control-label visible-ie8 visible-ie9">Icon Name</label>
                        <input class="form-control" type="text" placeholder="Icon Name" name="organization_icon" value="{{ old('organization_icon',$model->organization_icon)}}">
                        <span class="help-block help-block-error">Organization Icon / Mascot</span>
                        <div class="form-control-focus"> </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label class="control-label visible-ie8 visible-ie9">Website URL</label>
                        <input class="form-control" type="text" placeholder="Website URL" name="organization_website" value="{{ old('organization_website',$model->organization_website)}}">
                        <span class="help-block help-block-error">Organization Website</span>
                        <div class="form-control-focus"> </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label class="control-label visible-ie8 visible-ie9">Status</label>
                        <select class="form-control" name="status">
                            <option value="">Select Status</option>
                            <option value="1" {{  old('active',$model->active == "1") ? 'selected' : '' }}>Active</option>
                            <option value="0" {{  old('active',($model->exists && $model->active === "0") ? 'selected' : '') }}>InActive</option>
                        </select>
                        <span class="help-block help-block-error">Organization Status</span>
                        <div class="form-control-focus"> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="pbut btn green uppercase btn-outline">{{$model->exists ? "Update" :"Create"}} Organization</button>
        </div>
    </form>
        </div>
    </div>
@stop

@section('css')
@stop
@section('plugins.Select2', true)
@section('js')
@stop
