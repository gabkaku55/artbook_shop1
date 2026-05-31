@extends('layouts.app')

@section('content')
<div class="page-product py-12 bg-gray-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-12">
            <div class="w-full md:w-1/2">
                <div class="rounded-3xl overflow-hidden bg-gray-900 aspect-[3/4] mb-6 shadow-2xl border border-gray-800">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover" alt="{{ $product->translated_name }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-700 bg-gray-900">
                            <i class="fas fa-image text-6xl opacity-20"></i>
                        </div>
                    @endif
                </div>
                <div class="grid grid-cols-4 gap-4">
                    @if($product->gallery)
                        @foreach($product->gallery as $image)
                            <div class="aspect-square rounded-xl overflow-hidden bg-gray-900 border border-gray-800 hover:border-indigo-500 transition cursor-pointer shadow-sm">
                                <img src="{{ \App\Support\MediaUrl::resolve($image) }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="w-full md:w-1/2">
                <nav class="flex text-xs font-bold text-gray-500 mb-6 uppercase tracking-widest">
                    <a href="{{ route('home') }}" class="hover:text-indigo-400">{{ __('messages.home') }}</a>
                    <span class="mx-3 opacity-30">/</span>
                    <a href="{{ route('catalog') }}?category={{ $product->category->slug }}" class="hover:text-indigo-400">{{ $product->category->translated_name }}</a>
                </nav>

                <div class="flex justify-between items-start mb-2">
                    <h1 class="text-5xl font-black text-white leading-tight">{{ $product->translated_name }}</h1>
                    @auth
                        @if($inWishlist ?? false)
                            <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400 transition text-2xl p-2" title="{{ __('messages.wishlist') }}">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition text-2xl p-2" title="{{ __('messages.add_to_wishlist') }}">
                                    <i class="far fa-heart"></i>
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-400 hover:text-red-500 transition text-2xl p-2" title="{{ __('messages.add_to_wishlist') }}">
                            <i class="far fa-heart"></i>
                        </a>
                    @endauth
                </div>
                <p class="text-xl text-indigo-400 font-bold mb-8">{{ __('messages.author') }}: {{ $product->translated_author }}</p>

                <div class="flex items-center mb-10">
                    <div class="flex text-yellow-400 gap-1">
                        @php $avgRating = $product->reviews->avg('rating') ?: 0; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $avgRating ? '' : 'text-gray-800' }}"></i>
                        @endfor
                    </div>
                    <span class="ml-3 text-gray-500 text-sm font-medium">({{ $product->reviews->count() }} @if(app()->getLocale() == 'uk') відгуків @elseif(app()->getLocale() == 'en') reviews @else Bewertungen @endif)</span>
                </div>

                <div class="flex flex-wrap items-baseline gap-3 mb-10">
                    @if($product->hasDiscount())
                        <span class="text-2xl font-bold text-gray-500 line-through">{{ $product->formatted_old_price }}</span>
                        <span class="text-4xl font-black text-white tracking-tight">{{ $product->formatted_price }}</span>
                    @else
                        <span class="text-4xl font-black text-white tracking-tight">{{ $product->formatted_price }}</span>
                    @endif
                </div>

                <div x-data="{ tab: 'description' }" class="mb-12">
                    <div class="flex border-b border-gray-800 mb-6">
                        <button @click="tab = 'description'" :class="tab === 'description' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-300'" class="pb-4 px-6 font-bold uppercase tracking-widest text-xs border-b-2 transition">
                            {{ __('messages.description') }}
                        </button>
                        <button @click="tab = 'specs'" :class="tab === 'specs' ? 'border-indigo-500 text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-300'" class="pb-4 px-6 font-bold uppercase tracking-widest text-xs border-b-2 transition">
                            {{ __('messages.characteristics') }}
                        </button>
                    </div>

                    <div x-show="tab === 'description'" class="prose prose-invert prose-indigo text-gray-400 leading-relaxed break-words whitespace-pre-wrap" x-cloak>
                        {{ $product->translated_description }}
                    </div>

                    <div x-show="tab === 'specs'" class="space-y-4" x-cloak>
                        <div class="flex justify-between py-3 border-b border-gray-900">
                            <span class="text-gray-500">{{ __('messages.genre') }}</span>
                            <span class="text-white font-bold">{{ $product->category->translated_name }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-900">
                            <span class="text-gray-500">{{ __('messages.author') }}</span>
                            <span class="text-white font-bold">{{ $product->translated_author }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-900">
                            <span class="text-gray-500">{{ __('messages.pages') }}</span>
                            <span class="text-white font-bold">{{ $product->pages ?: '—' }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-900">
                            <span class="text-gray-500">@if(app()->getLocale() == 'uk') Вік @elseif(app()->getLocale() == 'en') Age @else Alter @endif</span>
                            <span class="text-white font-bold">{{ $product->age_limit ?: '—' }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-900">
                            <span class="text-gray-500">@if(app()->getLocale() == 'uk') Мова @elseif(app()->getLocale() == 'en') Language @else Sprache @endif</span>
                            <span class="text-white font-bold">{{ $product->language ?: '—' }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-900">
                            <span class="text-gray-500">@if(app()->getLocale() == 'uk') Видавництво @elseif(app()->getLocale() == 'en') Publisher @else Verlag @endif</span>
                            <span class="text-white font-bold">{{ $product->publisher ?: '—' }}</span>
                        </div>
                        <div class="flex justify-between py-3 border-b border-gray-900">
                            <span class="text-gray-500">@if(app()->getLocale() == 'uk') Тип обкладинки @elseif(app()->getLocale() == 'en') Cover Type @else Einband @endif</span>
                            <span class="text-white font-bold">{{ $product->cover_type ?: '—' }}</span>
                        </div>
                    </div>
                </div>

                <div class="product-stock-banner mb-12 p-5 rounded-2xl {{ $product->stock > 0 ? 'bg-green-900/20 text-green-400 border border-green-500/20 product-stock-banner--in-stock' : 'bg-red-950/40 text-red-500 border border-red-600 shadow-[0_0_20px_rgba(220,38,38,0.2)]' }} flex items-center shadow-sm">
                    <i class="fas {{ $product->stock > 0 ? 'fa-check-circle' : 'fa-times-circle' }} mr-3 text-xl"></i>
                    <span class="font-black tracking-wide uppercase text-sm">
                        @if($product->stock > 0)
                            @if(app()->getLocale() == 'uk') В наявності ({{ $product->stock }} шт.) @elseif(app()->getLocale() == 'en') In Stock ({{ $product->stock }} pcs) @else Auf Lager ({{ $product->stock }} Stk.) @endif
                        @else
                            @if(app()->getLocale() == 'uk') Немає в наявності @elseif(app()->getLocale() == 'en') Out of Stock @else Nicht vorrätig @endif
                        @endif
                    </span>
                </div>

                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-2xl font-black text-lg hover:bg-indigo-700 transition transform hover:scale-[1.02] shadow-xl shadow-indigo-500/20 flex items-center justify-center">
                            <i class="fas fa-shopping-cart mr-3"></i> {{ __('messages.add_to_cart') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        @if($similarProducts->count() > 0)
            <div class="mt-24">
                <h2 class="text-3xl font-black text-white mb-10 tracking-tight">{{ __('messages.similar_products') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($similarProducts as $similar)
                        <div class="group cursor-pointer" onclick="window.location='{{ route('product.show', $similar->slug) }}'">
                            <div class="relative overflow-hidden rounded-2xl bg-gray-800 aspect-[3/4] mb-4 shadow-lg group-hover:shadow-indigo-500/10 transition duration-500">
                                @if($similar->image_url)
                                    <img src="{{ $similar->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $similar->translated_name }}">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-500 flex items-end p-4">
                                    <span class="text-white font-bold text-sm">{{ __('messages.details') }}</span>
                                </div>
                            </div>
                            <h3 class="font-bold text-white group-hover:text-indigo-400 transition truncate">{{ $similar->translated_name }}</h3>
                            <p class="text-white font-black mt-1">{{ $similar->formatted_price }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-24 border-t border-gray-900 pt-20">
            <h2 class="text-4xl font-black text-white mb-16 tracking-tight text-center md:text-left">@if(app()->getLocale() == 'uk') Відгуки покупців @elseif(app()->getLocale() == 'en') Customer Reviews @else Kundenbewertungen @endif</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-20">
                <div class="lg:col-span-1">
                    @auth
                        <div class="bg-gray-900 p-10 rounded-3xl border border-gray-800 shadow-sm">
                            <h3 class="text-2xl font-bold mb-8 text-white">@if(app()->getLocale() == 'uk') Залишити відгук @elseif(app()->getLocale() == 'en') Leave a Review @else Bewertung abgeben @endif</h3>
                            <form action="{{ route('review.store', $product->id) }}" method="POST" class="space-y-6">
                                @csrf
                                <div>
                                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">@if(app()->getLocale() == 'uk') Оцінка @elseif(app()->getLocale() == 'en') Rating @else Bewertung @endif</label>
                                    <div class="flex space-x-3 text-3xl text-gray-800" x-data="{ rating: 0 }">
                                        <template x-for="i in 5">
                                            <i class="fas fa-star cursor-pointer transition duration-200" 
                                               :class="i <= rating ? 'text-yellow-400' : 'hover:text-yellow-200/50'"
                                               @click="rating = i"></i>
                                        </template>
                                        <input type="hidden" name="rating" :value="rating" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">@if(app()->getLocale() == 'uk') Ваш коментар @elseif(app()->getLocale() == 'en') Your Comment @else Ihr Kommentar @endif</label>
                                    <textarea name="comment" rows="5" class="w-full px-5 py-4 bg-gray-800 border-gray-700 rounded-xl text-white placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition" placeholder="@if(app()->getLocale() == 'uk') Поділіться вашими враженнями... @elseif(app()->getLocale() == 'en') Share your impressions... @else Teilen Sie Ihre Eindrücke... @endif"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-white text-gray-950 py-4 rounded-xl font-black hover:bg-gray-200 transition shadow-lg">@if(app()->getLocale() == 'uk') Надіслати відгук @elseif(app()->getLocale() == 'en') Submit Review @else Bewertung absenden @endif</button>
                            </form>
                        </div>
                    @else
                        <div class="review-login-card bg-indigo-900/20 p-10 rounded-3xl border border-indigo-500/20 text-center shadow-sm">
                            <p class="review-login-text text-indigo-200 font-bold text-lg mb-6 leading-relaxed">@if(app()->getLocale() == 'uk') Бажаєте поділитися своїм досвідом? @elseif(app()->getLocale() == 'en') Want to share your experience? @else Möchten Sie Ihre Erfahrung teilen? @endif</p>
                            <a href="{{ route('login') }}" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-xl font-black hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">@if(app()->getLocale() == 'uk') Увійти для відгуку @elseif(app()->getLocale() == 'en') Login to Review @else Anmelden für Bewertung @endif</a>
                        </div>
                    @endauth
                </div>

                <div class="lg:col-span-2 space-y-12">
                    @forelse($product->reviews as $review)
                        <div class="review-item pb-10 border-b border-gray-900 last:border-0">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl overflow-hidden border border-indigo-500/20 shadow-sm">
                                        @if($review->user->avatar)
                                            <img src="{{ asset('storage/' . $review->user->avatar) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-indigo-900/50 flex items-center justify-center text-indigo-400 font-black text-xl">
                                                ?
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white text-lg">{{ $review->user->name }}</h4>
                                        <p class="text-xs text-gray-600 font-bold uppercase tracking-widest">{{ $review->created_at->format('d.m.Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex text-yellow-400 text-sm gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-800' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-400 leading-relaxed text-lg italic">"{{ $review->comment }}"</p>
                        </div>
                    @empty
                        <div class="reviews-empty text-center py-20 bg-gray-900/50 rounded-3xl border border-gray-800/50">
                            <i class="fas fa-comments text-5xl text-gray-800 mb-6 block"></i>
                            <p class="reviews-empty-text text-gray-500 font-medium">@if(app()->getLocale() == 'uk') Ще немає відгуків. Будьте першим! @elseif(app()->getLocale() == 'en') No reviews yet. Be the first! @else Noch keine Bewertungen. Seien Sie der Erste! @endif</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
