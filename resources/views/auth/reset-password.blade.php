@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <a class="auth-close" href="{{ url('/') }}" aria-label="{{ __('messages.auth_close') }}">×</a>
        <h1 class="auth-title">{{ __('messages.auth_reset_title') }}</h1>

        @if(session('demoCode'))
            <div class="auth-info">
                Код для скидання : <strong>{{ session('demoCode') }}</strong>
            </div>
        @elseif(session('info'))
            <div class="auth-info">{{ session('info') }}</div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="field">
                <label for="reset-code" class="visually-hidden">{{ __('messages.auth_code_placeholder') }}</label>
                <div class="input-wrap">
                    <input type="text" id="reset-code" name="code" maxlength="6" value="{{ old('code') }}" placeholder="{{ __('messages.auth_code_placeholder') }}" required class="auth-input-code @error('code') auth-input-error @enderror">
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-key"></i></span>
                </div>
                @error('code') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="field">
                <label for="reset-password" class="visually-hidden">{{ __('messages.auth_new_password_placeholder') }}</label>
                <div class="input-wrap">
                    <input type="password" id="reset-password" name="password" placeholder="{{ __('messages.auth_new_password_placeholder') }}" required class="@error('password') auth-input-error @enderror">
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-lock"></i></span>
                </div>
                @error('password') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="field">
                <label for="reset-password-confirmation" class="visually-hidden">{{ __('messages.auth_confirm_password') }}</label>
                <div class="input-wrap">
                    <input type="password" id="reset-password-confirmation" name="password_confirmation" placeholder="{{ __('messages.auth_confirm_password') }}" required>
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-lock"></i></span>
                </div>
            </div>

            <button class="auth-btn" type="submit">{{ __('messages.auth_update_password') }}</button>
        </form>
    </div>
</div>
@endsection
