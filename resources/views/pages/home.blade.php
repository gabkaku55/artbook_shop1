@extends('layouts.app')

@section('content')
<section class="home-hero relative h-screen min-h-[600px] flex items-center overflow-hidden bg-gray-950">
    <div class="home-hero-video-wrap absolute inset-0 z-0 overflow-hidden">
        <video id="hero-bg-video" autoplay muted loop playsinline class="w-full h-full object-cover opacity-50" data-src-dark="{{ asset('video/VideoProject1.mp4') }}" data-src-light="{{ asset('video/video2tem.mp4') }}">
            <source src="{{ asset('video/VideoProject1.mp4') }}" type="video/mp4">
            Ваш браузер не підтримує відео.
        </video>
        <div class="hero-gradient-overlay absolute inset-0 bg-gradient-to-t from-gray-950 via-transparent to-gray-950 opacity-80"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center md:text-left">
        <div class="max-w-3xl">
            <h1 class="text-5xl md:text-8xl font-extrabold text-white mb-6 leading-tight tracking-tight">
                @if(app()->getLocale() == 'uk')
                    Відкрий для себе <span class="text-indigo-500 italic">Мистецтво</span> <br> 
                    за <span class="text-indigo-400">Історіями</span>
                @elseif(app()->getLocale() == 'en')
                    Discover <span class="text-indigo-500 italic">Art</span> <br> 
                    behind the <span class="text-indigo-400">Stories</span>
                @else
                    Entdecke <span class="text-indigo-500 italic">Kunst</span> <br> 
                    hinter den <span class="text-indigo-400">Geschichten</span>
                @endif
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-10 leading-relaxed max-w-2xl">
                @if(app()->getLocale() == 'uk')
                    Досліджуйте преміальну колекцію концепт-артів, ексклюзивних ілюстрацій та майстерно створених ескізів з ваших улюблених світів.
                @elseif(app()->getLocale() == 'en')
                    Explore a premium collection of concept art, exclusive illustrations, and masterfully crafted sketches from your favorite worlds.
                @else
                    Entdecken Sie eine exklusive Sammlung von Konzeptkunst, Illustrationen und meisterhaft gefertigten Skizzen aus Ihren Lieblingswelten.
                @endif
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                <a href="{{ route('catalog') }}" class="bg-indigo-600 text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-indigo-700 transition transform hover:scale-105 shadow-xl shadow-indigo-500/20 flex items-center justify-center">
                    <i class="fas fa-shopping-bag mr-2"></i> {{ __('messages.catalog') }}
                </a>
                <a href="#new-arrivals" class="bg-white/10 backdrop-blur-md border border-white/20 text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-white/20 transition flex items-center justify-center">
                    @if(app()->getLocale() == 'uk') Дивитися новинки @elseif(app()->getLocale() == 'en') See New Arrivals @else Neuheiten sehen @endif
                </a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-20 left-1/2 -translate-x-1/2 z-10 animate-bounce md:block hidden">
        <a href="#new-arrivals" class="text-white/50 hover:text-white transition">
            <i class="fas fa-chevron-down text-3xl"></i>
        </a>
    </div>

    <div class="home-hero-wave absolute bottom-0 left-0 w-full overflow-hidden leading-[0] transform rotate-180 pointer-events-none">
        <svg class="relative block w-[calc(100%+1.3px)] h-[80px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-gray-950"></path>
        </svg>
    </div>
</section>

