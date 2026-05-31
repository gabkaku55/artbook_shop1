<header class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50" x-data="{ searchOpen: false, menuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center lg:hidden">
                <button @click="menuOpen = !menuOpen" class="p-2 text-gray-300 hover:text-indigo-400 focus:outline-none transition" aria-label="Меню">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-400" style="font-family: 'Brush Script MT', cursive;">
                    Artbook Shop
                </a>
            </div>

            <div class="hidden lg:flex space-x-8 items-center">
                @if(!auth()->check() || auth()->user()->role !== 'admin')
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-indigo-400 transition">{{ __('messages.home') }}</a>
                    <a href="{{ route('catalog') }}" class="text-gray-300 hover:text-indigo-400 transition">{{ __('messages.catalog') }}</a>
                    <a href="{{ route('about') }}" class="text-gray-300 hover:text-indigo-400 transition">{{ __('messages.about') }}</a>
                    <a href="{{ route('delivery') }}" class="text-gray-300 hover:text-indigo-400 transition">{{ __('messages.delivery') }}</a>
                    <a href="{{ route('contacts') }}" class="text-gray-300 hover:text-indigo-400 transition">{{ __('messages.contacts') }}</a>
                @else
                    <span class="text-indigo-400 font-black uppercase tracking-widest text-sm">Панель адміністратора</span>
                @endif
                @auth
                    @if(auth()->user()->role !== 'admin')
                        <a href="{{ route('chat') }}" class="text-indigo-400 hover:text-indigo-300 font-bold transition flex items-center">
                            <i class="fas fa-comment-dots mr-2"></i> {{ __('messages.chat') }}
                        </a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center space-x-4">
                <button type="button" class="theme-toggle-btn" data-theme-toggle aria-label="Switch theme">
                    <i class="fas fa-moon theme-icon-moon" aria-hidden="true"></i>
                    <i class="fas fa-sun theme-icon-sun" aria-hidden="true" hidden></i>
                </button>
                <div class="relative" x-data="{ langOpen: false }">
                    <button @click="langOpen = !langOpen" class="flex items-center text-gray-300 hover:text-indigo-400 focus:outline-none">
                        <span class="uppercase">{{ app()->getLocale() }}</span>
                        <i class="fas fa-chevron-down text-xs ml-1"></i>
                    </button>
                    <div x-show="langOpen" @click.away="langOpen = false" class="absolute right-0 mt-2 w-32 bg-gray-800 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5" x-cloak>
                        <a href="{{ route('lang.switch', 'uk') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Українська</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">English</a>
                        <a href="{{ route('lang.switch', 'de') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">German</a>
                    </div>
                </div>

                @if(!auth()->check() || auth()->user()->role !== 'admin')
                    <a href="{{ route('wishlist.index') }}" class="text-gray-400 hover:text-red-500 transition relative">
                        <i class="far fa-heart text-xl"></i>
                        @auth
                            @if(auth()->user()->wishlist->count() > 0)
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-[8px] font-black rounded-full h-4 w-4 flex items-center justify-center border border-gray-800">
                                    {{ auth()->user()->wishlist->count() }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    <button @click="searchOpen = !searchOpen" class="text-gray-400 hover:text-indigo-400 focus:outline-none">
                        <i class="fas fa-search text-xl"></i>
                    </button>

                    <a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-indigo-400 relative">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                @endif

                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-300 hover:text-indigo-400 focus:outline-none">
                            <span class="mr-2">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5" x-cloak>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.profile') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">{{ __('messages.my_profile') }}</a>
                            @else
                                <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">{{ __('messages.my_profile') }}</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">{{ __('messages.logout') }}</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-indigo-400">{{ __('messages.login') }}</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">{{ __('messages.register') }}</a>
                @endauth
            </div>
        </div>
    </div>

    <div x-show="menuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-full" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-full" @click.away="menuOpen = false" class="fixed inset-y-0 left-0 w-64 bg-gray-900 border-r border-gray-800 shadow-2xl z-50 lg:hidden pt-20 pb-8 px-6 overflow-y-auto" x-cloak>
        <nav class="flex flex-col gap-2">
            @if(!auth()->check() || auth()->user()->role !== 'admin')
                <a href="{{ route('home') }}" class="py-3 px-4 text-gray-300 hover:text-indigo-400 hover:bg-gray-800 rounded-xl transition" @click="menuOpen = false">{{ __('messages.home') }}</a>
                <a href="{{ route('catalog') }}" class="py-3 px-4 text-gray-300 hover:text-indigo-400 hover:bg-gray-800 rounded-xl transition" @click="menuOpen = false">{{ __('messages.catalog') }}</a>
                <a href="{{ route('about') }}" class="py-3 px-4 text-gray-300 hover:text-indigo-400 hover:bg-gray-800 rounded-xl transition" @click="menuOpen = false">{{ __('messages.about') }}</a>
                <a href="{{ route('delivery') }}" class="py-3 px-4 text-gray-300 hover:text-indigo-400 hover:bg-gray-800 rounded-xl transition" @click="menuOpen = false">{{ __('messages.delivery') }}</a>
                <a href="{{ route('contacts') }}" class="py-3 px-4 text-gray-300 hover:text-indigo-400 hover:bg-gray-800 rounded-xl transition" @click="menuOpen = false">{{ __('messages.contacts') }}</a>
            @else
                <span class="py-3 px-4 text-indigo-400 font-black uppercase tracking-widest text-sm">Панель адміністратора</span>
            @endif
            @auth
                @if(auth()->user()->role !== 'admin')
                    <a href="{{ route('chat') }}" class="py-3 px-4 text-indigo-400 hover:text-indigo-300 font-bold hover:bg-gray-800 rounded-xl transition flex items-center" @click="menuOpen = false">
                        <i class="fas fa-comment-dots mr-2"></i> {{ __('messages.chat') }}
                    </a>
                @endif
            @endauth
        </nav>
    </div>
    <div x-show="menuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="menuOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-cloak aria-hidden="true"></div>

    <div x-show="searchOpen" x-transition class="bg-gray-900 border-t border-gray-800 py-4" x-cloak>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('catalog') }}" method="GET" class="flex">
                <input type="text" name="search" placeholder="{{ __('messages.search_placeholder') }}" class="w-full px-4 py-2 rounded-l-md bg-gray-800 border-gray-700 text-white focus:ring-indigo-500 focus:border-indigo-500">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-r-md hover:bg-indigo-700">{{ __('messages.search') }}</button>
            </form>
        </div>
    </div>
</header>
