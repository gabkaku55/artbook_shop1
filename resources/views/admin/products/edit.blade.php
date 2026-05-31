@extends('admin.dashboard')

@section('admin_content')
<div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Редагувати артбук</h2>
    <a href="{{ route('admin.products.index') }}" class="w-full md:w-auto bg-gray-800 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-gray-700 transition flex items-center justify-center">
        <i class="fas fa-arrow-left mr-3"></i> Назад до списку
    </a>
</div>

<div class="bg-gray-900 rounded-[2.5rem] border border-gray-800 shadow-2xl p-8 lg:p-12">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="space-y-8">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Назва артбуку</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Автор / Студія</label>
                        <input type="text" name="author" value="{{ old('author', $product->author) }}" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Опис</label>
                        <textarea name="description" rows="6" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Ціна</label>
                            <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Ціна зі знижкою</label>
                            <input type="number" name="sale_price" step="0.01" min="0" value="{{ old('sale_price', $product->sale_price) }}" placeholder="450" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white placeholder-gray-500 focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Склад</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Сторінки</label>
                            <input type="number" name="pages" value="{{ old('pages', $product->pages) }}" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Мова</label>
                            <input type="text" name="language" value="{{ old('language', $product->language) }}" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Видавництво</label>
                            <input type="text" name="publisher" value="{{ old('publisher', $product->publisher) }}" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Вік</label>
                            <input type="text" name="age_limit" value="{{ old('age_limit', $product->age_limit) }}" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Тип обкладинки</label>
                        <select name="cover_type" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                            <option value="">Оберіть тип</option>
                            <option value="Тверда" {{ old('cover_type', $product->cover_type) == 'Тверда' ? 'selected' : '' }}>Тверда</option>
                            <option value="М’яка" {{ old('cover_type', $product->cover_type) == 'М’яка' ? 'selected' : '' }}>М’яка</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Категорія</label>
                        <select name="category_id" required class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-3 ml-1">Обкладинка</label>
                        <div class="flex gap-6 items-start">
                            @if($product->image_url)
                                <div class="w-24 h-32 flex-shrink-0 bg-gray-800 rounded-xl overflow-hidden border border-gray-700">
                                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <input type="file" name="image" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-8 text-gray-400 focus:ring-2 focus:ring-indigo-500 transition border text-xs">
                        </div>
                    </div>

                    <div class="bg-gray-800/50 p-6 rounded-3xl border border-gray-700 space-y-4">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="is_new" value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-700 bg-gray-900 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs font-black uppercase tracking-widest text-gray-400 group-hover:text-white transition">Новинка</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $product->is_popular) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-700 bg-gray-900 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs font-black uppercase tracking-widest text-gray-400 group-hover:text-white transition">Популярний</span>
                        </label>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full bg-indigo-600 text-white px-8 py-5 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition shadow-2xl shadow-indigo-500/40 flex items-center justify-center">
                            <i class="fas fa-sync-alt mr-3"></i> Оновити артбук
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