<div class="shared-bg home-shared-sections">
<section class="py-24 overflow-hidden">
    <div id="popular" class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
            <div>
                <h2 class="text-4xl font-bold text-white tracking-tight">@if(app()->getLocale() == 'uk') Хіти продажу @elseif(app()->getLocale() == 'en') Bestsellers @else Bestseller @endif</h2>
                <div class="h-1.5 w-20 bg-indigo-600 mt-4 rounded-full"></div>
            </div>
            <div class="flex gap-4">
                <button class="swiper-prev-pop bg-gray-800 hover:bg-indigo-600 text-white w-12 h-12 rounded-full transition flex items-center justify-center shadow-lg">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="swiper-next-pop bg-gray-800 hover:bg-indigo-600 text-white w-12 h-12 rounded-full transition flex items-center justify-center shadow-lg">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="swiper popular-swiper">
            <div class="swiper-wrapper">
                @foreach($popularProducts as $product)
                    <div class="swiper-slide">
                        <div class="group home-product-card">
                            <div class="relative overflow-hidden rounded-2xl bg-gray-800 aspect-[3/4] mb-6 shadow-lg group-hover:shadow-indigo-500/10 transition duration-500">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $product->translated_name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-600 bg-gray-800">
                                        <i class="fas fa-image text-4xl opacity-20"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                                    @if($product->is_new)
                                        <span class="bg-indigo-600/90 backdrop-blur-sm text-white text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-lg">@if(app()->getLocale() == 'uk') Новинка @elseif(app()->getLocale() == 'en') New @else Neu @endif</span>
                                    @endif
                                    @if($product->is_popular)
                                        <span class="bg-orange-600/90 backdrop-blur-sm text-white text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-lg">
                                            <i class="fas fa-fire mr-1"></i>@if(app()->getLocale() == 'uk') Популярне @elseif(app()->getLocale() == 'en') Popular @else Beliebt @endif
                                        </span>
                                    @endif
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500 flex flex-col justify-end p-6">
                                    <a href="{{ route('product.show', $product->slug) }}" class="bg-white text-gray-900 w-full py-3 rounded-xl font-bold text-center transform translate-y-4 group-hover:translate-y-0 transition duration-500 shadow-xl">
                                        {{ __('messages.details') }}
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('product.show', $product->slug) }}">
                                <h3 class="font-bold text-xl text-white group-hover:text-indigo-400 transition">{{ $product->translated_name }}</h3>
                            </a>
                            <p class="text-gray-400 text-sm mt-1">{{ $product->translated_author }}</p>
                            <div class="flex items-center justify-between mt-4">
                                @if($product->hasDiscount())
                                    <div class="flex flex-wrap items-baseline gap-2">
                                        <span class="text-lg font-bold text-gray-500 line-through">{{ $product->formatted_old_price }}</span>
                                        <p class="text-2xl font-black text-white">{{ $product->formatted_price }}</p>
                                    </div>
                                @else
                                    <p class="text-2xl font-black text-white">{{ $product->formatted_price }}</p>
                                @endif
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="home-add-cart bg-gray-800 p-3 rounded-xl hover:bg-indigo-600 text-gray-300 hover:text-white transition">
                                            <i class="fas fa-cart-plus text-lg"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] font-black uppercase text-red-500 border border-red-500/30 px-3 py-1.5 rounded-lg bg-red-950/20">
                                        @if(app()->getLocale() == 'uk') Немає @elseif(app()->getLocale() == 'en') Out @else Weg @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="new-arrivals" class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
            <div>
                <h2 class="text-4xl font-bold text-white tracking-tight">@if(app()->getLocale() == 'uk') Новинки @elseif(app()->getLocale() == 'en') New Arrivals @else Neuheiten @endif</h2>
                <div class="h-1.5 w-20 bg-indigo-600 mt-4 rounded-full"></div>
            </div>
            <div class="flex gap-4">
                <button class="swiper-prev-new bg-gray-800 hover:bg-indigo-600 text-white w-12 h-12 rounded-full transition flex items-center justify-center shadow-lg">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="swiper-next-new bg-gray-800 hover:bg-indigo-600 text-white w-12 h-12 rounded-full transition flex items-center justify-center shadow-lg">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="swiper new-arrivals-swiper">
            <div class="swiper-wrapper">
                @foreach($newArrivals as $product)
                    <div class="swiper-slide">
                        <div class="group home-product-card">
                            <div class="relative overflow-hidden rounded-2xl bg-gray-800 aspect-[3/4] mb-6 shadow-lg group-hover:shadow-indigo-500/10 transition duration-500">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $product->translated_name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-600 bg-gray-800">
                                        <i class="fas fa-image text-4xl opacity-20"></i>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                                    @if($product->is_new)
                                        <span class="bg-indigo-600/90 backdrop-blur-sm text-white text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-lg">@if(app()->getLocale() == 'uk') Новинка @elseif(app()->getLocale() == 'en') New @else Neu @endif</span>
                                    @endif
                                    @if($product->is_popular)
                                        <span class="bg-orange-600/90 backdrop-blur-sm text-white text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-lg">
                                            <i class="fas fa-fire mr-1"></i>@if(app()->getLocale() == 'uk') Популярне @elseif(app()->getLocale() == 'en') Popular @else Beliebt @endif
                                        </span>
                                    @endif
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-500 flex flex-col justify-end p-6">
                                    <a href="{{ route('product.show', $product->slug) }}" class="bg-white text-gray-900 w-full py-3 rounded-xl font-bold text-center transform translate-y-4 group-hover:translate-y-0 transition duration-500 shadow-xl">
                                        {{ __('messages.details') }}
                                    </a>
                                </div>
                            </div>
                            <a href="{{ route('product.show', $product->slug) }}">
                                <h3 class="font-bold text-xl text-white group-hover:text-indigo-400 transition">{{ $product->translated_name }}</h3>
                            </a>
                            <p class="text-gray-400 text-sm mt-1">{{ $product->translated_author }}</p>
                            <div class="flex items-center justify-between mt-4">
                                @if($product->hasDiscount())
                                    <div class="flex flex-wrap items-baseline gap-2">
                                        <span class="text-lg font-bold text-gray-500 line-through">{{ $product->formatted_old_price }}</span>
                                        <p class="text-2xl font-black text-white">{{ $product->formatted_price }}</p>
                                    </div>
                                @else
                                    <p class="text-2xl font-black text-white">{{ $product->formatted_price }}</p>
                                @endif
                                @if($product->stock > 0)
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="home-add-cart bg-gray-800 p-3 rounded-xl hover:bg-indigo-600 text-gray-300 hover:text-white transition">
                                            <i class="fas fa-cart-plus text-lg"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] font-black uppercase text-red-500 border border-red-500/30 px-3 py-1.5 rounded-lg bg-red-950/20">
                                        @if(app()->getLocale() == 'uk') Немає @elseif(app()->getLocale() == 'en') Out @else Weg @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-16">
            <h2 class="text-4xl font-bold text-white tracking-tight">@if(app()->getLocale() == 'uk') Відео розпаковок @elseif(app()->getLocale() == 'en') Video Unboxings @else Video-Unboxings @endif</h2>
            <div class="h-1.5 w-20 bg-indigo-600 mt-4 rounded-full"></div>
        </div>

        <div
            class="home-unboxing-scroll flex flex-nowrap gap-6 md:gap-8 overflow-x-auto overflow-y-visible pb-4 scroll-smooth snap-x snap-mandatory -mx-4 px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 overscroll-x-contain">
            @forelse($unboxingVideos as $video)
                <div
                    class="home-unboxing-card flex-shrink-0 w-[min(88vw,20.5rem)] sm:w-[min(75vw,24rem)] md:w-[26rem] snap-start bg-gray-900 rounded-[2rem] overflow-hidden border border-gray-800 group">
                    <div class="relative aspect-video">
                        <video class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition" controls>
                            <source src="{{ $video->video_url }}">
                        </video>
                        <div class="absolute inset-0 pointer-events-none bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"></div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-white mb-2">{{ $video->title }}</h3>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            {{ $video->description }}
                        </p>
                    </div>
                </div>
            @empty
                @php
                    $fallbackVideos = [
                        [
                            'video_path' => 'video/MassEffect.mp4',
                            'title' => [
                                'uk' => 'Ігровий світ трилогії Mass Effect',
                                'en' => 'Game World of Mass Effect Trilogy',
                                'de' => 'Spielwelt der Mass-Effect-Trilogie',
                            ],
                            'description' => [
                                'uk' => 'Поглиблений огляд артбуку: концепт-арт, персонажі та локації з культової космічної саги BioWare.',
                                'en' => 'In-depth artbook review: concept art, characters and locations from the iconic BioWare space saga.',
                                'de' => 'Detaillierter Artbook-Überblick: Konzeptkunst, Charaktere und Schauplätze der Kult-Raumsaga von BioWare.',
                            ],
                        ],
                        [
                            'video_path' => 'video/DeathStranding.mp4',
                            'title' => [
                                'uk' => 'Світ гри Death Stranding 2: On the Beach',
                                'en' => 'World of Death Stranding 2: On the Beach',
                                'de' => 'Welt von Death Stranding 2: On the Beach',
                            ],
                            'description' => [
                                'uk' => 'Ексклюзивний огляд артбуку: унікальна візуальна естетика та арт від Kojima Productions.',
                                'en' => 'Exclusive artbook review: unique visual aesthetic and art from Kojima Productions.',
                                'de' => 'Exklusiver Artbook-Überblick: einzigartige visuelle Ästhetik und Kunst von Kojima Productions.',
                            ],
                        ],
                        [
                            'video_path' => 'video/arkrein.mp4',
                            'title' => [
                                'uk' => 'Мистецтво й створення серіалу «Аркейн»',
                                'en' => 'Art and Creation of Arcane Series',
                                'de' => 'Kunst und Entstehung der Serie Arcane',
                            ],
                            'description' => [
                                'uk' => 'За лаштунками серіалу: від ескізів до фінальної анімації. Огляд артбуку від Fortiche та Riot.',
                                'en' => 'Behind the scenes: from sketches to final animation. Artbook review by Fortiche and Riot.',
                                'de' => 'Hinter den Kulissen: von Skizzen zur Endanimation. Artbook-Überblick von Fortiche und Riot.',
                            ],
                        ],
                    ];
                @endphp

                @foreach($fallbackVideos as $video)
                    <div
                        class="home-unboxing-card flex-shrink-0 w-[min(88vw,20.5rem)] sm:w-[min(75vw,24rem)] md:w-[26rem] snap-start bg-gray-900 rounded-[2rem] overflow-hidden border border-gray-800 group">
                        <div class="relative aspect-video">
                            <video class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition" controls>
                                <source src="{{ asset($video['video_path']) }}" type="video/mp4">
                            </video>
                            <div class="absolute inset-0 pointer-events-none bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"></div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $video['title'][app()->getLocale()] ?? $video['title']['en'] }}</h3>
                            <p class="text-gray-400 text-sm leading-relaxed">
                                {{ $video['description'][app()->getLocale()] ?? $video['description']['en'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section class="py-24 overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white tracking-tight">@if(app()->getLocale() == 'uk') Питання та відповіді @elseif(app()->getLocale() == 'en') Questions & Answers @else Fragen & Antworten @endif</h2>
            <div class="h-1.5 w-20 bg-indigo-600 mt-4 rounded-full mx-auto"></div>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @php
                $faqs = [
                    ['q' => ['uk' => 'Яка вартість доставки?', 'en' => 'What is the shipping cost?', 'de' => 'Was sind die Versandkosten?'], 
                     'a' => ['uk' => 'Доставка здійснюється за тарифами перевізника (Нова Пошта, Укрпошта). При замовленні від 800 грн — доставка безкоштовна.', 'en' => 'Delivery is carried out according to the carrier\'s rates (Nova Poshta, Ukrposhta). For orders over 800 UAH — delivery is free.', 'de' => 'Die Lieferung erfolgt nach den Tarifen des Versandunternehmens (Nova Poshta, Ukrposhta). Ab einem Bestellwert von 800 UAH ist die Lieferung kostenlos.']],
                    ['q' => ['uk' => 'Як я можу оплатити замовлення?', 'en' => 'How can I pay for my order?', 'de' => 'Wie kann ich meine Bestellung bezahlen?'], 
                     'a' => ['uk' => 'Ви можете оплатити замовлення онлайн банківською картою або при отриманні у відділенні (накладений платіж).', 'en' => 'You can pay for your order online by bank card or upon receipt at the branch (cash on delivery).', 'de' => 'Sie können Ihre Bestellung online per Bankkarte oder bei Erhalt in der Filiale (Nachnahme) bezahlen.']],
                    ['q' => ['uk' => 'Чи є у вас подарункове пакування?', 'en' => 'Do you have gift wrapping?', 'de' => 'Haben Sie eine Geschenkverpackung?'], 
                     'a' => ['uk' => 'Так, ми можемо святково запакувати ваш артбук. Вкажіть це в коментарі до замовлення або повідомте менеджеру.', 'en' => 'Yes, we can festive wrap your artbook. Specify this in the order comment or inform the manager.', 'de' => 'Ja, wir können Ihr Artbook festlich verpacken. Geben Sie dies im Bestellkommentar an oder informieren Sie den Manager.']],
                    ['q' => ['uk' => 'Як швидко відправляється замовлення?', 'en' => 'How quickly is the order shipped?', 'de' => 'Wie schnell wird die Bestellung versandt?'], 
                     'a' => ['uk' => 'Замовлення, оформлені до 15:00, відправляються в той же день. Всі інші — на наступний робочий день.', 'en' => 'Orders placed before 15:00 are shipped on the same day. All others — on the next business day.', 'de' => 'Bestellungen, die vor 15:00 Uhr eingehen, werden am selben Tag versandt. Alle anderen — am nächsten Werktag.']],
                ];
            @endphp

            @foreach($faqs as $index => $faq)
                <div class="bg-gray-800 rounded-2xl border border-gray-700 overflow-hidden">
                    <button @click="active = (active === {{ $index }} ? null : {{ $index }})" class="w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-700/50 transition">
                        <span class="font-bold text-lg text-white">{{ $faq['q'][app()->getLocale()] ?? $faq['q']['en'] }}</span>
                        <i class="fas fa-chevron-down transition duration-300" :class="active === {{ $index }} ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="active === {{ $index }}" x-collapse x-cloak>
                        <div class="px-8 pb-6 text-gray-400 leading-relaxed">
                            {{ $faq['a'][app()->getLocale()] ?? $faq['a']['en'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiperConfig = {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            grabCursor: true,
            mousewheel: {
                forceToAxis: true,
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 30 },
                1280: { slidesPerView: 4, spaceBetween: 40 }
            }
        };

        new Swiper('.new-arrivals-swiper', {
            ...swiperConfig,
            navigation: {
                nextEl: '.swiper-next-new',
                prevEl: '.swiper-prev-new',
            },
        });

        new Swiper('.popular-swiper', {
            ...swiperConfig,
            navigation: {
                nextEl: '.swiper-next-pop',
                prevEl: '.swiper-prev-pop',
            },
        });
    });
</script>
@endsection
