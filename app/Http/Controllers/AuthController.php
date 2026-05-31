<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $remember = $request->boolean('remember');
            if ($user->two_factor_enabled) {
                $code = rand(100000, 999999);
                $user->update([
                    'two_factor_code' => $code,
                    'two_factor_expires_at' => now()->addMinutes(10),
                ]);
                $request->session()->put('2fa_user_id', $user->id);
                $request->session()->put('2fa_remember', $remember);

                return redirect()->route('login.2fa')->with('info', "Код підтвердження (Demo): $code");
            }
            Auth::login($user, $remember);
            $request->session()->regenerate();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'Невірний email або пароль.',
        ])->onlyInput('email');
    }

    public function show2FA()
    {
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.2fa');
    }

    public function verify2FA(Request $request)
    {
        $request->validate(['code' => 'required']);
        $userId = session()->get('2fa_user_id');
        $user = User::find($userId);
        if ($user && $user->two_factor_code == $request->code && now()->lessThan($user->two_factor_expires_at)) {
            $user->update(['two_factor_code' => null, 'two_factor_expires_at' => null]);
            $remember = $request->session()->pull('2fa_remember', false);
            Auth::login($user, $remember);
            $request->session()->forget('2fa_user_id');
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors(['code' => 'Невірний або прострочений код.']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
        ], [
            'password.regex' => 'Пароль має містити мінімум 8 символів, щонайменше одну велику літеру, одну малу літеру та одну цифру.',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);
        Auth::login($user);
        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();
        $code = rand(100000, 999999);
        $user->update([
            'reset_code' => $code,
            'reset_expires_at' => now()->addMinutes(15),
        ]);

        return redirect()->route('password.reset.form', ['email' => $user->email])
            ->with('info', "Код для скидання : $code")
            ->with('demoCode', $code);
    }

    public function showResetPassword(Request $request)
    {
        return view('auth.reset-password', ['email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user->reset_code == $request->code && now()->lessThan($user->reset_expires_at)) {
            $user->update([
                'password' => Hash::make($request->password),
                'reset_code' => null,
                'reset_expires_at' => null,
            ]);
            return redirect()->route('login')->with('success', 'Пароль успішно змінено. Тепер ви можете увійти.');
        }
        return back()->withErrors(['code' => 'Невірний або прострочений код.']);
    }
}
