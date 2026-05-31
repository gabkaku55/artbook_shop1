@extends('layouts.app')

@section('content')
@php
    $cartLinkLabel = app()->getLocale() == 'uk' ? 'Перейти до кошика' : (app()->getLocale() == 'en' ? 'Go to cart' : 'Zum Warenkorb');
@endphp
<div class="page-checkout py-12 bg-gray-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <h1 class="text-4xl font-black text-white text-center sm:text-left uppercase tracking-tighter">
                @if(app()->getLocale() == 'uk') Оформлення замовлення @elseif(app()->getLocale() == 'en') Checkout @else Kasse @endif
            </h1>
            <a href="{{ route('cart.index') }}" class="group mx-auto sm:mx-0 inline-flex items-center gap-2 self-center sm:self-auto text-xs font-black uppercase tracking-[0.18em] text-gray-500 hover:text-indigo-400 transition-colors">
                <span class="order-2 sm:order-1">{{ $cartLinkLabel }}</span>
                <span class="order-1 sm:order-2 flex h-10 w-10 items-center justify-center rounded-full border border-gray-800 bg-gray-900/80 text-gray-400 shadow-sm group-hover:border-indigo-500/40 group-hover:bg-indigo-950/30 group-hover:text-indigo-400 transition-all" aria-hidden="true">
                    <i class="fas fa-shopping-basket text-sm"></i>
                </span>
            </a>
        </div>

        <div class="max-w-5xl mx-auto" x-data="{
            shippingMethod: 'Nova Poshta',
            subtotal: {{ $subtotal }},
            discountAmount: {{ $discountAmount }},
            shippingNovaPoshta: {{ $shippingNovaPoshta }},
            shippingUkrposhta: {{ $shippingUkrposhta }},
            get shippingCost() {
                return this.shippingMethod === 'Ukrposhta' ? this.shippingUkrposhta : this.shippingNovaPoshta;
            },
            get total() {
                return this.subtotal - this.discountAmount + this.shippingCost;
            }
        }">
            <form action="{{ route('checkout') }}" method="POST" class="flex flex-col lg:flex-row gap-12">
                @csrf
                <div class="w-full lg:w-2/3 space-y-10">
                    <div class="bg-gray-900 p-10 rounded-3xl border border-gray-800 shadow-xl">
                        <h3 class="text-2xl font-bold text-white mb-10 flex items-center">
                            <div class="w-10 h-10 bg-indigo-900/50 text-indigo-400 rounded-xl flex items-center justify-center mr-4 border border-indigo-500/20">
                                <i class="fas fa-user"></i>
                            </div>
                            @if(app()->getLocale() == 'uk') Дані покупця @elseif(app()->getLocale() == 'en') Customer Details @else Kundendaten @endif
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">@if(app()->getLocale() == 'uk') Ім'я @elseif(app()->getLocale() == 'en') First Name @else Vorname @endif</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" class="w-full px-5 py-4 bg-gray-800 border-gray-700 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror" required>
                                @error('name') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">@if(app()->getLocale() == 'uk') Прізвище @elseif(app()->getLocale() == 'en') Last Name @else Nachname @endif</label>
                                <input type="text" name="last_name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" class="w-full px-5 py-4 bg-gray-800 border-gray-700 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('last_name') border-red-500 @enderror" required>
                                @error('last_name') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">Email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full px-5 py-4 bg-gray-800 border-gray-700 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror" required>
                                @error('email') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">@if(app()->getLocale() == 'uk') Номер телефону @elseif(app()->getLocale() == 'en') Phone Number @else Telefonnummer @endif</label>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="+380..." class="w-full px-5 py-4 bg-gray-800 border-gray-700 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('phone') border-red-500 @enderror" required>
                                @error('phone') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-900 p-10 rounded-3xl border border-gray-800 shadow-xl">
                        <h3 class="text-2xl font-bold text-white mb-10 flex items-center">
                            <div class="checkout-delivery-heading-icon w-10 h-10 bg-pink-900/50 text-pink-400 rounded-xl flex items-center justify-center mr-4 border border-pink-500/20">
                                <i class="fas fa-truck"></i>
                            </div>
                            @if(app()->getLocale() == 'uk') Доставка @elseif(app()->getLocale() == 'en') Shipping @else Versand @endif
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">@if(app()->getLocale() == 'uk') Адреса @elseif(app()->getLocale() == 'en') Address @else Adresse @endif</label>
                                <input type="text" name="address" value="{{ old('address', auth()->user()->address ?? '') }}" class="w-full px-5 py-4 bg-gray-800 border-gray-700 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('address') border-red-500 @enderror" required>
                                @error('address') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">@if(app()->getLocale() == 'uk') Поштовий індекс @elseif(app()->getLocale() == 'en') Zip Code @else Postleitzahl @endif</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code') }}" class="w-full px-5 py-4 bg-gray-800 border-gray-700 rounded-xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition @error('zip_code') border-red-500 @enderror" required>
                                @error('zip_code') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="space-y-4" @change="shippingMethod = $event.target.value">
                            <label class="flex items-center p-6 bg-gray-800 border-2 border-transparent rounded-2xl cursor-pointer hover:border-indigo-500/50 transition has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-950/20 group">
                                <input type="radio" name="shipping_method" value="Nova Poshta" class="w-5 h-5 text-indigo-600 bg-gray-700 border-gray-600 focus:ring-indigo-500" required checked>
                                <div class="ml-6">
                                    <span class="block text-lg font-black text-white group-hover:text-indigo-400 transition">Нова Пошта</span>
                                    <span class="text-sm text-gray-500 font-medium">@if(app()->getLocale() == 'uk') 1-3 робочі дні @elseif(app()->getLocale() == 'en') 1-3 business days @else 1-3 Werktage @endif • {{ $shippingNovaPoshta === 0 ? __('messages.free') : $shippingNovaPoshta . ' грн' }}</span>
                                </div>
                            </label>
                            <label class="flex items-center p-6 bg-gray-800 border-2 border-transparent rounded-2xl cursor-pointer hover:border-indigo-500/50 transition has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-950/20 group">
                                <input type="radio" name="shipping_method" value="Ukrposhta" class="w-5 h-5 text-indigo-600 bg-gray-700 border-gray-600 focus:ring-indigo-500">
                                <div class="ml-6">
                                    <span class="block text-lg font-black text-white group-hover:text-indigo-400 transition">Укрпошта</span>
                                    <span class="text-sm text-gray-500 font-medium">@if(app()->getLocale() == 'uk') 3-7 робочих днів @elseif(app()->getLocale() == 'en') 3-7 business days @else 3-7 Werktage @endif • {{ $shippingUkrposhta === 0 ? __('messages.free') : $shippingUkrposhta . ' грн' }}</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-gray-900 p-10 rounded-3xl border border-gray-800 shadow-xl">
                        <h3 class="text-2xl font-bold text-white mb-10 flex items-center">
                            <div class="w-10 h-10 bg-amber-900/50 text-amber-400 rounded-xl flex items-center justify-center mr-4 border border-amber-500/20">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            @if(app()->getLocale() == 'uk') Оплата @elseif(app()->getLocale() == 'en') Payment @else Zahlung @endif
                        </h3>
                        <div class="space-y-4">
                            <label class="flex items-center p-6 bg-gray-800 border-2 border-transparent rounded-2xl cursor-pointer hover:border-indigo-500/50 transition has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-950/20 group">
                                <input type="radio" name="payment_method" value="online" class="w-5 h-5 text-indigo-600 bg-gray-700 border-gray-600 focus:ring-indigo-500" required checked>
                                <div class="ml-6">
                                    <span class="block text-lg font-black text-white group-hover:text-indigo-400 transition">@if(app()->getLocale() == 'uk') Онлайн-оплата @elseif(app()->getLocale() == 'en') Online Payment @else Online-Zahlung @endif</span>
                                    <span class="text-sm text-gray-500 font-medium">Visa, Mastercard</span>
                                </div>
                            </label>
                            <label class="flex items-center p-6 bg-gray-800 border-2 border-transparent rounded-2xl cursor-pointer hover:border-indigo-500/50 transition has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-950/20 group">
                                <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-indigo-600 bg-gray-700 border-gray-600 focus:ring-indigo-500">
                                <div class="ml-6">
                                    <span class="block text-lg font-black text-white group-hover:text-indigo-400 transition">@if(app()->getLocale() == 'uk') Накладений платіж @elseif(app()->getLocale() == 'en') Cash on Delivery @else Nachnahme @endif</span>
                                    <span class="text-sm text-gray-500 font-medium">Оплата при отриманні</span>
                                </div>
                            </label>
                            <label class="flex items-center p-6 bg-gray-800 border-2 border-transparent rounded-2xl cursor-pointer hover:border-indigo-500/50 transition has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-950/20 group">
                                <input type="radio" name="payment_method" value="bank" class="w-5 h-5 text-indigo-600 bg-gray-700 border-gray-600 focus:ring-indigo-500">
                                <div class="ml-6">
                                    <span class="block text-lg font-black text-white group-hover:text-indigo-400 transition">@if(app()->getLocale() == 'uk') Оплата за реквізитами @elseif(app()->getLocale() == 'en') Bank Transfer @else Banküberweisung @endif</span>
                                    <span class="text-sm text-gray-500 font-medium">Переказ на IBAN</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-gray-900 p-10 rounded-3xl border border-gray-800 shadow-2xl sticky top-24">
                        <h3 class="text-xl font-black text-white mb-8 tracking-widest uppercase border-b border-gray-800 pb-6">@if(app()->getLocale() == 'uk') Ваше замовлення @elseif(app()->getLocale() == 'en') Your Order @else Ihre Bestellung @endif</h3>
                        <div class="space-y-6 mb-10 max-h-[300px] overflow-y-auto pr-4 custom-scrollbar">
                            @foreach($cartItems as $id => $details)
                                <div class="flex justify-between items-start gap-4">
                                    <span class="text-gray-400 text-sm font-medium leading-relaxed flex-grow">{{ $details['name'] }} <span class="text-gray-600 font-black ml-1">x {{ $details['quantity'] }}</span></span>
                                    <span class="text-white font-black text-sm whitespace-nowrap">
                                        {{ session('currency', 'UAH') == 'USD' ? '$' . number_format($details['price'] * $details['quantity'], 2) : (session('currency') == 'EUR' ? '€' . number_format($details['price'] * $details['quantity'], 2) : number_format($details['price'] * $details['quantity'], 2) . ' грн') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="space-y-4 border-t border-gray-800 pt-8 mb-10">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">@if(app()->getLocale() == 'uk') Проміжна сума @elseif(app()->getLocale() == 'en') Subtotal @else Zwischensumme @endif</span>
                                <span class="text-white font-bold">
                                    {{ session('currency', 'UAH') == 'USD' ? '$' . number_format($subtotal, 2) : (session('currency') == 'EUR' ? '€' . number_format($subtotal, 2) : number_format($subtotal, 2) . ' грн') }}
                                </span>
                            </div>

                            @if($discountPercentage > 0)
                                <div class="flex justify-between items-center text-sm text-green-400 bg-green-950/20 p-3 rounded-lg border border-green-500/20">
                                    <div class="flex items-center">
                                        <i class="fas fa-tag mr-2 text-xs"></i>
                                        <span>@if(app()->getLocale() == 'uk') Ваша знижка @elseif(app()->getLocale() == 'en') Your Discount @else Ihr Rabatt @endif ({{ $discountPercentage }}%)</span>
                                    </div>
                                    <span class="font-bold">
                                        -{{ session('currency', 'UAH') == 'USD' ? '$' . number_format($discountAmount, 2) : (session('currency') == 'EUR' ? '€' . number_format($discountAmount, 2) : number_format($discountAmount, 2) . ' грн') }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">@if(app()->getLocale() == 'uk') Доставка @elseif(app()->getLocale() == 'en') Shipping @else Versand @endif</span>
                                <span class="text-white font-bold" x-text="shippingCost === 0 ? '{{ __('messages.free') }}' : shippingCost + ' грн'" :class="shippingCost === 0 ? 'text-green-400' : ''"></span>
                            </div>
                            <p class="text-[10px] text-gray-600">@if(app()->getLocale() == 'uk') Безкоштовно при замовленні від {{ $freeThreshold }} грн @elseif(app()->getLocale() == 'en') Free shipping for orders over {{ $freeThreshold }} грн @else Kostenloser Versand ab {{ $freeThreshold }} грн @endif</p>

                            <div class="flex justify-between items-end pt-4 border-t border-gray-800">
                                <span class="text-gray-500 font-black uppercase text-xs tracking-widest">@if(app()->getLocale() == 'uk') Разом @elseif(app()->getLocale() == 'en') Total @else Gesamt @endif</span>
                                <span class="text-3xl font-black text-indigo-400 tracking-tighter" x-text="Math.round(total * 100) / 100 + ' грн'"></span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-2xl font-black text-lg hover:bg-indigo-700 transition transform hover:scale-[1.02] shadow-xl shadow-indigo-500/20">
                            @if(app()->getLocale() == 'uk') Підтвердити замовлення @elseif(app()->getLocale() == 'en') Confirm Order @else Bestellung bestätigen @endif
                        </button>
                        <p class="text-[10px] text-gray-600 text-center mt-6 uppercase font-bold tracking-widest leading-relaxed">
                            @if(app()->getLocale() == 'uk') Натискаючи кнопку, ви погоджуєтесь з умовами оферти та політикою конфіденційності @elseif(app()->getLocale() == 'en') By clicking the button, you agree to the terms of the offer and privacy policy @else Mit dem Klicken auf die Schaltfläche erklären Sie sich mit den Angebotsbedingungen und der Datenschutzerklärung einverstanden @endif
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #374151; border-radius: 10px; }
</style>
@endsection
