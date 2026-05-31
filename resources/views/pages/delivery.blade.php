@extends('layouts.app')

@section('content')
<div class="page-delivery bg-gray-950 min-h-screen text-gray-300">
    <div class="relative py-24 overflow-hidden border-b border-gray-900">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-indigo-900/20 via-transparent to-transparent opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tighter uppercase leading-none">
                {{ __('messages.payment_delivery') }}
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed uppercase tracking-widest font-bold text-[10px]">
                {{ __('messages.payment_delivery_desc') }}
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20">
            
            <div class="space-y-12">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter mb-8 flex items-center">
                        <span class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center mr-4 text-sm shadow-lg shadow-indigo-500/20">1</span>
                        {{ __('messages.payment_methods') }}
                    </h2>
                    
                    <div class="space-y-6">
                        <div class="delivery-method-card bg-gray-900/50 p-8 rounded-[2rem] border border-gray-800 hover:border-indigo-500/30 transition duration-500 group">
                            <div class="flex items-start gap-6">
                                <div class="w-14 h-14 bg-gray-800 rounded-2xl flex items-center justify-center hidden">
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-lg font-black text-white uppercase tracking-tighter mb-2">{{ __('messages.online_payment') }}</h3>
                                    <p class="delivery-method-card-desc text-gray-400 text-sm leading-relaxed">
                                        {{ __('messages.online_payment_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="delivery-method-card bg-gray-900/50 p-8 rounded-[2rem] border border-gray-800 hover:border-indigo-500/30 transition duration-500 group">
                            <div class="flex items-start gap-6">
                                <div class="w-14 h-14 bg-gray-800 rounded-2xl flex items-center justify-center hidden">
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-lg font-black text-white uppercase tracking-tighter mb-2">@if(app()->getLocale() == 'uk') Накладений платіж @elseif(app()->getLocale() == 'en') Cash on Delivery @else Nachnahme @endif</h3>
                                    <p class="delivery-method-card-desc text-gray-400 text-sm leading-relaxed">
                                        {{ __('messages.cod_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="delivery-method-card bg-gray-900/50 p-8 rounded-[2rem] border border-gray-800 hover:border-indigo-500/30 transition duration-500 group">
                            <div class="flex items-start gap-6">
                                <div class="w-14 h-14 bg-gray-800 rounded-2xl flex items-center justify-center hidden">
                                </div>
                                <div class="flex-grow">
                                    <h3 class="text-lg font-black text-white uppercase tracking-tighter mb-2">@if(app()->getLocale() == 'uk') Оплата за реквізитами @elseif(app()->getLocale() == 'en') Bank Transfer @else Banküberweisung @endif</h3>
                                    <p class="delivery-method-card-desc text-gray-400 text-sm leading-relaxed">
                                        {{ __('messages.bank_transfer_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-12">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter mb-8 flex items-center">
                        <span class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center mr-4 text-sm shadow-lg shadow-indigo-500/20">2</span>
                        {{ __('messages.delivery_methods') }}
                    </h2>
                    
                    <div class="space-y-6">
                        <div class="delivery-method-card bg-gray-900/50 p-8 rounded-[2rem] border border-gray-800 hover:border-red-500/30 transition duration-500 group relative overflow-hidden">
                            <div class="flex items-center gap-6 mb-6">
                                <div class="w-20 h-12 bg-white rounded-xl flex items-center justify-center p-2 shadow-lg">
                                    <img src="{{ asset('images/nova-poshta.png') }}" class="w-full h-full object-contain" alt="Нова Пошта">
                                </div>
                                <h3 class="text-lg font-black text-white uppercase tracking-tighter">Нова Пошта</h3>
                            </div>
                            <ul class="delivery-method-card-desc space-y-3 text-sm text-gray-400">
                                <li class="flex items-center gap-3"><i class="fas fa-check text-red-500"></i> @if(app()->getLocale() == 'uk') У відділення по всій Україні @elseif(app()->getLocale() == 'en') To branches across Ukraine @else In Filialen in der ganzen Ukraine @endif</li>
                                <li class="flex items-center gap-3"><i class="fas fa-check text-red-500"></i> @if(app()->getLocale() == 'uk') У поштомати (цілодобово) @elseif(app()->getLocale() == 'en') To post machines (24/7) @else In Postautomaten (24/7) @endif</li>
                                <li class="pt-4 font-bold text-white flex justify-between items-center">
                                    <span>{{ __('messages.delivery_time') }}: 1-3 {{ __('messages.days') }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="delivery-method-card bg-gray-900/50 p-8 rounded-[2rem] border border-gray-800 hover:border-yellow-500/30 transition duration-500 group relative overflow-hidden">
                            <div class="absolute -right-4 -top-4 opacity-[0.03] text-9xl group-hover:opacity-[0.07] transition duration-700">
                                <i class="fas fa-mailbox"></i>
                            </div>
                            <div class="flex items-center gap-6 mb-6">
                                <div class="w-20 h-12 bg-white rounded-xl flex items-center justify-center p-2 shadow-lg">
                                    <img src="{{ asset('images/ukr-poshta.png') }}" class="w-full h-full object-contain" alt="Укрпошта">
                                </div>
                                <h3 class="text-lg font-black text-white uppercase tracking-tighter">Укрпошта</h3>
                            </div>
                            <ul class="delivery-method-card-desc space-y-3 text-sm text-gray-400">
                                <li class="flex items-center gap-3"><i class="fas fa-check text-yellow-500"></i> {{ __('messages.ukrposhta_desc') }}</li>
                                <li class="pt-4 font-bold text-white flex justify-between items-center">
                                    <span>{{ __('messages.delivery_time') }}: 3-7 {{ __('messages.days') }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="delivery-method-card bg-gray-900/50 p-8 rounded-[2rem] border border-gray-800 hover:border-indigo-500/30 transition duration-500 group relative overflow-hidden">
                            <div class="flex items-center gap-6 mb-6">
                                <div class="w-20 h-12 bg-gray-800 border border-gray-700 rounded-xl flex items-center justify-center text-indigo-500 text-xl shadow-lg">
                                    <i class="fas fa-store-alt"></i>
                                </div>
                                <h3 class="text-lg font-black text-white uppercase tracking-tighter">{{ __('messages.pickup') }}</h3>
                            </div>
                            <p class="delivery-method-card-desc text-sm text-gray-400 mb-4">
                                {{ __('messages.pickup_desc') }} <br>
                                <span class="text-white font-bold">@if(app()->getLocale() == 'uk') м. Київ, вул. Хрещатик, 1 @elseif(app()->getLocale() == 'en') Kyiv, Khreshchatyk St, 1 @else Kiew, Chreschtschatyk-Str. 1 @endif</span>
                            </p>
                            <div class="pt-4 font-bold text-white flex justify-between items-center">
                                <span>{{ __('messages.working_hours') }}</span>
                                <span class="text-[10px] uppercase tracking-widest bg-indigo-900/20 text-indigo-500 px-3 py-1 rounded-full border border-indigo-500/20">{{ __('messages.free') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="delivery-important-panel bg-gray-900/30 p-10 rounded-[2.5rem] border border-gray-800">
                <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-3 text-indigo-500"></i> {{ __('messages.important_info') }}
                </h3>
                <ul class="delivery-important-panel-text space-y-4 text-sm text-gray-400">
                    @if(app()->getLocale() == 'uk')
                        <li>• Замовлення, оформлені до 16:00, відправляються в той же день.</li>
                        <li>• Після відправки ви отримаєте SMS з номером ТТН.</li>
                        <li>• Ми пакуємо всі книги у спеціальну упаковку безкоштовно.</li>
                    @elseif(app()->getLocale() == 'en')
                        <li>• Orders placed before 16:00 are shipped the same day.</li>
                        <li>• After shipping, you will receive an SMS with the tracking number.</li>
                        <li>• We pack all books in special packaging for free.</li>
                    @else
                        <li>• Bestellungen, die vor 16:00 Uhr aufgegeben werden, werden am selben Tag versandt.</li>
                        <li>• Nach dem Versand erhalten Sie eine SMS mit der Sendungsnummer.</li>
                        <li>• Wir verpacken alle Bücher kostenlos in einer speziellen Verpackung.</li>
                    @endif
                </ul>
            </div>
            <div class="delivery-returns-panel bg-indigo-600/10 p-10 rounded-[2.5rem] border border-indigo-500/20">
                <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-4 flex items-center">
                    <i class="fas fa-undo-alt mr-3 text-indigo-400"></i> {{ __('messages.returns_exchanges') }}
                </h3>
                <p class="text-sm text-gray-400 leading-relaxed">
                    @if(app()->getLocale() == 'uk')
                        Згідно із законодавством України, друкована продукція належної якості поверненню не підлягає. Проте, ми завжди йдемо назустріч при виявленні браку!
                    @elseif(app()->getLocale() == 'en')
                        According to Ukrainian law, printed products of proper quality are not subject to return. However, we always help if a defect is found!
                    @else
                        Nach ukrainischem Recht sind Druckerzeugnisse von ordnungsgemäßer Qualität nicht vom Rückgaberecht ausgeschlossen. Wir helfen jedoch immer, wenn ein Defekt gefunden wird!
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
