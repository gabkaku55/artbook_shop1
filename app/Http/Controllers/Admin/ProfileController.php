<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('admin.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);
        $user->update($data);
        return back()->with('success', 'Профіль оновлено успішно.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Поточний пароль невірний.']);
        }
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return back()->with('success', 'Пароль змінено успішно.');
    }

    public function toggle2FA()
    {
        $user = auth()->user();
        $user->update([
            'two_factor_enabled' => !$user->two_factor_enabled,
        ]);

        $status = $user->two_factor_enabled ? 'увімкнено' : 'вимкнено';
        return back()->with('success', "Двоетапну автентифікацію $status.");
    }
}

