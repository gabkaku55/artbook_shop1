@php
    $themeStorageKey = request()->routeIs('admin.*') ? 'artbook-admin-theme' : 'artbook-shop-theme';
@endphp
<!DOCTYPE html>
<html lang="en" data-theme-key="{{ $themeStorageKey }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'ArtbookShop') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        (function () {
            try {
                var k = document.documentElement.getAttribute('data-theme-key');
                if (!k) return;
                var v = localStorage.getItem(k);
                var root = document.documentElement;
                if (v === 'light') {
                    root.setAttribute('data-theme', 'light');
                } else {
                    root.removeAttribute('data-theme');
                }
            } catch (e) {}
        })();
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .shared-bg {
            position: relative;
            background: url('/images/fon.jpg') center top / cover no-repeat;
            background-attachment: fixed;
        }
        .shared-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 0;
        }
        .shared-bg > * {
            position: relative;
            z-index: 1;
        }
        @if(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.request') || request()->routeIs('password.reset.form'))
        .auth-bg {
            min-height: 100vh;
            background: url('{{ asset('images/ellietlou2.jpg') }}') center center / cover no-repeat fixed;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        .auth-bg::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: -1;
        }
        /* Auth — dark glass, більші відступи, тільки placeholder (label приховано) */
        .auth-bg .auth-page {
            min-height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12rem 4.5rem 15rem;
            width: 100%;
        }
        .auth-bg .auth-page .auth-card {
            position: relative;
            width: 100%;
            max-width: 420px;
            padding: 2.5rem 2rem;
            background: rgba(15, 23, 42, 0.75) !important;
            backdrop-filter: blur(7px);
            -webkit-backdrop-filter: blur(7px);
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
            border-radius: 18px;
            color: #e2e8f0;
        }
        .auth-bg .auth-page .auth-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            line-height: 1;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.08);
            transition: background 0.2s, color 0.2s;
        }
        .auth-bg .auth-page .auth-close:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #f1f5f9;
        }
        .auth-bg .auth-page .auth-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin: 0 0 1.75rem;
            color: #f8fafc !important;
        }
        .auth-bg .auth-page .auth-card form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }
        .auth-bg .auth-page .field {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .auth-bg .auth-page .field label:not(.remember),
        .auth-bg .auth-page .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        .auth-bg .auth-page .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .auth-bg .auth-page .input-wrap input {
            width: 100%;
            padding: 0.75rem 2.75rem 0.75rem 0.75rem !important;
            font-size: 1rem;
            color: #f1f5f9 !important;
            background: rgba(255, 255, 255, 0.06) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 10px;
            outline: none;
            transition: background 0.2s, border-color 0.2s, box-shadow 0.2s;
        }
        .auth-bg .auth-page .input-wrap input::placeholder {
            color: #94a3b8;
        }
        .auth-bg .auth-page .input-wrap input:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(148, 163, 184, 0.5) !important;
            box-shadow: 0 0 0 2px rgba(148, 163, 184, 0.2);
        }
        .auth-bg .auth-page .input-wrap input.auth-input-error {
            border-color: #f87171 !important;
        }
        .auth-bg .auth-page .input-wrap input.auth-input-code {
            text-align: center;
            letter-spacing: 0.35em;
        }
        .auth-bg .auth-page .input-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            pointer-events: none;
            font-size: 0.95rem;
        }
        .auth-bg .auth-page .field .error-msg {
            font-size: 0.75rem;
            color: #fca5a5;
            margin-top: 0.25rem;
        }
        .auth-bg .auth-page .auth-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        .auth-bg .auth-page .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #cbd5e1 !important;
            cursor: pointer;
            font-weight: 500;
        }
        .auth-bg .auth-page .remember input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            accent-color: #94a3b8;
            cursor: pointer;
        }
        .auth-bg .auth-page .forgot {
            font-size: 0.85rem;
            color: #94a3b8 !important;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .auth-bg .auth-page .forgot:hover {
            color: #e2e8f0 !important;
            text-decoration: underline;
        }
        .auth-bg .auth-page .auth-btn {
            width: 100%;
            padding: 0.9rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a !important;
            background: #e2e8f0 !important;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            margin-top: 0.25rem;
        }
        .auth-bg .auth-page .auth-btn:hover {
            background: #f1f5f9 !important;
        }
        .auth-bg .auth-page .auth-btn:active {
            transform: scale(0.99);
        }
        .auth-bg .auth-page .auth-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #94a3b8 !important;
        }
        .auth-bg .auth-page .auth-footer a {
            color: #e2e8f0 !important;
            font-weight: 600;
            text-decoration: none;
            margin-left: 0.25rem;
            transition: color 0.2s;
        }
        .auth-bg .auth-page .auth-footer a:hover {
            color: #f8fafc !important;
            text-decoration: underline;
        }
        .auth-bg .auth-page .auth-info {
            margin-bottom: 1.25rem;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: 0.85rem;
            color: #94a3b8;
            text-align: center;
        }
        /* Dark theme defaults; light theme overrides in resources/css/theme-light.css */
        @media (max-width: 480px) {
            .auth-bg .auth-page { padding: 9rem 3rem 12rem; }
            .auth-bg .auth-page .auth-card { max-width: 90%; padding: 2rem 1.25rem; }
            .auth-bg .auth-page .auth-title { font-size: 1.65rem; }
        }
        @endif
    </style>
