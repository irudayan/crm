@extends('layouts.admin')
@section('title', __('cruds.permission.title_singular'))
@section('content')
    <p>&nbsp;</p>
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
                    <h5> {{ trans('global.create') }} {{ trans('cruds.permission.title_singular') }}
                    </h5>
                </div>
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-right">
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn  btn-sm btn-dark" href="{{ route('admin.permissions.index') }}" style="float:right;"
                                title="{{ trans('global.back') }}">
                                <i class="fa fa-backward" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.permissions.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.permission.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text"
                        name="title" id="title" value="{{ old('title', '') }}" required>
                    @if ($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.permission.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button> &nbsp;
                    <a class="btn btn-light" title="{{ trans('global.cancel') }}"
                        href="{{ route('admin.permissions.index') }}">
                        {{ trans('global.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
