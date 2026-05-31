@extends('layouts.app')

@section('content')
@php
    $itemsTotal = $order->items->sum(function ($item) {
        return $item->price * $item->quantity;
    });
    $hasDiscount = $itemsTotal > 0 && $order->discount_amount > 0;
    $discountFactor = $hasDiscount ? ($itemsTotal - $order->discount_amount) / $itemsTotal : null;

    $statusMap = [
        'pending' => [
            'label' => (app()->getLocale() == 'uk' ? 'Очікує' : (app()->getLocale() == 'en' ? 'Pending' : 'Wartend')),
            'class' => 'bg-amber-900/20 text-amber-500 border-amber-500/20',
        ],
        'paid' => [
            'label' => (app()->getLocale() == 'uk' ? 'Оплачено' : (app()->getLocale() == 'en' ? 'Paid' : 'Bezahlt')),
            'class' => 'bg-green-900/20 text-green-500 border-green-500/20',
        ],
        'confirmed' => [
            'label' => (app()->getLocale() == 'uk' ? 'Підтверджено' : (app()->getLocale() == 'en' ? 'Confirmed' : 'Bestätigt')),
            'class' => 'bg-indigo-900/20 text-indigo-500 border-indigo-500/20',
        ],
        'shipped' => [
            'label' => (app()->getLocale() == 'uk' ? 'Відправлено' : (app()->getLocale() == 'en' ? 'Shipped' : 'Versandt')),
            'class' => 'bg-blue-900/20 text-blue-500 border-blue-500/20',
        ],
        'arrived' => [
            'label' => (app()->getLocale() == 'uk' ? 'Прибуло' : (app()->getLocale() == 'en' ? 'Arrived' : 'Angekommen')),
            'class' => 'bg-purple-900/20 text-purple-500 border-purple-500/20',
        ],
        'cancelled' => [
            'label' => (app()->getLocale() == 'uk' ? 'Скасовано' : (app()->getLocale() == 'en' ? 'Cancelled' : 'Abgebrochen')),
            'class' => 'bg-red-900/20 text-red-500 border-red-500/20',
        ],
    ];
    $status = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-800 text-gray-400 border-gray-700'];
@endphp

