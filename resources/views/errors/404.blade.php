 <p>&nbsp;&nbsp;&nbsp;</p>
 @extends('layouts.admin')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
@section('content')

      <div class="banner-page">
         <div class="content">
             <div class="banner-text">404 Error</div>
         </div>
     </div>

    <p>&nbsp;</p>
    <section class="four-not-four">
        <div class="container page-align-ceter">
            <p>Oops! Page Not Found</p>
            <h1>404</h1>
            <p> We Are Sorry, but the Page You Requested Was <br>Not Found</p>
            <div class="read-more-btn">
            <i class="fa fa-home" aria-hidden="true" style="color: #222; font-size: 20px;"></i>
        <a href="{{ url('/login') }}" onclick="window.history.back(-1);"
            style="font-size: 18px; color:blue;">{{ trans('global.back_home') }}</a>
            </div>
        </div>
    </section>


@endsection
