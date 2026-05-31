@extends('admin.dashboard')

@section('admin_content')
<div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Керування відео розпаковок</h2>
    <a href="{{ route('admin.unboxing-videos.create') }}" class="w-full md:w-auto bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/20 flex items-center justify-center">
        <i class="fas fa-plus mr-3"></i> Додати відео
    </a>
</div>

<div class="bg-gray-900 rounded-[2rem] border border-gray-800 shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-800/50 text-[10px] uppercase text-gray-500 font-black tracking-widest">
                <tr>
                    <th class="px-8 py-6">ID</th>
                    <th class="px-8 py-6">Превʼю</th>
                    <th class="px-8 py-6">Назва</th>
                    <th class="px-8 py-6">Опис</th>
                    <th class="px-8 py-6 text-right">Дії</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50 text-sm">
                @forelse($videos as $video)
                    <tr class="hover:bg-gray-800/30 transition group">
                        <td class="px-8 py-6 font-black text-gray-600">#{{ $video->id }}</td>
                        <td class="px-8 py-6">
                            <video class="w-28 h-16 rounded-xl border border-gray-700 object-cover bg-gray-950" preload="metadata" muted>
                                <source src="{{ $video->video_url }}">
                            </video>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-bold text-white text-base leading-tight">{{ $video->title }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-gray-400 text-sm max-w-md line-clamp-2">{{ $video->description }}</p>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-3 opacity-60 group-hover:opacity-100 transition">
                                <a href="{{ route('admin.unboxing-videos.edit', $video->id) }}" class="w-10 h-10 flex items-center justify-center bg-gray-800 text-indigo-400 hover:bg-indigo-600 hover:text-white transition rounded-xl">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.unboxing-videos.delete', $video->id) }}" method="POST" onsubmit="return confirm('Видалити відео?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center bg-gray-800 text-red-500 hover:bg-red-600 hover:text-white transition rounded-xl">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-gray-500">Відео ще не додані.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-8 border-t border-gray-800 bg-gray-800/20">
        {{ $videos->links() }}
    </div>
</div>
@endsection
