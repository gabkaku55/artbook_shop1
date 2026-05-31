@extends('admin.dashboard')

@section('admin_content')
<div class="mb-8">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Редагувати відео</h2>
</div>

<form action="{{ route('admin.unboxing-videos.update', $unboxingVideo->id) }}" method="POST" enctype="multipart/form-data" class="bg-gray-900 rounded-[2rem] border border-gray-800 p-8 space-y-6">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Назва</label>
        <input type="text" name="title" value="{{ old('title', $unboxingVideo->title) }}" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-indigo-500 focus:border-indigo-500">
        @error('title')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Короткий опис</label>
        <textarea name="description" rows="4" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $unboxingVideo->description) }}</textarea>
        @error('description')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
    </div>

    <div class="space-y-4">
        <div>
            <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Поточне відео</label>
            <video controls class="w-full max-w-md rounded-xl border border-gray-700 bg-gray-950">
                <source src="{{ $unboxingVideo->video_url }}">
            </video>
        </div>
        <div>
            <label class="block text-xs font-black uppercase tracking-widest text-gray-500 mb-2">Замінити відео (mp4, webm, mov)</label>
            <input type="file" name="video" accept=".mp4,.webm,.mov,video/mp4,video/webm,video/quicktime" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white">
            @error('video')<p class="text-red-400 text-xs mt-2">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition">
            Оновити
        </button>
        <a href="{{ route('admin.unboxing-videos.index') }}" class="text-gray-400 hover:text-white text-sm">Скасувати</a>
    </div>
</form>
@endsection
