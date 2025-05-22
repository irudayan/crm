@extends('layouts.app')

@section('content')
    <div class="inner_page login">
        <div class="full_container">
            <div class="container">
                <div class="center verticle_center full_height">
                    <div class="login_section">
                        <div class="logo_login">
                            <div class="center">
                                <img width="210" src="{{ asset('backend/images/logo/logo.png') }}" alt="#" />
                            </div>
                        </div>
                        <div class="login_form">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <fieldset>
                                    <div class="field">
                                        <label class="label_field">{{ __('Email Address') }}</label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            autocomplete="email" autofocus placeholder="E-mail" />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="field">
                                        <label class="label_field">{{ __('Password') }}</label>
                                        <input type="password" name="password" placeholder="Password" name="password"
                                            required autocomplete="current-password" />
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                    <div class="field">
                                        <label class="label_field hidden">hidden label</label>
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            {{ __('Remember Me') }}</label>


                                        @if (Route::has('password.request'))
                                            <a class="forgot" href="{{ route('password.request') }}">Forgotten Password?</a>
                                        @endif

                                        {{-- <a class="forgot" href="">Forgotten Password?</a> --}}
                                    </div>
                                    <div class="field margin_0">
                                        <label class="label_field hidden">hidden label</label>
                                        <button class="main_bt">Sign In</button>

                                        {{-- <a class="btn btn-link "href="{{ url('/') }}" title="Go to Home Page"> <i
                                                class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go to Home
                                            Page</a> --}}

                                    </div>
                                    <p></p>

                                    {{--
                                    <div class="field margin_0">
                                        <a class="btn btn-link px-0" href="{{ url('/') }}" title="Go to Home Page">
                                            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Go to Home Page
                                        </a>
                                    </div> --}}
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
