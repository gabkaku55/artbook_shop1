@extends('admin.dashboard')

@section('admin_content')
<div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Керування користувачами</h2>
</div>

<div class="bg-gray-900 rounded-[2rem] border border-gray-800 shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-800/50 text-[10px] uppercase text-gray-500 font-black tracking-widest">
                <tr>
                    <th class="px-8 py-6">ID</th>
                    <th class="px-8 py-6">Ім'я</th>
                    <th class="px-8 py-6">Email</th>
                    <th class="px-8 py-6">Роль</th>
                    <th class="px-8 py-6">Дата реєстрації</th>
                    <th class="px-8 py-6 text-right">Дії</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50 text-sm">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-800/30 transition group">
                        <td class="px-8 py-6 font-black text-gray-600">#{{ $user->id }}</td>
                        <td class="px-8 py-6 font-bold text-white">{{ $user->name }}</td>
                        <td class="px-8 py-6 text-gray-400">{{ $user->email }}</td>
                        <td class="px-8 py-6">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" class="bg-gray-800 border-gray-700 rounded-xl px-3 py-1 text-xs font-black uppercase tracking-widest text-white focus:ring-indigo-500 transition">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Користувач</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Адмін</option>
                                    </select>
                                </form>
                            @else
                                <span class="bg-indigo-900/20 text-indigo-400 border border-indigo-500/20 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                                    Ви ({{ $user->role }})
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-gray-400">{{ $user->created_at->format('d.m.Y') }}</td>
                        <td class="px-8 py-6 text-right">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Ви впевнені? Це видалить користувача назавжди.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center bg-gray-800 text-red-500 hover:bg-red-600 hover:text-white transition rounded-xl">
                                        <i class="fas fa-user-minus"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-800">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-8 py-8 border-t border-gray-800 bg-gray-800/20">
        {{ $users->links() }}
    </div>
</div>
@endsection
