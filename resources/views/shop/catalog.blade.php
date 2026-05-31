@extends('layouts.app')

@section('content')
<div class="bg-gray-950 py-12 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-white mb-8">{{ __('messages.catalog') }}</h1>

        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="w-full lg:w-64 flex-shrink-0">
                <form action="{{ route('catalog') }}" method="GET" class="space-y-8 bg-gray-900 p-6 rounded-2xl border border-gray-800 shadow-sm">
                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">{{ __('messages.categories') }}</h3>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer group">
                                <input type="radio" name="category" value="" class="text-indigo-600 bg-gray-800 border-gray-700 focus:ring-indigo-500" {{ request('category') == '' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="ml-2 text-gray-400 group-hover:text-white transition">{{ __('messages.all_categories') }}</span>
                            </label>
                            @foreach($categories as $category)
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="category" value="{{ $category->slug }}" class="text-indigo-600 bg-gray-800 border-gray-700 focus:ring-indigo-500" {{ request('category') == $category->slug ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="ml-2 text-gray-400 group-hover:text-white transition">{{ $category->translated_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">{{ __('messages.price') }}</h3>
                        <div class="flex gap-2 items-center">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="{{ __('messages.min_price') }}" class="w-full px-3 py-2 bg-gray-800 border-gray-700 rounded-md text-sm text-white placeholder-gray-500 focus:ring-indigo-500">
                            <span class="text-gray-600">-</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ __('messages.max_price') }}" class="w-full px-3 py-2 bg-gray-800 border-gray-700 rounded-md text-sm text-white placeholder-gray-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-white mb-4">{{ __('messages.sort') }}</h3>
                        <select name="sort" class="w-full px-3 py-2 bg-gray-800 border-gray-700 rounded-md text-sm text-white focus:ring-indigo-500" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('messages.newest') }}</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('messages.price_asc') }}</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('messages.price_desc') }}</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ __('messages.name_asc') }}</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md font-bold hover:bg-indigo-700 transition">{{ __('messages.apply') }}</button>
                    <a href="{{ route('catalog') }}" class="block text-center text-sm text-gray-500 hover:text-indigo-400 mt-2 transition">{{ __('messages.clear_all') }}</a>
                </form>
            </aside>

            <div class="flex-grow">
                @if($products->isEmpty())
                    <div class="bg-gray-900 rounded-2xl p-12 text-center border border-gray-800">
                        <i class="fas fa-search text-4xl text-gray-700 mb-4"></i>
                        <h3 class="text-xl font-bold text-white">{{ __('messages.not_found') }}</h3>
                        <p class="text-gray-500 mt-2">{{ __('messages.try_changing_filters') }}</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                        @foreach($products as $product)
                            <div class="catalog-product-card bg-gray-900 rounded-2xl shadow-lg border border-gray-800 overflow-hidden hover:border-indigo-500/30 transition duration-300">
                                <a href="{{ route('product.show', $product->slug) }}">
                                    <div class="relative aspect-[3/4]">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover" alt="{{ $product->translated_name }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-600">
                                                <i class="fas fa-image text-4xl opacity-20"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                <div class="p-6 flex flex-col flex-grow">
                                    <div class="mb-4">
                                        <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">{{ $product->category->translated_name }}</span>
                                        <h3 class="font-bold text-lg text-white mt-1 leading-tight break-words">{{ $product->translated_name }}</h3>
                                        <p class="text-gray-500 text-xs mt-1">{{ $product->translated_author }}</p>
                                    </div>
                                    
                                    <div class="mt-auto">
                                        <div class="flex flex-wrap items-center gap-2 mb-4">
                                            @if($product->hasDiscount())
                                                <span class="text-base font-bold text-gray-500 line-through">{{ $product->formatted_old_price }}</span>
                                                <span class="text-xl font-black text-white">{{ $product->formatted_price }}</span>
                                            @else
                                                <span class="text-xl font-black text-white">{{ $product->formatted_price }}</span>
                                            @endif
                                        </div>
                                        
                                        <div class="flex items-center justify-between pt-4 border-t border-gray-800">
                                            <div class="flex items-center text-yellow-400 text-xs">
                                                @php $avgRating = $product->reviews->avg('rating') ?: 5; @endphp
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $avgRating ? '' : 'text-gray-700' }}"></i>
                                                @endfor
                                                <span class="ml-2 text-gray-500">({{ $product->reviews->count() }})</span>
                                            </div>
                                            <div class="flex gap-2">
                                                <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </form>
                                                @if($product->stock > 0)
                                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-gray-800 text-white p-2 rounded-lg hover:bg-indigo-600 transition flex items-center">
                                                            <i class="fas fa-shopping-cart"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-[8px] font-black uppercase text-red-500 border border-red-500/30 px-2 py-1 rounded-md bg-red-950/20">
                                                        @if(app()->getLocale() == 'uk') Немає @elseif(app()->getLocale() == 'en') Out @else Weg @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
