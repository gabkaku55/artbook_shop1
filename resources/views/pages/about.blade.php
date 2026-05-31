@extends('layouts.app')

@section('content')
<div class="page-about bg-gray-950 min-h-screen text-gray-300">
    <div class="relative py-32 overflow-hidden border-b border-gray-900">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-indigo-900/20 via-transparent to-transparent opacity-50"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-6xl md:text-9xl font-black text-white mb-8 tracking-tighter uppercase leading-none">
                @if(app()->getLocale() == 'uk') Про <span class="text-indigo-500">нас</span> @elseif(app()->getLocale() == 'en') About <span class="text-indigo-500">Us</span> @else Über <span class="text-indigo-500">uns</span> @endif
            </h1>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto leading-relaxed italic">
                @if(app()->getLocale() == 'uk')
                    "Мистецтво — це не те, що ви бачите, а те, що ви даєте побачити іншим." — Едгар Дега
                @elseif(app()->getLocale() == 'en')
                    "Art is not what you see, but what you make others see." — Edgar Degas
                @else
                    "Kunst ist nicht das, was man sieht, sondern das, was man andere sehen lässt." — Edgar Degas
                @endif
            </p>
        </div>
    </div>

    <div class="py-24 border-b border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="space-y-10">
                    <div>
                        <h2 class="text-3xl font-black text-white uppercase tracking-tighter mb-6">@if(app()->getLocale() == 'uk') Наша Компанія @elseif(app()->getLocale() == 'en') Our Company @else Unser Unternehmen @endif</h2>
                        <p class="text-lg text-gray-400 leading-relaxed">
                            @if(app()->getLocale() == 'uk')
                                Artbook Shop — це провідна українська платформа, присвячена візуальному мистецтву в індустрії розваг. Ми спеціалізуємося на кураторському відборі видань, що демонструють найвищий рівень майстерності концепт-арту, ілюстрації та дизайну. Наша місія — зробити світові мистецькі шедеври доступними для української спільноти художників, дизайнерів та поціновувачів візуального контенту.
                            @elseif(app()->getLocale() == 'en')
                                Artbook Shop is Ukraine's leading platform dedicated to visual art in the entertainment industry. We specialize in a curated selection of publications showcasing the highest level of mastery in concept art, illustration, and design. Our mission is to make global artistic masterpieces accessible to the Ukrainian community of artists, designers, and visual content enthusiasts.
                            @else
                                Artbook Shop ist die führende Plattform in der Ukraine, die der visuellen Kunst in der Unterhaltungsindustrie gewidmet ist. Wir sind spezialisiert auf eine kuratierte Auswahl an Publikationen, die das höchste Niveau an Meisterschaft in Konzeptkunst, Illustration und Design zeigen. Unsere Mission ist es, weltweite künstlerische Meisterwerke für die ukrainische Gemeinschaft von Künstlern, Designern und Liebhabern visueller Inhalte zugänglich zu machen.
                            @endif
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-8">
                        <div class="about-stat-card bg-gray-900/50 p-6 rounded-3xl border border-gray-800">
                            <p class="text-4xl font-black text-indigo-500 mb-2">100%</p>
                            <p class="about-stat-card-label text-xs font-bold uppercase tracking-widest text-gray-500">@if(app()->getLocale() == 'uk') Оригінальність @elseif(app()->getLocale() == 'en') Originality @else Originalität @endif</p>
                        </div>
                        <div class="about-stat-card bg-gray-900/50 p-6 rounded-3xl border border-gray-800">
                            <p class="text-4xl font-black text-indigo-500 mb-2">5000+</p>
                            <p class="about-stat-card-label text-xs font-bold uppercase tracking-widest text-gray-500">@if(app()->getLocale() == 'uk') Доставлених книг @elseif(app()->getLocale() == 'en') Delivered Books @else Gelieferte Bücher @endif</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="aspect-square rounded-[3rem] overflow-hidden border border-gray-800 shadow-2xl shadow-indigo-500/10">
                        <img src="{{ asset('images/pro_nas.jpg') }}" alt="@if(app()->getLocale() == 'uk') Про нас @elseif(app()->getLocale() == 'en') About Us @else Über uns @endif" class="w-full h-full object-cover object-center">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about-history-section py-24 border-b border-gray-900 bg-gray-900/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-black text-white uppercase tracking-tighter mb-4">@if(app()->getLocale() == 'uk') Історія та Розвиток @elseif(app()->getLocale() == 'en') History & Development @else Geschichte & Entwicklung @endif</h2>
                <div class="h-1 w-20 bg-indigo-600 mx-auto rounded-full"></div>
            </div>
            
            <div class="space-y-20">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <div class="space-y-6">
                        <div class="text-6xl font-black text-gray-800">2019</div>
                        <h3 class="text-xl font-bold text-white uppercase tracking-widest">@if(app()->getLocale() == 'uk') Заснування @elseif(app()->getLocale() == 'en') Founding @else Gründung @endif</h3>
                        <p class="text-gray-400 leading-relaxed">
                            @if(app()->getLocale() == 'uk')
                                Все почалося з невеликої приватної колекції та усвідомлення того, що в Україні катастрофічно бракує якісних видань про концепт-арт. Ми відкрили наш перший онлайн-магазин з асортиментом всього у 20 найменувань.
                            @elseif(app()->getLocale() == 'en')
                                It all started with a small private collection and the realization that there was a catastrophic lack of quality publications about concept art in Ukraine. We opened our first online store with a range of only 20 titles.
                            @else
                                Alles begann mit einer kleinen Privatsammlung und der Erkenntnis, dass es in der Ukraine einen katastrophalen Mangel an hochwertigen Publikationen über Konzeptkunst gab. Wir eröffneten unseren ersten Online-Shop mit einem Sortiment von nur 20 Titeln.
                            @endif
                        </p>
                    </div>
                    <div class="space-y-6">
                        <div class="text-6xl font-black text-gray-800">2021</div>
                        <h3 class="text-xl font-bold text-white uppercase tracking-widest">@if(app()->getLocale() == 'uk') Прямі контракти @elseif(app()->getLocale() == 'en') Direct Contracts @else Direkte Verträge @endif</h3>
                        <p class="text-gray-400 leading-relaxed">
                            @if(app()->getLocale() == 'uk')
                                Важливий етап розвитку — налагодження прямих зв'язків з провідними видавництвами світу, такими як Titan Books, Insight Editions та Dark Horse. Це дозволило нам пропонувати найкращі ціни та ексклюзивні передзамовлення.
                            @elseif(app()->getLocale() == 'en')
                                An important stage of development was establishing direct connections with the world's leading publishers, such as Titan Books, Insight Editions, and Dark Horse. This allowed us to offer the best prices and exclusive pre-orders.
                            @else
                                Eine wichtige Phase der Entwicklung war der Aufbau direkter Verbindungen zu den weltweit führenden Verlagen wie Titan Books, Insight Editions und Dark Horse. Dies ermöglichte es uns, die besten Preise und exklusive Vorbestellungen anzubieten.
                            @endif
                        </p>
                    </div>
                    <div class="space-y-6">
                        <div class="text-6xl font-black text-gray-800">2024</div>
                        <h3 class="text-xl font-bold text-white uppercase tracking-widest">@if(app()->getLocale() == 'uk') Нові горизонти @elseif(app()->getLocale() == 'en') New Horizons @else Neue Horizonte @endif</h3>
                        <p class="text-gray-400 leading-relaxed">
                            @if(app()->getLocale() == 'uk')
                                Сьогодні наш каталог налічує понад 1200 унікальних артбуків. Ми стали не просто магазином, а спільнотою, що підтримує розвиток візуальної культури в Україні через лекції та співпрацю з художніми школами.
                            @elseif(app()->getLocale() == 'en')
                                Today, our catalog includes over 1,200 unique artbooks. We have become not just a store, but a community supporting the development of visual culture in Ukraine through lectures and collaboration with art schools.
                            @else
                                Heute umfasst unser Katalog über 1.200 einzigartige Artbooks. Wir sind nicht mehr nur ein Geschäft, sondern eine Gemeinschaft, die die Entwicklung der visuellen Kultur in der Ukraine durch Vorträge und die Zusammenarbeit mit Kunstschulen unterstützt.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-24 relative overflow-hidden border-b border-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-black text-white uppercase tracking-tighter mb-4">@if(app()->getLocale() == 'uk') Чому Обирають Нас @elseif(app()->getLocale() == 'en') Why Choose Us @else Warum uns wählen @endif</h2>
                <div class="h-1 w-20 bg-indigo-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="about-feature-card about-feature-card-soft bg-gray-900/50 p-10 rounded-[2.5rem] border border-gray-800 hover:border-indigo-500/50 transition duration-500 group">
                    <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-4">@if(app()->getLocale() == 'uk') Безкомпромісна якість @elseif(app()->getLocale() == 'en') Uncompromising Quality @else Kompromisslose Qualität @endif</h3>
                    <p class="about-feature-card-text text-gray-400 leading-relaxed text-sm">
                        @if(app()->getLocale() == 'uk') Кожен артбук у нашому асортименті проходить ретельну перевірку на наявність виробничих дефектів. Ми гарантуємо ідеальний стан видань. @elseif(app()->getLocale() == 'en') Every artbook in our range undergoes rigorous inspection for manufacturing defects. We guarantee the perfect condition of publications. @else Jedes Artbook in unserem Sortiment wird einer strengen Prüfung auf Herstellungsfehler unterzogen. Wir garantieren den einwandfreien Zustand der Publikationen. @endif
                    </p>
                </div>

                <div class="about-feature-card about-feature-card-soft bg-gray-900/50 p-10 rounded-[2.5rem] border border-gray-800 hover:border-indigo-500/50 transition duration-500 group">
                    <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-4">@if(app()->getLocale() == 'uk') Експертне пакування @elseif(app()->getLocale() == 'en') Expert Packaging @else Expertenverpackung @endif</h3>
                    <p class="about-feature-card-text text-gray-400 leading-relaxed text-sm">
                        @if(app()->getLocale() == 'uk') Ми розробили власну багаторівневу систему захисту книг під час транспортування, що мінімізує будь-які ризики пошкоджень. @elseif(app()->getLocale() == 'en') We have developed our own multi-level book protection system during transportation, which minimizes any risk of damage. @else Wir haben unser eigenes mehrstufiges Buchschutzsystem während des Transports entwickelt, das jedes Schadensrisiko minimiert. @endif
                    </p>
                </div>

                <div class="about-feature-card about-feature-card-soft bg-gray-900/50 p-10 rounded-[2.5rem] border border-gray-800 hover:border-indigo-500/50 transition duration-500 group">
                    <h3 class="text-xl font-black text-white uppercase tracking-tighter mb-4">@if(app()->getLocale() == 'uk') Професійний підхід @elseif(app()->getLocale() == 'en') Professional Approach @else Professioneller Ansatz @endif</h3>
                    <p class="about-feature-card-text text-gray-400 leading-relaxed text-sm">
                        @if(app()->getLocale() == 'uk') Наш досвід дозволяє нам забезпечувати найвищий рівень сервісу: від професійної консультації до допомоги у пошуку рідкісних видань. @elseif(app()->getLocale() == 'en') Our experience allows us to provide the highest level of service: from professional consultation to assistance in finding rare publications. @else Unsere Erfahrung ermöglicht es uns, ein Höchstmaß an Service zu bieten: von der professionellen Beratung bis hin zur Unterstützung bei der Suche nach seltenen Publikationen. @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="about-cta-preserve-dark bg-indigo-600 rounded-[3rem] p-12 lg:p-20 text-center relative overflow-hidden shadow-2xl shadow-indigo-500/20">
            <div class="relative z-10">
                <h2 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter mb-8">@if(app()->getLocale() == 'uk') Маєте запитання? @elseif(app()->getLocale() == 'en') Have Questions? @else Haben Sie Fragen? @endif</h2>
                <p class="text-indigo-100 text-xl max-w-2xl mx-auto mb-12">
                    @if(app()->getLocale() == 'uk') Ми завжди раді надати фахову консультацію або допомогти з вибором ідеального артбуку для вашої колекції. @elseif(app()->getLocale() == 'en') We are always happy to provide professional advice or help you choose the perfect artbook for your collection. @else Wir freuen uns immer, professionelle Beratung anzubieten oder Ihnen bei der Auswahl des perfekten Artbooks für Ihre Sammlung zu helfen. @endif
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('chat') }}" class="bg-white text-indigo-600 px-10 py-5 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-gray-100 transition shadow-xl">
                        @if(app()->getLocale() == 'uk') Написати нам @elseif(app()->getLocale() == 'en') Message Us @else Nachricht an uns @endif
                    </a>
                    <a href="{{ route('catalog') }}" class="bg-indigo-700 text-white px-10 py-5 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-800 transition border border-indigo-500/30">
                        {{ __('messages.catalog') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
