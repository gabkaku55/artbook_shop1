@extends('layouts.app')

@section('content')
<div class="py-20 bg-gray-950 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-gray-900 p-12 rounded-[2.5rem] shadow-2xl border border-gray-800">
        <div class="text-center mb-12">
            <div class="w-20 h-20 bg-indigo-600/20 rounded-full flex items-center justify-center mx-auto mb-6 border border-indigo-500/30">
                <i class="fas fa-shield-alt text-3xl text-indigo-500"></i>
            </div>
            <h1 class="text-3xl font-black text-white mb-3 tracking-tighter uppercase">Підтвердження</h1>
            <p class="text-gray-500 font-bold uppercase tracking-widest text-[10px]">Введіть код, надісланий на ваш Email</p>
        </div>

        @if(session('info'))
            <div class="mb-8 p-4 bg-indigo-900/20 border border-indigo-500/20 rounded-2xl text-center">
                <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest">{{ session('info') }}</p>
            </div>
        @endif

        <form action="{{ route('login.2fa') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-3 ml-1 text-center">6-значний код</label>
                <input type="text" name="code" maxlength="6" class="w-full px-6 py-5 bg-gray-800 border-gray-700 rounded-2xl text-white text-center text-2xl font-black tracking-[0.5em] focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('code') border-red-500 @enderror" required autofocus placeholder="000000">
                @error('code') <p class="text-red-500 text-[10px] mt-4 font-bold uppercase tracking-widest text-center">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-2xl font-black text-lg hover:bg-indigo-700 transition transform hover:scale-[1.02] shadow-xl shadow-indigo-500/20">
                Підтвердити
            </button>
        </form>

        <div class="mt-12 text-center">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-gray-600 font-bold uppercase tracking-widest text-[10px] hover:text-white transition">Скасувати та вийти</button>
            </form>
        </div>
    </div>
</div>
@endsection
