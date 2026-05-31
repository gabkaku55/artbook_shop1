@extends('layouts.app')

@section('content')
<div class="page-contacts bg-gray-950 min-h-screen text-gray-300">
    <div class="relative py-24 overflow-hidden border-b border-gray-900">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-indigo-900/20 via-transparent to-transparent opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tighter uppercase leading-none">
                @if(app()->getLocale() == 'uk') Наші <span class="text-indigo-500">контакти</span> @elseif(app()->getLocale() == 'en') Our <span class="text-indigo-500">Contacts</span> @else Unsere <span class="text-indigo-500">Kontakte</span> @endif
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed uppercase tracking-widest font-bold text-[10px]">
                @if(app()->getLocale() == 'uk') Зв'яжіться з нами будь-яким зручним для вас способом @elseif(app()->getLocale() == 'en') Get in touch with us in any way convenient for you @else Kontaktieren Sie uns auf eine für Sie bequeme Weise @endif
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <div class="contact-card-soft contact-card-soft-light bg-gray-900/50 p-10 rounded-[2.5rem] border border-gray-800 hover:border-indigo-500/30 transition duration-500 group text-center">
                <div class="w-20 h-20 bg-gray-800 rounded-3xl flex items-center justify-center mx-auto mb-8 text-indigo-500 group-hover:bg-indigo-600 group-hover:text-white transition duration-500 shadow-xl">
                    <i class="fas fa-map-marker-alt text-3xl"></i>
                </div>
                <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-4">@if(app()->getLocale() == 'uk') Наша адреса @elseif(app()->getLocale() == 'en') Our Address @else Unsere Adresse @endif</h3>
                <p class="text-gray-400 leading-relaxed">
                    @if(app()->getLocale() == 'uk')
                        м. Київ, вул. Хрещатик, 1<br>
                        (метро Майдан Незалежності)<br>
                        Шоурум "Artbook Shop"
                    @elseif(app()->getLocale() == 'en')
                        Kyiv, 1 Khreshchatyk St<br>
                        (Maidan Nezalezhnosti metro)<br>
                        Showroom "Artbook Shop"
                    @else
                        Kiew, Chreschtschatyk-Str. 1<br>
                        (U-Bahn Maidan Nesaleschnosti)<br>
                        Showroom "Artbook Shop"
                    @endif
                </p>
            </div>

            <div class="contact-card-soft contact-card-soft-light bg-gray-900/50 p-10 rounded-[2.5rem] border border-gray-800 hover:border-indigo-500/30 transition duration-500 group text-center">
                <div class="w-20 h-20 bg-gray-800 rounded-3xl flex items-center justify-center mx-auto mb-8 text-indigo-500 group-hover:bg-indigo-600 group-hover:text-white transition duration-500 shadow-xl">
                    <i class="fas fa-phone-alt text-3xl"></i>
                </div>
                <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-4">@if(app()->getLocale() == 'uk') Зв'язок @elseif(app()->getLocale() == 'en') Connection @else Kontakt @endif</h3>
                <div class="space-y-2">
                    <p class="text-gray-400 font-bold hover:text-white transition">
                        <a href="tel:+380441234567">+38 (044) 123-45-67</a>
                    </p>
                    <p class="text-gray-400 font-bold hover:text-white transition">
                        <a href="mailto:artbook1@gmail.com">artbook1@gmail.com</a>
                    </p>
                </div>
            </div>

            <div class="contact-card-soft contact-card-soft-light bg-gray-900/50 p-10 rounded-[2.5rem] border border-gray-800 hover:border-indigo-500/30 transition duration-500 group text-center">
                <div class="w-20 h-20 bg-gray-800 rounded-3xl flex items-center justify-center mx-auto mb-8 text-indigo-500 group-hover:bg-indigo-600 group-hover:text-white transition duration-500 shadow-xl">
                    <i class="fas fa-share-alt text-3xl"></i>
                </div>
                <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-4">@if(app()->getLocale() == 'uk') Ми у мережах @elseif(app()->getLocale() == 'en') Social Media @else Soziale Medien @endif</h3>
                <div class="flex justify-center gap-4">
                    <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-600 hover:text-white transition">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-600 hover:text-white transition">
                        <i class="fab fa-telegram-plane text-xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-gray-800 rounded-xl flex items-center justify-center text-indigo-400 hover:bg-indigo-600 hover:text-white transition">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-20 grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="contact-hours-panel bg-gray-900/30 p-12 rounded-[3rem] border border-gray-800 flex flex-col justify-center">
                <h3 class="text-2xl font-black text-white uppercase tracking-tighter mb-8 flex items-center">
                    <i class="fas fa-clock mr-4 text-indigo-500"></i> @if(app()->getLocale() == 'uk') Графік роботи @elseif(app()->getLocale() == 'en') Working Hours @else Arbeitszeit @endif
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-800 pb-4">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs">@if(app()->getLocale() == 'uk') Понеділок - П'ятниця @elseif(app()->getLocale() == 'en') Monday - Friday @else Montag - Freitag @endif</span>
                        <span class="text-white font-black uppercase tracking-tighter">10:00 — 20:00</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-800 pb-4">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs">@if(app()->getLocale() == 'uk') Субота @elseif(app()->getLocale() == 'en') Saturday @else Samstag @endif</span>
                        <span class="text-white font-black uppercase tracking-tighter">11:00 — 19:00</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs">@if(app()->getLocale() == 'uk') Неділя @elseif(app()->getLocale() == 'en') Sunday @else Sonntag @endif</span>
                        <span class="text-white font-black uppercase tracking-tighter">12:00 — 18:00</span>
                    </div>
                </div>
                <div class="contact-hours-highlight mt-12 p-6 bg-indigo-600/10 border border-indigo-500/20 rounded-2xl">
                    <p class="text-sm text-indigo-400 leading-relaxed text-center">
                        <i class="fas fa-info-circle mr-2"></i> @if(app()->getLocale() == 'uk') Онлайн-замовлення приймаються цілодобово 24/7 @elseif(app()->getLocale() == 'en') Online orders are accepted 24/7 @else Online-Bestellungen werden rund um die Uhr entgegengenommen @endif
                    </p>
                </div>
            </div>

            <div class="contact-map-keep-dark bg-gray-900 rounded-[3rem] border border-gray-800 overflow-hidden relative min-h-[400px] group">
                <img src="{{ asset('images/map-location.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-110 group-hover:opacity-100 transition duration-1000" alt="Наша локація">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-transparent to-transparent opacity-80"></div>
                <div class="absolute bottom-10 left-10 right-10 flex flex-col md:flex-row justify-between items-end gap-6">
                    <div>
                        <h4 class="text-white font-black uppercase tracking-tighter text-2xl">@if(app()->getLocale() == 'uk') Ми тут @elseif(app()->getLocale() == 'en') We are here @else Wir sind hier @endif</h4>
                        <p class="text-gray-400 text-sm font-bold uppercase tracking-widest mt-2">@if(app()->getLocale() == 'uk') Київ, Хрещатик, 1 @elseif(app()->getLocale() == 'en') Kyiv, 1 Khreshchatyk St @else Kiew, Chreschtschatyk-Str. 1 @endif</p>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query=Київ,Хрещатик,1" target="_blank" class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-700 transition shadow-2xl shadow-indigo-500/40">
                        @if(app()->getLocale() == 'uk') Прокласти маршрут @elseif(app()->getLocale() == 'en') Get Directions @else Wegbeschreibung @endif
                    </a>
                </div>
            </div>
        </div>

        <div class="contact-cta-questions mt-20 bg-indigo-600 rounded-[3rem] p-12 lg:p-20 text-center relative overflow-hidden shadow-2xl shadow-indigo-500/20">
            <div class="relative z-10">
                <h2 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter mb-8">@if(app()->getLocale() == 'uk') Залишилися питання? @elseif(app()->getLocale() == 'en') Still have questions? @else Haben Sie noch Fragen? @endif</h2>
                <p class="text-indigo-100 text-xl max-w-2xl mx-auto mb-12">
                    @if(app()->getLocale() == 'uk') Напишіть нам у чат, і ми відповімо вам протягом кількох хвилин. @elseif(app()->getLocale() == 'en') Message us in the chat, and we will get back to you within a few minutes. @else Schreiben Sie uns im Chat und wir antworten Ihnen innerhalb weniger Minuten. @endif
                </p>
                <div class="flex justify-center">
                    <a href="{{ route('chat') }}" class="bg-white text-indigo-600 px-12 py-5 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-gray-100 transition shadow-xl">
                        {{ __('messages.chat') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
