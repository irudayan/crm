@extends('layouts.admin')
@section('title', __('cruds.role.title_singular'))
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
                    <h5> {{ trans('global.show') }} {{ trans('cruds.role.title') }}
                    </h5>
                </div>
                <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12 text-right">
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn  btn-sm btn-dark" href="{{ route('admin.roles.index') }}" style="float:right;"
                                title="{{ trans('global.back') }}">
                                <i class="fa fa-backward" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="form-group">
                {{-- <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div> --}}
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.id') }}
                            </th>
                            <td>
                                {{ $role->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.title') }}
                            </th>
                            <td>
                                {{ $role->title }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.role.fields.permissions') }}
                            </th>
                            <td>
                                @foreach ($role->permissions as $key => $permissions)
                                    <span class="label label-info">{{ $permissions->title }}</span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
