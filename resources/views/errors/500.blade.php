@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))
@section('content')

    <p>&nbsp;</p>
    <div style="text-align:center;">
         <i class="fa fa-home" aria-hidden="true"></i>
            <a href="#" onclick="window.history.back(-1);"
                style="font-size: 18px; color:blue;">{{ trans('global.back_home') }}</a>
    </div>
    <p>&nbsp;</p>

@endsection
