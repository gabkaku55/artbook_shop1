@extends('admin.dashboard')

@section('admin_content')
<div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Керування товарами</h2>
    <a href="{{ route('admin.products.create') }}" class="w-full md:w-auto bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/20 flex items-center justify-center">
        <i class="fas fa-plus mr-3"></i> Додати артбук
    </a>
</div>

<div class="bg-gray-900 rounded-[2rem] border border-gray-800 shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-800/50 text-[10px] uppercase text-gray-500 font-black tracking-widest">
                <tr>
                    <th class="px-8 py-6">ID</th>
                    <th class="px-8 py-6">Фото</th>
                    <th class="px-8 py-6">Назва</th>
                    <th class="px-8 py-6">Категорія</th>
                    <th class="px-8 py-6">Ціна</th>
                    <th class="px-8 py-6">Склад</th>
                    <th class="px-8 py-6 text-right">Дії</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50 text-sm">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-800/30 transition group">
                        <td class="px-8 py-6 font-black text-gray-600">#{{ $product->id }}</td>
                        <td class="px-8 py-6">
                            <div class="w-12 h-16 bg-gray-800 rounded-xl overflow-hidden border border-gray-700 shadow-sm">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-bold text-white text-lg leading-tight">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500 font-bold uppercase mt-1 tracking-wider">{{ $product->author }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest bg-indigo-900/20 px-3 py-1 rounded-full border border-indigo-500/20">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="px-8 py-6 font-black text-white text-lg tracking-tighter">{{ number_format($product->price, 2) }} грн</td>
                        <td class="px-8 py-6">
                            @php $isLow = $product->stock <= 5 && $product->stock > 0; @endphp
                            <div class="inline-flex items-center whitespace-nowrap px-4 py-2 rounded-xl font-black text-xs uppercase tracking-widest border shadow-sm
                                {{ $product->stock > 5 ? 'bg-green-900/20 text-green-500 border-green-500/20' : '' }}
                                {{ $isLow ? 'bg-amber-900/20 text-amber-500 border-amber-500/20' : '' }}
                                {{ $product->stock == 0 ? 'bg-red-900/20 text-red-500 border-red-500/20' : '' }}">
                                <i class="fas {{ $product->stock > 5 ? 'fa-check-circle' : ($isLow ? 'fa-exclamation-circle' : 'fa-times-circle') }} mr-2"></i>
                                <span>{{ $product->stock }} шт.</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-3 opacity-50 group-hover:opacity-100 transition">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="w-10 h-10 flex items-center justify-center bg-gray-800 text-indigo-400 hover:bg-indigo-600 hover:text-white transition rounded-xl">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" onsubmit="return confirm('Ви впевнені?')">
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
    <div class="px-8 py-8 border-t border-gray-800 bg-gray-800/20">
        {{ $products->links() }}
    </div>
</div>
@endsection
