@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <a class="auth-close" href="{{ url('/') }}" aria-label="{{ __('messages.auth_close') }}">×</a>
        <h1 class="auth-title">{{ __('messages.auth_forgot_title') }}</h1>

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="field">
                <label for="forgot-email" class="visually-hidden">{{ __('messages.auth_email') }}</label>
                <div class="input-wrap">
                    <input type="email" id="forgot-email" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.auth_email') }}" required autofocus class="@error('email') auth-input-error @enderror">
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-envelope"></i></span>
                </div>
                @error('email') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <button class="auth-btn" type="submit">{{ __('messages.auth_send_code') }}</button>
        </form>

        <p class="auth-footer">
            <a href="{{ route('login') }}">{{ __('messages.auth_back_to_login') }}</a>
        </p>
    </div>
</div>
@endsection