<div class="py-12 bg-gray-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-white mb-2 uppercase tracking-tighter">
                    @if(app()->getLocale() == 'uk') Деталі замовлення @elseif(app()->getLocale() == 'en') Order Details @else Bestelldetails @endif
                </h1>
                <p class="text-gray-500 text-sm">
                    @if(app()->getLocale() == 'uk') Замовлення @elseif(app()->getLocale() == 'en') Order @else Bestellung @endif
                    <span class="font-bold text-white">#{{ $order->id }}</span>
                    · {{ $order->created_at->format('d.m.Y H:i') }}
                </p>
            </div>
            <a href="{{ route('profile') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-gray-900 border border-gray-800 text-gray-200 hover:bg-gray-800 transition text-sm font-bold">
                <i class="fas fa-arrow-left mr-2"></i>
                @if(app()->getLocale() == 'uk') Повернутися до профілю @elseif(app()->getLocale() == 'en') Back to profile @else Zurück zum Profil @endif
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <div class="bg-gray-900 rounded-3xl border border-gray-800 p-8 shadow-xl space-y-4 lg:col-span-2">
                <h3 class="text-lg font-black text-white uppercase tracking-widest mb-4">
                    @if(app()->getLocale() == 'uk') Інформація про замовлення @elseif(app()->getLocale() == 'en') Order Information @else Bestellinformationen @endif
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">
                            @if(app()->getLocale() == 'uk') ID замовлення @elseif(app()->getLocale() == 'en') Order ID @else Bestell-ID @endif
                        </p>
                        <p class="text-white font-bold">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">
                            @if(app()->getLocale() == 'uk') Дата створення @elseif(app()->getLocale() == 'en') Created at @else Erstelldatum @endif
                        </p>
                        <p class="text-white font-bold">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">
                            @if(app()->getLocale() == 'uk') Статус замовлення @elseif(app()->getLocale() == 'en') Order status @else Bestellstatus @endif
                        </p>
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">
                            @if(app()->getLocale() == 'uk') Спосіб оплати @elseif(app()->getLocale() == 'en') Payment method @else Zahlungsmethode @endif
                        </p>
                        <p class="text-white font-bold">
                            {{ \App\Enums\OrderStatus::paymentLabel($order->payment_method) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">
                            @if(app()->getLocale() == 'uk') Спосіб доставки @elseif(app()->getLocale() == 'en') Shipping method @else Versandart @endif
                        </p>
                        <p class="text-white font-bold">{{ \App\Enums\ShippingMethod::label($order->shipping_method) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 rounded-3xl border border-gray-800 p-8 shadow-xl space-y-4">
                <h3 class="text-lg font-black text-white uppercase tracking-widest mb-4">
                    @if(app()->getLocale() == 'uk') Дані покупця @elseif(app()->getLocale() == 'en') Customer details @else Kundendaten @endif
                </h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">
                            @if(app()->getLocale() == 'uk') Імʼя @elseif(app()->getLocale() == 'en') Name @else Name @endif
                        </p>
                        <p class="text-white font-bold">{{ $order->name }} {{ $order->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Email</p>
                        <p class="text-indigo-400 font-bold">{{ $order->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">
                            @if(app()->getLocale() == 'uk') Телефон @elseif(app()->getLocale() == 'en') Phone @else Telefon @endif
                        </p>
                        <p class="text-white font-bold">{{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">
                            @if(app()->getLocale() == 'uk') Адреса @elseif(app()->getLocale() == 'en') Address @else Adresse @endif
                        </p>
                        <p class="text-gray-200 font-medium">{{ $order->address }}, {{ $order->zip_code }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-900 rounded-3xl border border-gray-800 shadow-xl overflow-hidden mb-10">
            <div class="px-8 py-6 border-b border-gray-800 flex items-center justify-between">
                <h3 class="text-lg font-black text-white uppercase tracking-widest">
                    @if(app()->getLocale() == 'uk') Товари у замовленні @elseif(app()->getLocale() == 'en') Items in order @else Artikel in der Bestellung @endif
                </h3>
                @if($hasDiscount)
                    <span class="text-xs font-black text-green-400 uppercase tracking-widest">
                        @if(app()->getLocale() == 'uk') Застосовано знижку @elseif(app()->getLocale() == 'en') Discount applied @else Rabatt angewendet @endif
                    </span>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-800/50 text-[10px] uppercase text-gray-500 font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-4">
                                @if(app()->getLocale() == 'uk') Товар @elseif(app()->getLocale() == 'en') Product @else Produkt @endif
                            </th>
                            <th class="px-8 py-4">
                                @if(app()->getLocale() == 'uk') Кількість @elseif(app()->getLocale() == 'en') Quantity @else Menge @endif
                            </th>
                            <th class="px-8 py-4">
                                @if(app()->getLocale() == 'uk') Ціна за одиницю @elseif(app()->getLocale() == 'en') Unit price @else Einzelpreis @endif
                            </th>
                            <th class="px-8 py-4">
                                @if(app()->getLocale() == 'uk') Ціна зі знижкою @elseif(app()->getLocale() == 'en') Discounted price @else Preis mit Rabatt @endif
                            </th>
                            <th class="px-8 py-4 text-right">
                                @if(app()->getLocale() == 'uk') Сума @elseif(app()->getLocale() == 'en') Total @else Summe @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50 text-sm">
                        @foreach($order->items as $item)
                            @php
                                $unitPrice = $item->price;
                                $discountedUnit = $discountFactor ? $unitPrice * $discountFactor : null;
                                $lineTotal = $discountFactor ? $discountedUnit * $item->quantity : $unitPrice * $item->quantity;
                            @endphp
                            <tr class="hover:bg-gray-800/30 transition">
                                <td class="px-8 py-5">
                                    <p class="font-bold text-white">
                                        @if($item->product)
                                            <a href="{{ route('product.show', $item->product->slug) }}" class="hover:text-indigo-400 transition">
                                                {{ $item->product->translated_name ?? $item->product->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">
                                                @if(app()->getLocale() == 'uk') Товар недоступний @elseif(app()->getLocale() == 'en') Product unavailable @else Produkt nicht verfügbar @endif
                                            </span>
                                        @endif
                                    </p>
                                </td>
                                <td class="px-8 py-5 font-bold text-white">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-8 py-5 text-gray-200">
                                    {{ number_format($unitPrice, 2) }} грн
                                </td>
                                <td class="px-8 py-5 text-gray-200">
                                    @if($discountedUnit)
                                        {{ number_format($discountedUnit, 2) }} грн
                                    @else
                                        <span class="text-gray-600 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right font-black text-white">
                                    {{ number_format($lineTotal, 2) }} грн
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-gray-900 rounded-3xl border border-gray-800 p-8 shadow-xl max-w-xl ml-auto">
            <h3 class="text-lg font-black text-white uppercase tracking-widest mb-4">
                @if(app()->getLocale() == 'uk') Підсумок замовлення @elseif(app()->getLocale() == 'en') Order summary @else Bestellübersicht @endif
            </h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400">
                        @if(app()->getLocale() == 'uk') Сума товарів (без знижки) @elseif(app()->getLocale() == 'en') Items total (before discount) @else Artikelsumme (ohne Rabatt) @endif
                    </span>
                    <span class="text-white font-bold">{{ number_format($itemsTotal, 2) }} грн</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">
                        @if(app()->getLocale() == 'uk') Знижка @elseif(app()->getLocale() == 'en') Discount @else Rabatt @endif
                    </span>
                    <span class="text-green-400 font-bold">-{{ number_format($order->discount_amount, 2) }} грн</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">
                        @if(app()->getLocale() == 'uk') Доставка @elseif(app()->getLocale() == 'en') Shipping @else Versand @endif
                    </span>
                    <span class="text-white font-bold">{{ number_format($order->shipping_cost, 2) }} грн</span>
                </div>
                <div class="border-t border-gray-800 pt-3 mt-3 flex justify-between items-center">
                    <span class="text-gray-400 text-sm uppercase tracking-widest">
                        @if(app()->getLocale() == 'uk') До сплати @elseif(app()->getLocale() == 'en') Total @else Gesamt @endif
                    </span>
                    <span class="text-2xl font-black text-indigo-400">{{ number_format($order->total_price, 2) }} грн</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

