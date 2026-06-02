@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-white mb-12">@if(app()->getLocale() == 'uk') Ваш кошик @elseif(app()->getLocale() == 'en') Your Cart @else Ihr Warenkorb @endif</h1>

        @if(empty($cartItems))
            <div class="bg-gray-900 rounded-[2.5rem] p-20 text-center border border-gray-800 shadow-xl">
                <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-8 text-gray-600">
                    <i class="fas fa-shopping-basket text-4xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-white mb-4">@if(app()->getLocale() == 'uk') Ваш кошик порожній @elseif(app()->getLocale() == 'en') Your cart is empty @else Ihr Warenkorb ist leer @endif</h3>
                <p class="text-gray-500 mb-10 max-w-md mx-auto text-lg">@if(app()->getLocale() == 'uk') Схоже, ви ще нічого не додали. Час наповнити його шедеврами! @elseif(app()->getLocale() == 'en') It seems you haven't added anything yet. Time to fill it with masterpieces! @else Es scheint, Sie haben noch nichts hinzugefügt. Zeit, ihn mit Meisterwerken zu füllen! @endif</p>
                <a href="{{ route('catalog') }}" class="inline-block bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black text-lg hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/20">{{ __('messages.catalog') }}</a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-12">
                <div class="flex-grow space-y-6">
                    @foreach($cartItems as $id => $details)
                        <div class="bg-gray-900 p-8 rounded-3xl border border-gray-800 flex flex-col sm:flex-row items-center gap-8 shadow-sm hover:border-gray-700 transition" data-cart-item="{{ $id }}">
                            <div class="w-32 h-44 flex-shrink-0 bg-gray-800 rounded-2xl overflow-hidden shadow-lg border border-gray-700">
                                @if($details['image'])
                                    <img src="{{ \App\Support\MediaUrl::resolve($details['image']) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-700">
                                        <i class="fas fa-image text-3xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow text-center sm:text-left">
                                <a href="{{ route('product.show', $details['slug']) }}" class="text-2xl font-bold text-white hover:text-indigo-400 transition leading-tight">{{ $details['name'] }}</a>
                                <p class="text-indigo-400 font-black text-xl mt-3">{{ $details['formatted_price'] }}</p>
                            </div>
                            <div class="flex flex-col items-center min-w-[130px]">
                                <div class="flex items-center bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                                    <button type="button" class="px-3 py-2 text-lg text-gray-300 hover:text-white hover:bg-gray-700 transition cart-qty-btn" data-direction="down">
                                        −
                                    </button>
                                    <input
                                        type="number"
                                        min="1"
                                        max="{{ $details['stock'] }}"
                                        value="{{ $details['quantity'] }}"
                                        class="w-14 text-center bg-gray-800 text-white text-sm font-bold border-x border-gray-700 focus:outline-none focus:ring-0 cart-qty-input"
                                        data-id="{{ $id }}"
                                        data-stock="{{ $details['stock'] }}"
                                    >
                                    <button type="button" class="px-3 py-2 text-lg text-gray-300 hover:text-white hover:bg-gray-700 transition cart-qty-btn" data-direction="up">
                                        +
                                    </button>
                                </div>
                                <p class="text-xs text-red-400 mt-2 hidden cart-item-error">Більше немає на складі</p>
                            </div>
                            <div class="text-center sm:text-right min-w-[120px]">
                                <p class="text-2xl font-black text-white tracking-tight cart-item-total" data-id="{{ $id }}">
                                    {{ session('currency', 'UAH') == 'USD' ? '$' . number_format($details['price'] * $details['quantity'], 2) : (session('currency') == 'EUR' ? '€' . number_format($details['price'] * $details['quantity'], 2) : number_format($details['price'] * $details['quantity'], 2) . ' грн') }}
                                </p>
                            </div>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-12 h-12 flex items-center justify-center bg-red-900/20 text-red-500 hover:bg-red-500 hover:text-white transition rounded-xl">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="w-full lg:w-[400px]">
                    <div class="bg-gray-900 p-10 rounded-3xl border border-gray-800 shadow-xl sticky top-24">
                        <h3 class="text-2xl font-black text-white mb-10 tracking-tight uppercase">@if(app()->getLocale() == 'uk') Підсумок замовлення @elseif(app()->getLocale() == 'en') Order Summary @else Bestellübersicht @endif</h3>
                        <div class="space-y-6 text-gray-400 mb-10 pb-8 border-b border-gray-800">
                            <div class="flex justify-between text-lg font-medium">
                                <span>@if(app()->getLocale() == 'uk') Проміжна сума @elseif(app()->getLocale() == 'en') Subtotal @else Zwischensumme @endif</span>
                                <span class="text-white font-bold" id="cart-subtotal">
                                    {{ session('currency', 'UAH') == 'USD' ? '$' . number_format($subtotal, 2) : (session('currency') == 'EUR' ? '€' . number_format($subtotal, 2) : number_format($subtotal, 2) . ' грн') }}
                                </span>
                            </div>
                            <div class="flex justify-between text-lg font-medium">
                                <span>@if(app()->getLocale() == 'uk') Доставка @elseif(app()->getLocale() == 'en') Shipping @else Versand @endif</span>
                                <span class="{{ $shippingCost === 0 ? 'text-green-400' : 'text-white' }} font-bold" id="cart-shipping">
                                    {{ $shippingCost === 0 ? __('messages.free') : number_format($shippingCost, 0) . ' грн' }}
                                </span>
                            </div>
                            <p class="text-[10px] text-gray-600">@if(app()->getLocale() == 'uk') Безкоштовно при замовленні від 1000 грн @elseif(app()->getLocale() == 'en') Free shipping for orders over 1000 грн @else Kostenlos ab 1000 грн @endif</p>
                        </div>
                        <div class="flex justify-between text-3xl font-black text-white mb-12 tracking-tighter">
                            <span>@if(app()->getLocale() == 'uk') Разом @elseif(app()->getLocale() == 'en') Total @else Gesamt @endif</span>
                            <span class="text-indigo-400" id="cart-total">
                                {{ session('currency', 'UAH') == 'USD' ? '$' . number_format($total, 2) : (session('currency') == 'EUR' ? '€' . number_format($total, 2) : number_format($total, 2) . ' грн') }}
                            </span>
                        </div>
                        
                        @auth
                            <a href="{{ route('checkout') }}" class="block w-full bg-indigo-600 text-white text-center py-5 rounded-2xl font-black text-xl hover:bg-indigo-700 transition transform hover:scale-[1.02] shadow-xl shadow-indigo-500/20">@if(app()->getLocale() == 'uk') Оформити замовлення @elseif(app()->getLocale() == 'en') Checkout @else Kasse @endif</a>
                        @else
                            <div class="cart-guest-auth-prompt text-center bg-gray-800/50 p-6 rounded-2xl border border-gray-700">
                                <p class="cart-guest-auth-prompt__label text-sm text-gray-500 mb-6 font-bold uppercase tracking-widest">@if(app()->getLocale() == 'uk') Авторизуйтесь для покупки @elseif(app()->getLocale() == 'en') Authorize to purchase @else Zum Kaufen autorisieren @endif</p>
                                <a href="{{ route('login') }}" class="block w-full bg-white text-gray-950 py-4 rounded-xl font-black text-lg hover:bg-gray-200 transition">{{ __('messages.login') }}</a>
                            </div>
                        @endauth
                        
                        <a href="{{ route('catalog') }}" class="block text-center text-sm font-black text-gray-600 mt-8 hover:text-indigo-400 transition uppercase tracking-widest">@if(app()->getLocale() == 'uk') Продовжити покупки @elseif(app()->getLocale() == 'en') Continue Shopping @else Weiter shoppen @endif</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@php
    $cartCurrency = session('currency', 'UAH');
