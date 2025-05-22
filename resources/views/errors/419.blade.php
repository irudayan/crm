@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
@section('content')

    <p>&nbsp;</p>
    <div style="text-align:center;">
        <br>
        <i class="fa fa-home" aria-hidden="true"></i>
        <a href="#" onclick="window.history.back(-1);"
            style="font-size: 18px; color:blue;">{{ trans('global.back_home') }}</a>

    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <p>&nbsp;</p>
@endsection
