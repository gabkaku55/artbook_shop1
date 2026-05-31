@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <a class="auth-close" href="{{ url('/') }}" aria-label="{{ __('messages.auth_close') }}">×</a>
        <h1 class="auth-title">{{ __('messages.auth_title_login') }}</h1>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="field">
                <label for="login-email" class="visually-hidden">{{ __('messages.auth_email') }}</label>
                <div class="input-wrap">
                    <input type="email" id="login-email" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.auth_email') }}" autofocus required class="@error('email') auth-input-error @enderror">
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-envelope"></i></span>
                </div>
                @error('email') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="field">
                <label for="login-password" class="visually-hidden">{{ __('messages.auth_password') }}</label>
                <div class="input-wrap">
                    <input type="password" id="login-password" name="password" placeholder="{{ __('messages.auth_password') }}" required class="@error('password') auth-input-error @enderror">
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-lock"></i></span>
                </div>
                @error('password') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="auth-row">
                <label class="remember">
                    <input type="checkbox" name="remember" value="1">
                    {{ __('messages.auth_remember') }}
                </label>
                <a class="forgot" href="{{ route('password.request') }}">{{ __('messages.auth_forgot') }}</a>
            </div>

            <button class="auth-btn" type="submit">{{ __('messages.auth_submit_login') }}</button>
        </form>

        <p class="auth-footer">
            {{ __('messages.auth_no_account') }}
            <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
        </p>
    </div>
</div>
@endsection
