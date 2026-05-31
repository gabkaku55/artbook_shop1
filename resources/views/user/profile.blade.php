@extends('layouts.app')

@section('content')
<div class="page-profile py-12 bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-white mb-12 uppercase tracking-tighter">@if(app()->getLocale() == 'uk') Особистий кабінет @elseif(app()->getLocale() == 'en') Personal Profile @else Persönliches Profil @endif</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-gray-900 p-10 rounded-3xl border border-gray-800 shadow-xl text-center">
                    <div class="relative w-32 h-32 mx-auto mb-8">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full rounded-[2rem] object-cover border-4 border-indigo-600/30 shadow-lg">
                        @else
                            <div class="w-full h-full bg-indigo-900/50 rounded-[2rem] border border-indigo-500/20 flex items-center justify-center text-indigo-400 text-5xl font-black shadow-lg">
                                ?
                            </div>
                        @endif
                    </div>
                    <h2 class="text-2xl font-black text-white mb-2">{{ $user->name }}@if(!empty($user->last_name)) {{ $user->last_name }}@endif</h2>
                    <p class="text-gray-500 font-medium mb-6">{{ $user->email }}</p>
                    <div class="inline-block px-4 py-1.5 bg-gray-800 rounded-full text-[10px] font-black text-indigo-400 uppercase tracking-widest border border-indigo-500/20">
                        {{ $user->role === 'admin' ? __('messages.admin_panel') : (app()->getLocale() == 'uk' ? 'Користувач' : (app()->getLocale() == 'en' ? 'User' : 'Benutzer')) }}
                    </div>
                </div>

                <div class="bg-gray-900 p-10 rounded-3xl border border-gray-800 shadow-xl">
                    <h3 class="text-lg font-black text-white uppercase tracking-widest mb-8">@if(app()->getLocale() == 'uk') Редагувати профіль @elseif(app()->getLocale() == 'en') Edit Profile @else Profil bearbeiten @endif</h3>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">@if(app()->getLocale() == 'uk') Ім'я @elseif(app()->getLocale() == 'en') Name @else Name @endif</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">@if(app()->getLocale() == 'uk') Прізвище @elseif(app()->getLocale() == 'en') Last Name @else Nachname @endif</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">@if(app()->getLocale() == 'uk') Телефон @elseif(app()->getLocale() == 'en') Phone @else Telefon @endif</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+380..." class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">@if(app()->getLocale() == 'uk') Адреса проживання @elseif(app()->getLocale() == 'en') Home Address @else Wohnadresse @endif</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="@if(app()->getLocale() == 'uk') Вулиця, будинок, квартира @elseif(app()->getLocale() == 'en') Street, house, apartment @else Straße, Haus, Wohnung @endif" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-white focus:ring-2 focus:ring-indigo-500 transition border">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 ml-1">Avatar</label>
                            <input type="file" name="avatar" class="w-full bg-gray-800 border-gray-700 rounded-2xl px-6 py-4 text-gray-400 focus:ring-2 focus:ring-indigo-500 transition border text-xs">
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/20">
                            @if(app()->getLocale() == 'uk') Зберегти зміни @elseif(app()->getLocale() == 'en') Save Changes @else Änderungen speichern @endif
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-gray-900 rounded-3xl border border-gray-800 shadow-xl overflow-hidden">
                    <div class="px-10 py-8 border-b border-gray-800 flex items-center justify-between">
                        <h3 class="text-xl font-black text-white uppercase tracking-widest">@if(app()->getLocale() == 'uk') Історія замовлень @elseif(app()->getLocale() == 'en') Order History @else Bestellverlauf @endif</h3>
                        <div class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center text-gray-500">
                            <i class="fas fa-history"></i>
                        </div>
                    </div>
                    
                    @if($orders->isEmpty())
                        <div class="p-20 text-center text-gray-600">
                            <i class="fas fa-box-open text-5xl mb-6 block opacity-20"></i>
                            <p class="text-lg font-medium">@if(app()->getLocale() == 'uk') Ви ще не зробили жодного замовлення. @elseif(app()->getLocale() == 'en') You haven't made any orders yet. @else Sie haben noch keine Bestellungen aufgegeben. @endif</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse text-sm">
                                <thead class="bg-gray-800/50 text-[10px] uppercase text-gray-500 font-black tracking-widest">
                                    <tr>
                                        <th class="px-6 py-4 whitespace-nowrap">@if(app()->getLocale() == 'uk') Замовлення @elseif(app()->getLocale() == 'en') Order @else Bestellung @endif</th>
                                        <th class="px-6 py-4 whitespace-nowrap">@if(app()->getLocale() == 'uk') Дата @elseif(app()->getLocale() == 'en') Date @else Datum @endif</th>
                                        <th class="px-6 py-4 whitespace-nowrap">@if(app()->getLocale() == 'uk') Сума @elseif(app()->getLocale() == 'en') Amount @else Betrag @endif</th>
                                        <th class="px-6 py-4 whitespace-nowrap">@if(app()->getLocale() == 'uk') Статус @elseif(app()->getLocale() == 'en') Status @else Status @endif</th>
                                        <th class="px-6 py-4 text-right whitespace-nowrap">@if(app()->getLocale() == 'uk') Дія @elseif(app()->getLocale() == 'en') Action @else Aktion @endif</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-800/50 text-sm">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-800/30 transition">
                                            <td class="px-6 py-4 font-black text-white whitespace-nowrap">#{{ $order->id }}</td>
                                            <td class="px-6 py-4 text-gray-500 font-bold uppercase tracking-tighter whitespace-nowrap">{{ $order->created_at->format('d.m.Y') }}</td>
                                            <td class="px-6 py-4 font-black text-indigo-400 whitespace-nowrap">
                                                {{ session('currency', 'UAH') == 'USD' ? '$' . number_format($order->total_price, 2) : (session('currency') == 'EUR' ? '€' . number_format($order->total_price, 2) : number_format($order->total_price, 2) . ' грн') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $statusMap = [
                                                        'pending' => ['label' => (app()->getLocale() == 'uk' ? 'Очікує' : (app()->getLocale() == 'en' ? 'Pending' : 'Wartend')), 'class' => 'bg-amber-900/20 text-amber-500 border-amber-500/20'],
                                                        'paid' => ['label' => (app()->getLocale() == 'uk' ? 'Оплачено' : (app()->getLocale() == 'en' ? 'Paid' : 'Bezahlt')), 'class' => 'bg-green-900/20 text-green-500 border-green-500/20'],
                                                        'confirmed' => ['label' => (app()->getLocale() == 'uk' ? 'Підтверджено' : (app()->getLocale() == 'en' ? 'Confirmed' : 'Bestätigt')), 'class' => 'bg-indigo-900/20 text-indigo-500 border-indigo-500/20'],
                                                        'shipped' => ['label' => (app()->getLocale() == 'uk' ? 'Відправлено' : (app()->getLocale() == 'en' ? 'Shipped' : 'Versandt')), 'class' => 'bg-blue-900/20 text-blue-500 border-blue-500/20'],
                                                        'arrived' => ['label' => (app()->getLocale() == 'uk' ? 'Прибуло' : (app()->getLocale() == 'en' ? 'Arrived' : 'Angekommen')), 'class' => 'bg-purple-900/20 text-purple-500 border-purple-500/20'],
                                                        'cancelled' => ['label' => (app()->getLocale() == 'uk' ? 'Скасовано' : (app()->getLocale() == 'en' ? 'Cancelled' : 'Abgebrochen')), 'class' => 'bg-red-900/20 text-red-500 border-red-500/20'],
                                                    ];
                                                    $status = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'bg-gray-800 text-gray-400'];
                                                @endphp
                                                <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $status['class'] }} whitespace-nowrap">
                                                    {{ $status['label'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex flex-col items-end gap-2">
                                                    <a href="{{ route('order.show', $order->id) }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-gray-800 text-gray-200 hover:bg-indigo-600 hover:text-white text-[10px] font-black uppercase tracking-widest transition whitespace-nowrap">
                                                        <i class="fas fa-eye mr-2"></i>
                                                        @if(app()->getLocale() == 'uk') Деталі замовлення @elseif(app()->getLocale() == 'en') Order details @else Bestelldetails @endif
                                                    </a>

                                                    @if($order->status == 'pending')
                                                        <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="text-red-500 hover:text-red-400 font-black text-[10px] uppercase tracking-widest transition">
                                                                @if(app()->getLocale() == 'uk') Скасувати @elseif(app()->getLocale() == 'en') Cancel @else Abbrechen @endif
                                                            </button>
                                                        </form>
                                                    @elseif($order->status == 'paid' || $order->status == 'confirmed')
                                                         <span class="text-gray-600 text-[10px] font-black uppercase tracking-widest italic">
                                                            @if(app()->getLocale() == 'uk') Готується до відправки @elseif(app()->getLocale() == 'en') Preparing for shipping @else Versand wird vorbereitet @endif
                                                        </span>
                                                    @else
                                                        <span class="text-gray-800">—</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
