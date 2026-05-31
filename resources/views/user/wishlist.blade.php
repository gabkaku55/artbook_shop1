@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-white mb-12 uppercase tracking-tighter">{{ __('messages.wishlist') }}</h1>

        @if($wishlistItems->isEmpty())
            <div class="bg-gray-900 rounded-[2.5rem] p-20 text-center border border-gray-800 shadow-2xl">
                <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-8 text-gray-700 border border-gray-700">
                    <i class="far fa-heart text-4xl"></i>
                </div>
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-4">Ваш список бажаного порожній</h3>
                <p class="text-gray-500 mb-10 max-w-sm mx-auto">Додавайте артбуки, які вам сподобалися, щоб не загубити їх та купити пізніше.</p>
                <a href="{{ route('catalog') }}" class="inline-block bg-indigo-600 text-white px-10 py-5 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/20">
                    Перейти до каталогу
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($wishlistItems as $item)
                    <div class="bg-gray-900 rounded-3xl border border-gray-800 overflow-hidden shadow-xl hover:border-indigo-500/30 transition duration-300 flex flex-col group">
                        <div class="relative aspect-[3/4]">
                            <a href="{{ route('product.show', $item->product->slug) }}" class="block w-full h-full overflow-hidden">
                                @if($item->product->image_url)
                                    <img src="{{ $item->product->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $item->product->translated_name }}">
                                @endif
                            </a>
                            <form action="{{ route('wishlist.remove', $item->product->id) }}" method="POST" class="absolute top-4 right-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 bg-gray-900/80 backdrop-blur-md rounded-xl flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition shadow-lg">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                        <div class="p-8 flex flex-col flex-grow">
                            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-2">{{ $item->product->category->translated_name }}</span>
                            <a href="{{ route('product.show', $item->product->slug) }}">
                                <h3 class="text-xl font-bold text-white mb-2 truncate group-hover:text-indigo-400 transition">{{ $item->product->translated_name }}</h3>
                            </a>
                            <p class="text-gray-500 text-sm mb-6">{{ $item->product->translated_author }}</p>
                            
                            <div class="mt-auto flex justify-between items-center pt-6 border-t border-gray-800">
                                <span class="text-2xl font-black text-white">{{ $item->product->formatted_price }}</span>
                                <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-indigo-600 text-white p-4 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