</head>
@if(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.request') || request()->routeIs('password.reset.form'))
    <body class="text-gray-100 flex flex-col min-h-screen auth-bg @if(request()->routeIs('register')) auth-register @endif">
@else
    <body class="text-gray-100 flex flex-col min-h-screen">
@endif
    @include('components.header')

    <main class="flex-grow @if(request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.request') || request()->routeIs('password.reset.form')) flex flex-col items-center justify-center @else bg-gray-950 @endif">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-green-900 border border-green-700 text-green-100 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-4">
                <div class="bg-red-900 border border-red-700 text-red-100 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('components.footer')
    
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
    (function () {
        var root = document.documentElement;
        var key = root.getAttribute('data-theme-key');
        if (!key) return;
        function getTheme() {
            return root.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
        }
        function setTheme(mode) {
            if (mode === 'light') {
                root.setAttribute('data-theme', 'light');
            } else {
                root.removeAttribute('data-theme');
            }
            try {
                localStorage.setItem(key, mode);
            } catch (e) {}
            syncHeroVideo();
            updateToggleButtons();
        }
        function syncHeroVideo() {
            var video = document.getElementById('hero-bg-video');
            if (!video) return;
            var darkSrc = video.getAttribute('data-src-dark');
            var lightSrc = video.getAttribute('data-src-light');
            var next = getTheme() === 'light' ? lightSrc : darkSrc;
            var source = video.querySelector('source');
            if (!source || !next) return;
            if (source.getAttribute('src') === next) return;
            source.setAttribute('src', next);
            video.load();
        }
        function updateToggleButtons() {
            var light = getTheme() === 'light';
            document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
                var moon = btn.querySelector('.theme-icon-moon');
                var sun = btn.querySelector('.theme-icon-sun');
                if (moon) moon.toggleAttribute('hidden', light);
                if (sun) sun.toggleAttribute('hidden', !light);
                btn.setAttribute('aria-label', light ? 'Switch to dark mode' : 'Switch to light mode');
            });
        }
        window.addEventListener('storage', function (e) {
            if (!key || e.key !== key || e.storageArea !== localStorage) {
                return;
            }
            if (e.newValue === 'light') {
                root.setAttribute('data-theme', 'light');
            } else {
                root.removeAttribute('data-theme');
            }
            syncHeroVideo();
            updateToggleButtons();
        });
        function bind() {
            document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    setTheme(getTheme() === 'light' ? 'dark' : 'light');
                });
            });
            syncHeroVideo();
            updateToggleButtons();
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bind);
        } else {
            bind();
        }
    })();
    </script>
    <script>
    window.phoneInvalidHint = @json(__('messages.phone_invalid'));
    (function() {
        function digitsOnly(str) { return (str || '').replace(/\D/g, ''); }
        function formatPhone(raw) {
            var d = raw.slice(0, 12);
            if (d.length > 3 && d.slice(0, 3) !== '380') d = '380' + d.replace(/^380/, '').slice(0, 9);
            else if (d.length <= 3 && d.length > 0 && d !== '380') d = ('380' + d).slice(0, 12);
            var nine = d.slice(3, 12);
            var display = '+380';
            if (nine.length > 0) display += ' (' + nine.slice(0, 2);
            if (nine.length >= 2) display += ') ' + nine.slice(2, 5);
            if (nine.length > 5) display += '-' + nine.slice(5, 7);
            if (nine.length > 7) display += '-' + nine.slice(7, 9);
            return { raw: d.slice(0, 12), display: display };
        }
        function applyMask(input, hintEl) {
            var val = digitsOnly(input.value);
            if (val.length > 0 && val.slice(0, 3) !== '380') val = '380' + val.replace(/^380/, '').slice(0, 9);
            var res = formatPhone(val);
            input.value = res.display;
            input.dataset.phoneRaw = res.raw;
            if (hintEl) {
                if (res.raw.length > 0 && res.raw.length < 12) { hintEl.textContent = window.phoneInvalidHint || 'Enter full number: +380 (XX) XXX-XX-XX'; hintEl.style.display = 'block'; input.classList.add('!border-red-500'); }
                else { hintEl.style.display = 'none'; input.classList.remove('!border-red-500'); }
            }
        }
        function initInput(input) {
            if (input.dataset.phoneMask) return;
            input.dataset.phoneMask = '1';
            var hint = document.createElement('p');
            hint.className = 'text-red-500 text-xs mt-1';
            hint.style.display = 'none';
            hint.setAttribute('aria-live', 'polite');
            input.parentNode.insertBefore(hint, input.nextSibling);
            var raw = digitsOnly(input.value);
            if (raw.length > 0) {
                if (raw.slice(0, 3) !== '380') raw = '380' + raw.replace(/^380/, '').slice(0, 9);
                var r = formatPhone(raw.slice(0, 12));
                input.value = r.display;
                input.dataset.phoneRaw = r.raw;
            }
            input.addEventListener('input', function(e) {
                var key = e.data;
                if (key && /[^\d]/.test(key)) return;
                applyMask(input, hint);
            });
            input.addEventListener('keypress', function(e) {
                if (e.key.length === 1 && /\D/.test(e.key)) e.preventDefault();
            });
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                var pasted = digitsOnly((e.clipboardData || window.clipboardData).getData('text'));
                var res = formatPhone(pasted);
                input.value = res.display;
                input.dataset.phoneRaw = res.raw;
                applyMask(input, hint);
            });
            input.addEventListener('blur', function() { applyMask(input, hint); });
        }
        function getPhoneInputs(root) {
            return root.querySelectorAll('input[name="phone"], input#phone, input[autocomplete="tel"]');
        }
        document.addEventListener('DOMContentLoaded', function() {
            getPhoneInputs(document).forEach(initInput);
            document.addEventListener('submit', function(e) {
                var form = e.target;
                var phones = getPhoneInputs(form);
                if (phones.length === 0) return;
                var invalid = [];
                phones.forEach(function(input) {
                    var raw = input.dataset.phoneRaw || digitsOnly(input.value);
                    if (raw.length > 0 && raw.slice(0, 3) !== '380') raw = '380' + raw.replace(/^380/, '').slice(0, 9);
                    var required = input.hasAttribute('required');
                    if (required && raw.length === 0) invalid.push(input);
                    else if (raw.length > 0 && (raw.length !== 12 || raw.slice(0, 3) !== '380')) invalid.push(input);
                    else if (raw.length === 12) input.value = raw;
                });
                if (invalid.length > 0) {
                    e.preventDefault();
                    invalid.forEach(function(input) {
                        input.classList.add('!border-red-500');
                        var hint = input.nextElementSibling;
                        if (hint && hint.className && hint.className.indexOf('text-red-500') !== -1) {
                            hint.textContent = window.phoneInvalidHint || 'Enter full number: +380 (XX) XXX-XX-XX';
                            hint.style.display = 'block';
                        }
                    });
                    invalid[0].focus();
                }
            });
        });
    })();
    </script>
</body>
</html>
