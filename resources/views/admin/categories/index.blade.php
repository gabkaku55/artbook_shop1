@extends('admin.dashboard')

@section('admin_content')
<div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Керування категоріями</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <div class="lg:col-span-1">
        <div class="bg-gray-900 rounded-[2rem] border border-gray-800 shadow-2xl p-8 sticky top-24">
            <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-6">Додати категорію</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Назва категорії</label>
                        <input type="text" name="name" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border" placeholder="Наприклад: Фентезі">
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/20">
                        Створити
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-gray-900 rounded-[2rem] border border-gray-800 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-800/50 text-[10px] uppercase text-gray-500 font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-6">ID</th>
                            <th class="px-8 py-6">Назва</th>
                            <th class="px-8 py-6 text-right">Дії</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50 text-sm">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-800/30 transition group">
                                <td class="px-8 py-6 font-black text-gray-600">#{{ $category->id }}</td>
                                <td class="px-8 py-6">
                                    <p class="font-bold text-white text-lg leading-tight">{{ $category->name }}</p>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-3 opacity-50 group-hover:opacity-100 transition">
                                        <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" onsubmit="return confirm('Ви впевнені? Це також може вплинути на товари в цій категорії.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-gray-800 text-red-500 hover:bg-red-600 hover:text-white transition rounded-xl">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
