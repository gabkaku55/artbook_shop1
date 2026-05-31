@extends('layouts.app')

@section('content')
@php
    $backLabel = app()->getLocale() == 'uk' ? 'До оформлення' : (app()->getLocale() == 'en' ? 'Back to checkout' : 'Zur Kasse');
    $checkoutAbandonUrl = route('checkout', ['abandon_bank' => 1]);
@endphp
<div class="py-20 bg-gray-950 min-h-screen flex items-center justify-center">
    <div class="max-w-xl w-full px-4 sm:px-0">
        <a href="{{ $checkoutAbandonUrl }}" class="group mb-4 inline-flex items-center gap-2.5 text-xs font-black uppercase tracking-[0.2em] text-gray-500 hover:text-indigo-400 transition-colors">
            <span class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-800 bg-gray-900/80 text-gray-400 shadow-sm group-hover:border-indigo-500/40 group-hover:bg-indigo-950/30 group-hover:text-indigo-400 transition-all" aria-hidden="true">
                <i class="fas fa-arrow-left text-sm"></i>
            </span>
            <span>{{ $backLabel }}</span>
        </a>

        <div class="relative overflow-hidden bg-gray-900 p-8 sm:p-10 rounded-[2rem] border border-gray-800 ring-1 ring-white/[0.04] shadow-2xl">
            <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-indigo-600/20 blur-3xl" aria-hidden="true"></div>

            <div class="relative">
                <h1 class="text-2xl font-bold text-white mb-4">{{ __('messages.bank_details_title') }}</h1>
                <p class="text-gray-400 text-sm mb-6">{{ __('messages.bank_details_desc') }}</p>

                <div class="bg-gray-800/50 p-4 rounded-xl border border-gray-700 text-left mb-6 space-y-2 text-sm">
                    <div><span class="text-gray-500">IBAN:</span> <span class="text-white">{{ $bankDetails['iban'] }}</span></div>
                    <div><span class="text-gray-500">@if(app()->getLocale() == 'uk') Отримувач @elseif(app()->getLocale() == 'en') Payee @else Empfänger @endif:</span> <span class="text-white">{{ $bankDetails['receiver'] }}</span></div>
                    <div><span class="text-gray-500">ЄДРПОУ:</span> <span class="text-white">{{ $bankDetails['edrpou'] }}</span></div>
                    <div><span class="text-gray-500">@if(app()->getLocale() == 'uk') Призначення @elseif(app()->getLocale() == 'en') Purpose @else Verwendungszweck @endif:</span> <span class="text-white">{{ $bankDetails['purpose'] }}</span></div>
                </div>

                <form action="{{ route('checkout.bank-details') }}" method="POST" enctype="multipart/form-data" class="mb-6 space-y-4">
                    @csrf
                    <div class="rounded-xl border border-dashed border-gray-700 bg-gray-800/30 px-4 py-3 transition hover:border-indigo-500/35">
                        <input type="file" name="receipt" id="receipt" accept="image/*,.pdf" required class="block w-full text-sm text-gray-400 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600/90 file:px-4 file:py-2 file:text-xs file:font-black file:uppercase file:tracking-wider file:text-white file:shadow-inner">
                        @error('receipt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold hover:bg-indigo-500 transition shadow-lg shadow-indigo-600/15">{{ __('messages.send_receipt') }}</button>
                </form>

                @if(session('error'))
                    <p class="text-red-500 text-sm mb-4">{{ session('error') }}</p>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <a href="{{ route('profile') }}" class="bg-gray-800 text-gray-300 py-3 rounded-xl font-bold text-center hover:bg-gray-700 transition">{{ __('messages.order_history') }}</a>
                    <a href="{{ route('home') }}" class="bg-gray-800 text-gray-300 py-3 rounded-xl font-bold text-center hover:bg-gray-700 transition">{{ __('messages.back_to_home') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
