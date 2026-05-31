@extends('admin.dashboard')

@section('admin_content')
<div class="mb-12">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Профіль адміністратора</h2>
    <p class="text-gray-500 mt-2">Керування особистими даними та безпекою акаунта</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
    <div class="space-y-12">
        <div class="bg-gray-900 rounded-[2.5rem] border border-gray-800 shadow-2xl p-8 lg:p-10">
            <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-8 flex items-center">
                <i class="fas fa-user-circle mr-3 text-indigo-500"></i> Основна інформація
            </h3>
            
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">ПІБ (Ім'я)</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Email адреса</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Телефон (контакт відповідального)</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border" placeholder="+380...">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/20">
                        Оновити дані
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gray-900 rounded-[2.5rem] border border-gray-800 shadow-2xl p-8 lg:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-5 text-7xl text-indigo-500">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="relative z-10">
                <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-4 flex items-center">
                    <i class="fas fa-key mr-3 text-indigo-500"></i> Двоетапна автентифікація
                </h3>
                <p class="text-gray-400 text-sm mb-8 leading-relaxed">
                    Додатковий рівень безпеки: при кожному вході ми надсилатимемо секретний код на вашу пошту.
                </p>

                <div class="flex items-center justify-between p-6 bg-gray-800/50 rounded-3xl border border-gray-700">
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest {{ $user->two_factor_enabled ? 'text-green-500' : 'text-gray-500' }}">
                            Статус: {{ $user->two_factor_enabled ? 'Увімкнено' : 'Вимкнено' }}
                        </p>
                    </div>
                    <form action="{{ route('admin.profile.2fa') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition
                            {{ $user->two_factor_enabled ? 'bg-red-900/20 text-red-500 border border-red-500/20 hover:bg-red-900/40' : 'bg-green-900/20 text-green-500 border border-green-500/20 hover:bg-green-900/40' }}">
                            {{ $user->two_factor_enabled ? 'Вимкнути' : 'Увімкнути' }}
                        </button>
                    </form>
                </div>
                
                @if($user->two_factor_enabled)
                    <div class="mt-6 p-4 bg-indigo-900/10 border border-indigo-500/20 rounded-2xl">
                        <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-widest text-center">
                            <i class="fas fa-info-circle mr-1"></i> Demo: Тепер при вході буде запитано код з пошти
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div>
        <div class="bg-gray-900 rounded-[2.5rem] border border-gray-800 shadow-2xl p-8 lg:p-10">
            <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-8 flex items-center">
                <i class="fas fa-lock mr-3 text-indigo-500"></i> Безпека
            </h3>
            
            <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Поточний пароль</label>
                    <input type="password" name="current_password" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                </div>

                <div class="pt-4 border-t border-gray-800">
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Новий пароль</label>
                    <input type="password" name="password" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Підтвердження нового пароля</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-gray-800 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-gray-700 transition border border-gray-700">
                        Змінити пароль
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
