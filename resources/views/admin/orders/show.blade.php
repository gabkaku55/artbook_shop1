@extends('admin.dashboard')

@section('admin_content')
@php
    $itemsTotal = $order->items->sum(function ($item) {
        return $item->price * $item->quantity;
    });
    $hasDiscount = $itemsTotal > 0 && $order->discount_amount > 0;
    $discountFactor = $hasDiscount ? ($itemsTotal - $order->discount_amount) / $itemsTotal : null;

    $statusLabel = \App\Enums\OrderStatus::statusLabelByPayment($order->payment_method);
    $paymentLabel = \App\Enums\OrderStatus::paymentLabel($order->payment_method);
@endphp

<div class="max-w-5xl mx-auto">

<div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
    <div>
        <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Замовлення #{{ $order->id }}</h2>
        <p class="text-gray-500 text-sm mt-2">{{ $order->created_at->format('d.m.Y H:i') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-5 py-3 rounded-2xl bg-gray-800 text-gray-200 hover:bg-gray-700 transition text-sm font-bold">
        <i class="fas fa-arrow-left mr-2"></i> Повернутися до списку
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
    <div class="bg-gray-900 rounded-3xl border border-gray-800 p-8 shadow-xl space-y-4 lg:col-span-2">
        <h3 class="text-lg font-black text-white uppercase tracking-widest mb-4">Інформація про замовлення</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">ID замовлення</p>
                <p class="text-white font-bold">#{{ $order->id }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Дата створення</p>
                <p class="text-white font-bold">{{ $order->created_at->format('d.m.Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Статус замовлення</p>
                @php
                    $statusColors = [
                        'Оплачено' => 'bg-green-900/20 text-green-500 border-green-500/20',
                        'Очікує' => 'bg-amber-900/20 text-amber-500 border-amber-500/20',
                        'В обробці' => 'bg-indigo-900/20 text-indigo-500 border-indigo-500/20',
                    ];
                @endphp
                <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $statusColors[$statusLabel] ?? 'bg-gray-800 text-gray-400 border-gray-700' }}">
                    {{ $statusLabel }}
                </span>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Спосіб оплати</p>
                <p class="text-white font-bold">{{ $paymentLabel }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Спосіб доставки</p>
                <p class="text-white font-bold">{{ \App\Enums\ShippingMethod::label($order->shipping_method) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-900 rounded-3xl border border-gray-800 p-8 shadow-xl space-y-4">
        <h3 class="text-lg font-black text-white uppercase tracking-widest mb-4">Дані покупця</h3>
        <div class="space-y-2 text-sm">
            <div>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Імʼя</p>
                <p class="text-white font-bold">{{ $order->name }} {{ $order->last_name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Email</p>
                <p class="text-indigo-400 font-bold">{{ $order->email }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Телефон</p>
                <p class="text-white font-bold">{{ $order->phone }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest mb-1">Адреса</p>
                <p class="text-gray-200 font-medium">{{ $order->address }}, {{ $order->zip_code }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-900 rounded-3xl border border-gray-800 shadow-xl overflow-hidden mb-10">
    <div class="px-8 py-6 border-b border-gray-800 flex items-center justify-between">
        <h3 class="text-lg font-black text-white uppercase tracking-widest">Товари у замовленні</h3>
        @if($hasDiscount)
            <span class="text-xs font-black text-green-400 uppercase tracking-widest">
                Застосовано знижку на замовлення
            </span>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-800/50 text-[10px] uppercase text-gray-500 font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Товар</th>
                    <th class="px-8 py-4">Кількість</th>
                    <th class="px-8 py-4">Ціна за одиницю</th>
                    <th class="px-8 py-4">Ціна зі знижкою</th>
                    <th class="px-8 py-4 text-right">Сума по товару</th>
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
                                    <span class="text-gray-400 italic">Товар недоступний</span>
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
    <h3 class="text-lg font-black text-white uppercase tracking-widest mb-4">Підсумок замовлення</h3>
    <div class="space-y-2 text-sm">
        <div class="flex justify-between">
            <span class="text-gray-400">Сума товарів (без знижки)</span>
            <span class="text-white font-bold">{{ number_format($itemsTotal, 2) }} грн</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-400">Знижка</span>
            <span class="text-green-400 font-bold">-{{ number_format($order->discount_amount, 2) }} грн</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-400">Доставка</span>
            <span class="text-white font-bold">{{ number_format($order->shipping_cost, 2) }} грн</span>
        </div>
        <div class="border-t border-gray-800 pt-3 mt-3 flex justify-between items-center">
            <span class="text-gray-400 text-sm uppercase tracking-widest">До сплати</span>
            <span class="text-2xl font-black text-indigo-400">{{ number_format($order->total_price, 2) }} грн</span>
        </div>
    </div>
</div>

</div>
@endsection

