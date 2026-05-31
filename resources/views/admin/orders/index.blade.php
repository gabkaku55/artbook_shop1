@extends('admin.dashboard')

@section('admin_content')
<div class="max-w-6xl mx-auto">
<div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">Керування замовленнями</h2>
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center gap-3">
        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Сортування</label>
        <select name="sort" onchange="this.form.submit()" class="bg-gray-800 border-gray-700 rounded-xl px-4 py-2.5 text-sm font-bold text-indigo-400 focus:ring-2 focus:ring-indigo-500 transition border outline-none cursor-pointer">
            <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Найновіші спочатку</option>
            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Найстаріші спочатку</option>
            <option value="bank" {{ request('sort') === 'bank' ? 'selected' : '' }}>За реквізитами</option>
            <option value="card" {{ request('sort') === 'card' ? 'selected' : '' }}>Онлайн-оплата</option>
            <option value="cod" {{ request('sort') === 'cod' ? 'selected' : '' }}>При отриманні</option>
        </select>
    </form>
</div>

<div class="bg-gray-900 rounded-[2rem] border border-gray-800 shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-gray-800/50 text-[10px] uppercase text-gray-500 font-black tracking-widest">
                <tr>
                    <th class="px-4 py-4">ID</th>
                    <th class="px-4 py-4">Покупець</th>
                    <th class="px-4 py-4 whitespace-nowrap">Сума</th>
                    <th class="px-4 py-4">Статус</th>
                    <th class="px-4 py-4 whitespace-nowrap">Оплата / Квитанція</th>
                    <th class="px-4 py-4 whitespace-nowrap">Вибір дії</th>
                    <th class="px-4 py-4 whitespace-nowrap">Дата</th>
                    <th class="px-4 py-4 text-right">Видалити</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/50 text-sm">
                @foreach($orders as $order)
                    @php
                        $pm = \App\Enums\OrderStatus::normalizePaymentMethod($order->payment_method);
                        $statusLabel = \App\Enums\OrderStatus::statusLabelByPayment($order->payment_method);
                        $paymentLabel = \App\Enums\OrderStatus::paymentLabel($order->payment_method);
                        $allowedStatuses = \App\Enums\OrderStatus::allowedStatusesByPayment($order->payment_method);
                        $resolvedStatus = \App\Enums\OrderStatus::resolveStatus($order->payment_method, $order->status);
                    @endphp
                    <tr class="hover:bg-gray-800/30 transition group">
                        <td class="px-4 py-4 font-black text-gray-600 whitespace-nowrap">#{{ $order->id }}</td>
                        <td class="px-4 py-4">
                            <p class="font-bold text-white">{{ $order->name }} {{ $order->last_name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->email }}</p>
                            <p class="text-xs text-gray-500">{{ $order->phone }}</p>
                        </td>
                        <td class="px-4 py-4 font-black text-white whitespace-nowrap">{{ number_format($order->total_price, 2) }} грн</td>
                        <td class="px-4 py-4">
                            @php
                                $statusColors = [
                                    'Оплачено' => 'bg-green-900/20 text-green-500 border-green-500/20',
                                    'Очікує' => 'bg-amber-900/20 text-amber-500 border-amber-500/20',
                                    'В обробці' => 'bg-indigo-900/20 text-indigo-500 border-indigo-500/20',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border {{ $statusColors[$statusLabel] ?? 'bg-gray-800 text-gray-400 border-gray-700' }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <p class="text-[10px] font-black uppercase text-gray-500 mb-1">{{ $paymentLabel }}</p>
                            @if($pm === 'bank')
                                @if($order->receipt_image)
                                    <a href="{{ asset('storage/' . $order->receipt_image) }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 font-bold text-xs flex items-center gap-1">
                                        <i class="fas fa-file-invoice"></i> Переглянути квитанцію
                                    </a>
                                @else
                                    <span class="text-gray-600 text-xs italic">Немає квитанції</span>
                                @endif
                            @endif
                        </td>
                        <td class="px-4 py-4 align-top">
                            <div class="flex flex-col gap-3">
                                @if(count($allowedStatuses) > 0)
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="bg-gray-800 border-gray-700 rounded-xl px-3 py-2 text-[10px] font-black uppercase text-indigo-400 focus:ring-2 focus:ring-indigo-500 transition border outline-none cursor-pointer">
                                            @foreach($allowedStatuses as $value => $label)
                                                <option value="{{ $value }}" {{ $resolvedStatus === $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                    <span class="text-gray-600 text-xs">—</span>
                                @endif

                                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-gray-800 text-gray-200 hover:bg-indigo-600 hover:text-white transition">
                                    <i class="fas fa-eye mr-2"></i> Переглянути
                                </a>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-gray-400 whitespace-nowrap">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td class="px-4 py-4 text-right">
                            <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('Ви впевнені? Замовлення буде приховано тільки з панелі адміна.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-gray-800 text-red-500 hover:bg-red-600 hover:text-white transition rounded-xl">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-8 py-8 border-t border-gray-800 bg-gray-800/20">
        {{ $orders->links() }}
    </div>
</div>
</div>
@endsection
