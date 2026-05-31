<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders_count' => Order::count(),
            'products_count' => Product::count(),
            'users_count' => User::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_price'),
        ];

        $startDate = Carbon::today()->subDays(29);
        $endDate = Carbon::today();

        $paidOrdersByDate = Order::where('status', 'paid')
            ->whereBetween('created_at', [$startDate->copy()->startOfDay(), $endDate->copy()->endOfDay()])
            ->get()
            ->groupBy(function (Order $order) {
                return $order->created_at->toDateString();
            });

        $revenueDates = [];
        $revenueValues = [];

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $key = $date->toDateString();
            $revenueDates[] = $date->format('d.m');
            $revenueValues[] = isset($paidOrdersByDate[$key])
                ? $paidOrdersByDate[$key]->sum('total_price')
                : 0;
        }
        $statusConfig = [
            'pending' => 'Очікує',
            'paid' => 'Оплачено',
            'confirmed' => 'Підтверджено',
            'processing' => 'Комплектація',
            'shipped' => 'Відправлено',
        ];
        $statusLabels = array_values($statusConfig);
        $statusCounts = [];
        foreach (array_keys($statusConfig) as $statusKey) {
            $statusCounts[] = Order::where('status', $statusKey)->count();
        }
        $lowStockProducts = Product::where('stock', '<', 5)->get();
        return view('admin.dashboard', compact(
            'stats',
            'lowStockProducts',
            'revenueDates',
            'revenueValues',
            'statusLabels',
            'statusCounts'
        ));
    }
}

