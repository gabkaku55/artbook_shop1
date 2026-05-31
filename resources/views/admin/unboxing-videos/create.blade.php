@extends('admin.dashboard')

@section('admin_content')
<div class="mb-8">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Додати відео розпаковки</h2>
</div>

<form action="{{ route('admin.unboxing-videos.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-900 rounded-[2rem] border border-gray-800 p-8 space-y-6">
    @csrf

    <div>
        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Назва</label>
        <input type="text" name="title" value="{{ old('title') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-indigo-500 focus:border-indigo-500">
        @error('title')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Короткий опис</label>
        <textarea name="description" rows="4" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
        @error('description')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Відеофайл (mp4, webm, mov)</label>
        <input type="file" name="video" accept=".mp4,.webm,.mov,video/mp4,video/webm,video/quicktime" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white">
        @error('video')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition">
            Зберегти
        </button>
        <a href="{{ route('admin.unboxing-videos.index') }}" class="text-gray-400 hover:text-white text-sm">Скасувати</a>
    </div>
</form>
@endsection
