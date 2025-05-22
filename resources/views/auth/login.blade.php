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

                                    <div class="field" style="position: relative;">
                                        <label class="label_field">{{ __('Password') }}</label>
                                        <input type="password" name="password" placeholder="Password"
                                            id="password-field" required autocomplete="current-password" />

                                        <!-- Eye Icon -->
                                       <span toggle="#password-field" class="fa fa-fw fa-eye toggle-password eye-icon"></span>


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
                                            {{ __('Remember Me') }}
                                        </label>

                                        @if (Route::has('password.request'))
                                            <a class="forgot" href="{{ route('password.request') }}">Forgotten Password?</a>
                                        @endif
                                    </div>

                                    <div class="field margin_0">
                                        <label class="label_field hidden">hidden label</label>
                                        <button class="main_bt">Sign In</button>
                                    </div>
                                    <p></p>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include Font Awesome if not already --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- Toggle Password Script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const togglePassword = document.querySelector(".toggle-password");
            const passwordField = document.querySelector("#password-field");

            togglePassword.addEventListener("click", function () {
                const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                passwordField.setAttribute("type", type);
                this.classList.toggle("fa-eye");
                this.classList.toggle("fa-eye-slash");
            });
        });
    </script>
@endsection
