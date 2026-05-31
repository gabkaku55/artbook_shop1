<footer class="bg-gray-950 text-white py-12 border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-2xl font-bold text-indigo-400 mb-4" style="font-family: 'Brush Script MT', cursive;">Artbook Shop</h3>
                <p class="text-gray-400 max-w-sm">
                    Найкраща колекція артбуків з аніме, відеоігор, хорору та коміксів. Досліджуйте красу ваших улюблених історій.
                </p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">{{ __('messages.home') }}</h4>
                <ul class="space-y-2">
                    @if(!auth()->check() || auth()->user()->role !== 'admin')
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">{{ __('messages.home') }}</a></li>
                        <li><a href="{{ route('catalog') }}" class="text-gray-400 hover:text-white transition">{{ __('messages.catalog') }}</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition">{{ __('messages.about') }}</a></li>
                        <li><a href="{{ route('delivery') }}" class="text-gray-400 hover:text-white transition">{{ __('messages.delivery') }}</a></li>
                    @else
                        <li><a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white transition">{{ __('messages.admin_panel') }}</a></li>
                    @endif
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Контакти</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><i class="fas fa-envelope mr-2"></i> artbook1@gmail.com</li>
                    <li><i class="fas fa-phone mr-2"></i> +38 (044) 123-45-67</li>
                    <li><i class="fas fa-map-marker-alt mr-2"></i> Київ, Україна</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
            <p>&copy; {{ date('Y') }} Artbook Shop. Всі права захищені.</p>
        </div>
    </div>
</footer>
