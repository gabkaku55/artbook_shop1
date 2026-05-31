@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <a class="auth-close" href="{{ url('/') }}" aria-label="{{ __('messages.auth_close') }}">×</a>
        <h1 class="auth-title">{{ __('messages.auth_title_register') }}</h1>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="field">
                <label for="register-name" class="visually-hidden">{{ __('messages.auth_name') }}</label>
                <div class="input-wrap">
                    <input type="text" id="register-name" name="name" value="{{ old('name') }}" placeholder="{{ __('messages.auth_name') }}" required class="@error('name') auth-input-error @enderror">
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-user"></i></span>
                </div>
                @error('name') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="field">
                <label for="register-email" class="visually-hidden">{{ __('messages.auth_email') }}</label>
                <div class="input-wrap">
                    <input type="email" id="register-email" name="email" value="{{ old('email') }}" placeholder="{{ __('messages.auth_email') }}" required class="@error('email') auth-input-error @enderror">
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-envelope"></i></span>
                </div>
                @error('email') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="field">
                <label for="register-password" class="visually-hidden">{{ __('messages.auth_password') }}</label>
                <div class="input-wrap">
                    <input type="password" id="register-password" name="password" placeholder="{{ __('messages.auth_password') }}" required class="@error('password') auth-input-error @enderror">
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-lock"></i></span>
                </div>
                @error('password') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="field">
                <label for="register-password-confirmation" class="visually-hidden">{{ __('messages.auth_confirm_password') }}</label>
                <div class="input-wrap">
                    <input type="password" id="register-password-confirmation" name="password_confirmation" placeholder="{{ __('messages.auth_confirm_password') }}" required>
                    <span class="input-icon" aria-hidden="true"><i class="fas fa-lock"></i></span>
                </div>
            </div>

            <button class="auth-btn" type="submit">{{ __('messages.auth_submit_register') }}</button>
        </form>
        <script>
            (function() {
                var form = document.querySelector('form[action="{{ route('register') }}"]');
                var passInput = document.getElementById('register-password');
                if (!form || !passInput) return;
                form.addEventListener('submit', function(e) {
                    var p = passInput.value;
                    if (p.length < 8 || !/[a-z]/.test(p) || !/[A-Z]/.test(p) || !/\d/.test(p)) {
                        e.preventDefault();
                        var field = passInput.closest('.field');
                        var err = field ? field.querySelector('.error-msg') : null;
                        if (!err) {
                            err = document.createElement('p');
                            err.className = 'error-msg';
                            field.appendChild(err);
                        }
                        err.textContent = 'Пароль має містити мінімум 8 символів, щонайменше одну велику літеру, одну малу літеру та одну цифру.';
                        err.style.display = 'block';
                        return false;
                    }
                });
                passInput.addEventListener('input', function() {
                    var err = passInput.closest('.field');
                    if (err) {
                        var msg = err.querySelector('.error-msg');
                        if (msg) msg.style.display = 'none';
                    }
                });
            })();
        </script>

        <p class="auth-footer">
            {{ __('messages.auth_has_account') }}
            <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
        </p>
    </div>
</div>
@endsection
