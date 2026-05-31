@extends('layouts.app')

@section('content')
<div class="py-20 bg-gray-950 min-h-screen flex items-center justify-center">
    <div class="max-w-xl w-full bg-gray-900 p-8 rounded-2xl border border-gray-800">
        @if($order->payment_method === 'cod')
            <h1 class="text-2xl font-bold text-white mb-4">{{ __('messages.order_processing') }}</h1>
            <p class="text-gray-400 mb-8 text-sm">{{ __('messages.order_processing_desc') }}</p>
        @elseif($order->payment_method === 'bank')
            <h1 class="text-2xl font-bold text-white mb-4">{{ __('messages.bank_details_title') }}</h1>
            <p class="text-gray-400 mb-8 text-sm">{{ __('messages.receipt_uploaded') }}</p>
        @else
            <h1 class="text-2xl font-bold text-white mb-4">{{ __('messages.payment_success') }}</h1>
            <p class="text-gray-400 mb-8 text-sm">{{ __('messages.payment_success_desc', ['id' => $order->id]) }}</p>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('profile') }}" class="bg-indigo-600 text-white py-3 rounded-xl font-bold text-center hover:bg-indigo-700 transition">{{ __('messages.order_history') }}</a>
            <a href="{{ route('home') }}" class="bg-gray-800 text-gray-300 py-3 rounded-xl font-bold text-center hover:bg-gray-700 transition">{{ __('messages.back_to_home') }}</a>
        </div>
    </div>
</div>
@endsection
