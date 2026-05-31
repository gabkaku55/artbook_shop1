@extends('layouts.app')

@section('content')
@php
    $backLabel = app()->getLocale() == 'uk' ? 'До оформлення' : (app()->getLocale() == 'en' ? 'Back to checkout' : 'Zur Kasse');
@endphp
<div class="py-12 bg-gray-950 min-h-screen flex items-center justify-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="max-w-xl mx-auto relative">
            <form action="{{ route('order.cancel', $order) }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="redirect_after_cancel" value="checkout">
                <button type="submit" class="group inline-flex items-center gap-2.5 text-xs font-black uppercase tracking-[0.2em] text-gray-500 hover:text-indigo-400 transition-colors">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full border border-gray-800 bg-gray-900/80 text-gray-400 shadow-sm group-hover:border-indigo-500/40 group-hover:bg-indigo-950/30 group-hover:text-indigo-400 transition-all" aria-hidden="true">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </span>
                    <span>{{ $backLabel }}</span>
                </button>
            </form>

            <div class="relative overflow-hidden bg-gray-900 rounded-[2.5rem] shadow-2xl border border-gray-800 ring-1 ring-white/[0.04]">
                <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-indigo-600/25 blur-3xl" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -bottom-20 -left-16 h-48 w-48 rounded-full bg-fuchsia-600/15 blur-3xl" aria-hidden="true"></div>

                <div class="relative bg-gradient-to-br from-indigo-600 via-indigo-600 to-indigo-800 px-10 py-10 text-white text-center">
                    <h1 class="text-3xl font-black uppercase tracking-tighter">{{ __('messages.payment_secure_title') }}</h1>
                    @php
                        $currency = session('currency', 'UAH');
                        $amountRaw = number_format($order->total_price, 2);
                        $formattedAmount = match ($currency) {
                            'USD' => '$' . $amountRaw,
                            'EUR' => '€' . $amountRaw,
                            default => $amountRaw . ' грн',
                        };
                    @endphp
                    <p class="mt-3 font-bold opacity-85 uppercase tracking-widest text-xs">
                        {{ __('messages.payment_order_line', ['id' => $order->id, 'amount' => $formattedAmount]) }}
                    </p>
                </div>

                <form id="payment-form" action="{{ route('payment', $order->id) }}" method="POST" class="relative p-10 space-y-8">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">{{ __('messages.card_number') }}</label>
                            <div class="relative">
                                <input type="text" name="card_number" inputmode="numeric" autocomplete="cc-number" value="{{ old('card_number') }}" placeholder="0000 0000 0000 0000" maxlength="19" data-pay-mask="card" class="w-full px-5 py-4 pl-5 pr-12 bg-gray-800/90 border border-gray-700 rounded-2xl text-white tracking-[0.12em] font-mono text-[15px] focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition shadow-inner placeholder:text-gray-600 placeholder:tracking-normal placeholder:font-sans @error('card_number') border-red-500 @enderror" required>
                                <i class="fas fa-credit-card absolute right-5 top-1/2 -translate-y-1/2 text-gray-600 pointer-events-none"></i>
                            </div>
                            @error('card_number') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">{{ __('messages.card_expiry') }}</label>
                                <input type="text" name="expiry" inputmode="numeric" autocomplete="cc-exp" value="{{ old('expiry') }}" placeholder="MM/YY" maxlength="5" data-pay-mask="expiry" class="w-full px-5 py-4 bg-gray-800/90 border border-gray-700 rounded-2xl text-white font-mono text-[15px] tracking-wider focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition placeholder:text-gray-600 @error('expiry') border-red-500 @enderror" required>
                                @error('expiry') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">{{ __('messages.card_cvv') }}</label>
                                <input type="password" name="cvv" inputmode="numeric" autocomplete="cc-csc" placeholder="•••" maxlength="3" data-pay-mask="cvv" class="w-full px-5 py-4 bg-gray-800/90 border border-gray-700 rounded-2xl text-white font-mono text-[15px] tracking-widest focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition placeholder:text-gray-600 @error('cvv') border-red-500 @enderror" required>
                                @error('cvv') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-3">{{ __('messages.cardholder') }}</label>
                            <input type="text" name="cardholder" autocomplete="cc-name" value="{{ old('cardholder') }}" placeholder="IVAN IVANOV" data-pay-mask="name" class="w-full px-5 py-4 bg-gray-800/90 border border-gray-700 rounded-2xl text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition uppercase placeholder:normal-case placeholder:text-gray-600 @error('cardholder') border-red-500 @enderror" required>
                            @error('cardholder') <p class="text-red-500 text-xs mt-2 font-bold uppercase tracking-wide">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-5 rounded-2xl font-black text-xl hover:bg-indigo-500 transition transform hover:scale-[1.01] active:scale-[0.99] shadow-xl shadow-indigo-500/25">
                        {{ __('messages.pay_button', ['amount' => $formattedAmount]) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
(function () {
    function digits(s) { return (s || '').replace(/\D/g, ''); }
    function fmtCard(raw) {
        var d = raw.slice(0, 16);
        var parts = d.match(/.{1,4}/g);
        return parts ? parts.join(' ') : '';
    }
    function fmtExpiry(raw) {
        var d = raw.slice(0, 4);
        if (d.length <= 2) return d;
        return d.slice(0, 2) + '/' + d.slice(2);
    }

    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('payment-form');
        if (!form) return;

        var cardEl = form.querySelector('[data-pay-mask="card"]');
        var expEl = form.querySelector('[data-pay-mask="expiry"]');
        var cvvEl = form.querySelector('[data-pay-mask="cvv"]');
        var nameEl = form.querySelector('[data-pay-mask="name"]');

        if (cardEl && cardEl.value) {
            var cd = digits(cardEl.value).slice(0, 16);
            cardEl.value = fmtCard(cd);
        }
        if (expEl && expEl.value) {
            expEl.value = fmtExpiry(digits(expEl.value));
        }

        cardEl.addEventListener('input', function () {
            var v = fmtCard(digits(cardEl.value));
            cardEl.value = v;
        });
        cardEl.addEventListener('blur', function () {
            cardEl.value = fmtCard(digits(cardEl.value));
        });

        expEl.addEventListener('input', function () {
            var v = digits(expEl.value).slice(0, 4);
            if (v.length >= 3 && expEl.selectionStart === expEl.value.length) {
                // allow typing through slash smoothly
            }
            expEl.value = fmtExpiry(v);
        });

        cvvEl.addEventListener('input', function () {
            cvvEl.value = digits(cvvEl.value).slice(0, 3);
        });

        if (nameEl) {
            nameEl.addEventListener('blur', function () {
                nameEl.value = (nameEl.value || '').trim().toUpperCase();
            });
        }

        form.addEventListener('submit', function () {
            if (cardEl) cardEl.value = digits(cardEl.value).slice(0, 16);
            if (cvvEl) cvvEl.value = digits(cvvEl.value).slice(0, 3);
            if (expEl) expEl.value = fmtExpiry(digits(expEl.value));
        });
    });
})();
</script>
@endsection