@endphp

<script>
    const CART_UPDATE_URL = "{{ route('cart.update') }}";
    const CART_CSRF = "{{ csrf_token() }}";
    const CART_CURRENCY = "{{ $cartCurrency }}";

    function formatCurrency(value) {
        const amount = Number(value) || 0;
        if (CART_CURRENCY === 'USD') {
            return '$' + amount.toFixed(2);
        }
        if (CART_CURRENCY === 'EUR') {
            return '€' + amount.toFixed(2);
        }
        return amount.toFixed(2) + ' грн';
    }

    function updateCartTotalsFromResponse(id, data) {
        const itemTotalEl = document.querySelector(`.cart-item-total[data-id="${id}"]`);
        if (itemTotalEl && typeof data.item_total !== 'undefined') {
            itemTotalEl.textContent = formatCurrency(data.item_total);
        }

        const subtotalEl = document.getElementById('cart-subtotal');
        if (subtotalEl && typeof data.subtotal !== 'undefined') {
            subtotalEl.textContent = formatCurrency(data.subtotal);
        }

        const shippingEl = document.getElementById('cart-shipping');
        if (shippingEl && typeof data.shipping !== 'undefined') {
            shippingEl.textContent = data.shipping === 0 ? "{{ __('messages.free') }}" : formatCurrency(data.shipping);
        }

        const totalEl = document.getElementById('cart-total');
        if (totalEl && typeof data.total !== 'undefined') {
            totalEl.textContent = formatCurrency(data.total);
        }
    }

    function attachCartHandlers() {
        const inputs = document.querySelectorAll('.cart-qty-input');
        const buttons = document.querySelectorAll('.cart-qty-btn');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const direction = btn.dataset.direction;
                const wrapper = btn.closest('[data-cart-item]');
                const input = wrapper.querySelector('.cart-qty-input');
                const errorEl = wrapper.querySelector('.cart-item-error');
                const stock = parseInt(input.dataset.stock, 10) || 0;
                let value = parseInt(input.value, 10) || 1;

                errorEl.classList.add('hidden');

                if (direction === 'up') {
                    if (value >= stock) {
                        errorEl.textContent = 'Більше немає на складі';
                        errorEl.classList.remove('hidden');
                        return;
                    }
                    value += 1;
                } else {
                    value = Math.max(1, value - 1);
                }

                input.value = value;
                sendQuantityUpdate(input, errorEl);
            });
        });

        inputs.forEach(input => {
            const wrapper = input.closest('[data-cart-item]');
            const errorEl = wrapper.querySelector('.cart-item-error');

            input.addEventListener('change', () => {
                const stock = parseInt(input.dataset.stock, 10) || 0;
                let value = parseInt(input.value, 10) || 1;

                errorEl.classList.add('hidden');

                if (value < 1) value = 1;
                if (value > stock) {
                    value = stock;
                    errorEl.textContent = 'Більше немає на складі';
                    errorEl.classList.remove('hidden');
                }
                input.value = value;
                sendQuantityUpdate(input, errorEl);
            });
        });
    }

    function sendQuantityUpdate(input, errorEl) {
        const id = input.dataset.id;
        const quantity = input.value;

        fetch(CART_UPDATE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                'X-CSRF-TOKEN': CART_CSRF,
                'Accept': 'application/json',
            },
            body: new URLSearchParams({ id, quantity })
        })
            .then(async response => {
                const data = await response.json().catch(() => ({}));

                if (!response.ok || !data.success) {
                    if (data && data.message && errorEl) {
                        errorEl.textContent = data.message;
                        errorEl.classList.remove('hidden');
                    }
                    return;
                }

                updateCartTotalsFromResponse(id, data);
            })
            .catch(() => {
                if (errorEl) {
                    errorEl.textContent = 'Не вдалося оновити кошик. Спробуйте ще раз.';
                    errorEl.classList.remove('hidden');
                }
            });
    }

    document.addEventListener('DOMContentLoaded', attachCartHandlers);
</script>
@endsection
