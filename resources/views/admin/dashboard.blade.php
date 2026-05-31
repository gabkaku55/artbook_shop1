@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-950 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12">
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-gray-900 rounded-3xl shadow-xl border border-gray-800 overflow-hidden sticky top-24">
                    <div class="p-8 border-b border-gray-800 font-black text-white uppercase tracking-widest text-sm bg-gray-800/50">Панель керування</div>
                    <nav class="p-6 space-y-2">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-5 py-4 rounded-2xl transition font-bold {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fas fa-th-large mr-4 w-5"></i> Головна
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center px-5 py-4 rounded-2xl transition font-bold {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fas fa-tags mr-4 w-5"></i> Категорії
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center px-5 py-4 rounded-2xl transition font-bold {{ request()->routeIs('admin.products.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fas fa-book mr-4 w-5"></i> Артбуки
                        </a>
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center px-5 py-4 rounded-2xl transition font-bold {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fas fa-shopping-bag mr-4 w-5"></i> Замовлення
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-5 py-4 rounded-2xl transition font-bold {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fas fa-users mr-4 w-5"></i> Користувачі
                        </a>
                        <a href="{{ route('admin.unboxing-videos.index') }}" class="flex items-center px-5 py-4 rounded-2xl transition font-bold {{ request()->routeIs('admin.unboxing-videos.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fas fa-video mr-4 w-5"></i> Відео розпаковок
                        </a>
                        <a href="{{ route('admin.profile') }}" class="flex items-center px-5 py-4 rounded-2xl transition font-bold {{ request()->routeIs('admin.profile') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fas fa-user-shield mr-4 w-5"></i> Профіль
                        </a>
                        <a href="{{ route('admin.chat.index') }}" class="flex items-center px-5 py-4 rounded-2xl transition font-bold {{ request()->routeIs('admin.chat.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fas fa-comments mr-4 w-5"></i> Повідомлення
                        </a>
                    </nav>
                </div>
            </aside>

            <div class="flex-grow">
                @yield('admin_content')

                @if(request()->routeIs('admin.dashboard'))
                    <div class="bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-800 p-12 relative overflow-hidden mb-12">
                        <div class="relative z-10">
                            <h3 class="text-3xl font-black text-white mb-6 tracking-tighter uppercase">Ласкаво просимо, Адмін</h3>
                            <p class="text-gray-400 text-lg leading-relaxed max-w-2xl">
                                Це центральний хаб керування вашим магазином. Використовуйте бічне меню для доступу до всіх розділів сайту. Будьте уважні при редагуванні цін та залишків на складі.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                        <div class="bg-gray-900 p-8 rounded-3xl shadow-xl border border-gray-800">
                            <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mb-2">Замовлення</p>
                            <p class="text-4xl font-black text-white leading-none">{{ $stats['orders_count'] }}</p>
                        </div>
                        <div class="bg-gray-900 p-8 rounded-3xl shadow-xl border border-gray-800">
                            <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mb-2">Артбуки</p>
                            <p class="text-4xl font-black text-white leading-none">{{ $stats['products_count'] }}</p>
                        </div>
                        <div class="bg-gray-900 p-8 rounded-3xl shadow-xl border border-gray-800">
                            <p class="text-[10px] text-gray-500 font-black uppercase tracking-widest mb-2">Користувачі</p>
                            <p class="text-4xl font-black text-white leading-none">{{ $stats['users_count'] }}</p>
                        </div>
                    </div>

                    <div class="bg-indigo-600 p-10 rounded-[2.5rem] shadow-2xl shadow-indigo-500/20 mb-12 border border-indigo-500/30 relative overflow-hidden group">
                        <div class="relative z-10">
                            <p class="text-xs font-black text-indigo-100 uppercase tracking-[0.3em] mb-4">Загальний дохід магазину</p>
                            <p class="text-5xl md:text-6xl font-black text-white tracking-tighter">{{ number_format($stats['total_revenue'], 2) }} грн</p>
                        </div>
                    </div>

                    <div class="space-y-8 mb-12">
                        <div class="bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-800 p-8 relative overflow-hidden">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-black text-white uppercase tracking-widest">Дохід за останні 30 днів</h3>
                            </div>
                            <canvas id="revenueChart" class="w-full h-64"></canvas>
                        </div>
                        <div class="bg-gray-900 rounded-[2.5rem] shadow-xl border border-gray-800 p-8 relative overflow-hidden">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-black text-white uppercase tracking-widest">Статуси замовлень</h3>
                            </div>
                            <canvas id="statusChart" class="w-full h-64"></canvas>
                        </div>
                    </div>

                    @if($lowStockProducts->count() > 0)
                        <div class="mt-12">
                            <h3 class="text-2xl font-black text-white mb-6 flex items-center text-red-500 uppercase tracking-tighter">
                                <i class="fas fa-exclamation-triangle mr-3"></i>
                                Критично мало на складі
                            </h3>
                            <div class="bg-gray-900 rounded-3xl border border-red-900/30 overflow-hidden shadow-xl shadow-red-500/5">
                                <table class="w-full text-left">
                                    <thead class="bg-red-900/10 border-b border-red-900/20">
                                        <tr>
                                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-red-400">Товар</th>
                                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-red-400">Залишок</th>
                                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-red-400"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @foreach($lowStockProducts as $product)
                                            <tr class="hover:bg-gray-800/50 transition">
                                                <td class="px-8 py-6">
                                                    <div class="flex items-center">
                                                        @if($product->image_url)
                                                            <img src="{{ $product->image_url }}" class="w-10 h-10 rounded-lg object-cover mr-4">
                                                        @endif
                                                        <span class="text-white font-bold">{{ $product->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-6">
                                                    <span class="bg-red-900/30 text-red-400 px-4 py-1.5 rounded-full font-black text-xs border border-red-500/20">
                                                        {{ $product->stock }} шт.
                                                    </span>
                                                </td>
                                                <td class="px-8 py-6 text-right">
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-400 hover:text-white font-bold text-xs uppercase tracking-widest">Редагувати</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

@if(request()->routeIs('admin.dashboard'))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const revenueLabels = @json($revenueDates ?? []);
        const revenueData = @json($revenueValues ?? []);
        const statusLabels = @json($statusLabels ?? []);
        const statusData = @json($statusCounts ?? []);

        if (document.getElementById('revenueChart') && revenueLabels.length > 0) {
            const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctxRevenue, {
                type: 'line',
                data: {
                    labels: revenueLabels,
                    datasets: [{
                        label: 'Дохід за день, грн',
                        data: revenueData,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.25)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointRadius: 3,
                        pointBackgroundColor: '#a5b4fc'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#d1d5db',
                                font: { family: 'system-ui', size: 11, weight: 'bold' }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Дохід за останні 30 днів',
                            color: '#e5e7eb',
                            font: { size: 14, weight: 'bold' }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#9ca3af',
                                maxRotation: 0,
                                autoSkip: true
                            },
                            grid: {
                                color: 'rgba(31, 41, 55, 0.7)'
                            },
                            title: {
                                display: true,
                                text: 'Дата',
                                color: '#9ca3af',
                                font: { size: 11 }
                            }
                        },
                        y: {
                            ticks: {
                                color: '#9ca3af',
                                callback: value => value + ' грн'
                            },
                            grid: {
                                color: 'rgba(31, 41, 55, 0.7)'
                            },
                            title: {
                                display: true,
                                text: 'Сума замовлень, грн',
                                color: '#9ca3af',
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        }

        if (document.getElementById('statusChart') && statusLabels.length > 0) {
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'bar',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        label: 'Кількість замовлень',
                        data: statusData,
                        backgroundColor: [
                            'rgba(245, 158, 11, 0.7)',
                            'rgba(34, 197, 94, 0.7)',
                            'rgba(129, 140, 248, 0.7)',
                            'rgba(249, 115, 22, 0.7)',
                            'rgba(59, 130, 246, 0.7)',
                        ],
                        borderColor: [
                            'rgba(245, 158, 11, 1)',
                            'rgba(34, 197, 94, 1)',
                            'rgba(129, 140, 248, 1)',
                            'rgba(249, 115, 22, 1)',
                            'rgba(59, 130, 246, 1)',
                        ],
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#d1d5db',
                                font: { family: 'system-ui', size: 11, weight: 'bold' }
                            }
                        },
                        title: {
                            display: true,
                            text: 'Розподіл замовлень за статусами',
                            color: '#e5e7eb',
                            font: { size: 14, weight: 'bold' }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#9ca3af'
                            },
                            grid: {
                                color: 'rgba(31, 41, 55, 0.7)'
                            },
                            title: {
                                display: true,
                                text: 'Статус замовлення',
                                color: '#9ca3af',
                                font: { size: 11 }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#9ca3af',
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(31, 41, 55, 0.7)'
                            },
                            title: {
                                display: true,
                                text: 'Кількість замовлень',
                                color: '#9ca3af',
                                font: { size: 11 }
                            }
                        }
                    }
                }
            });
        }
    </script>
@endif

@endsection
