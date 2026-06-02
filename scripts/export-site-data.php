<?php

declare(strict_types=1);

$root = dirname(__DIR__);

require $root . '/vendor/autoload.php';

$app = require $root . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Product;
use App\Models\UnboxingVideo;
use Illuminate\Support\Facades\DB;

$outputPath = $root . '/database/data/catalog.json';

$users = DB::table('users')
    ->select('name', 'last_name', 'email', 'phone', 'address', 'avatar', 'role', 'password')
    ->orderBy('id')
    ->get()
    ->map(fn ($u) => (array) $u)
    ->all();

$reviews = DB::table('reviews as r')
    ->join('products as p', 'p.id', '=', 'r.product_id')
    ->join('users as u', 'u.id', '=', 'r.user_id')
    ->select('p.slug as product_slug', 'u.email as user_email', 'r.rating', 'r.comment')
    ->orderBy('r.id')
    ->get()
    ->map(fn ($r) => (array) $r)
    ->all();

$orders = DB::table('orders as o')
    ->join('users as u', 'u.id', '=', 'o.user_id')
    ->select(
        'o.id as legacy_id',
        'u.email as user_email',
        'o.total_price',
        'o.shipping_cost',
        'o.discount_amount',
        'o.status',
        'o.hidden_for_admin',
        'o.shipping_method',
        'o.payment_method',
        'o.name',
        'o.last_name',
        'o.email',
        'o.phone',
        'o.address',
        'o.zip_code',
        'o.receipt_image',
        'o.created_at',
        'o.updated_at'
    )
    ->orderBy('o.id')
    ->get()
    ->map(fn ($o) => (array) $o)
    ->all();

$orderItems = DB::table('order_items as oi')
    ->join('orders as o', 'o.id', '=', 'oi.order_id')
    ->join('products as p', 'p.id', '=', 'oi.product_id')
    ->select('o.id as order_legacy_id', 'p.slug as product_slug', 'oi.quantity', 'oi.price')
    ->orderBy('oi.id')
    ->get()
    ->map(fn ($i) => (array) $i)
    ->all();

$messages = DB::table('messages as m')
    ->join('users as s', 's.id', '=', 'm.sender_id')
    ->join('users as r', 'r.id', '=', 'm.receiver_id')
    ->select(
        's.email as sender_email',
        'r.email as receiver_email',
        'm.content',
        'm.is_read',
        'm.created_at',
        'm.updated_at'
    )
    ->orderBy('m.id')
    ->get()
    ->map(fn ($m) => (array) $m)
    ->all();

$wishlists = DB::table('wishlists as w')
    ->join('users as u', 'u.id', '=', 'w.user_id')
    ->join('products as p', 'p.id', '=', 'w.product_id')
    ->select('u.email as user_email', 'p.slug as product_slug')
    ->orderBy('w.id')
    ->get()
    ->map(fn ($w) => (array) $w)
    ->all();

$export = [
    'categories' => Category::query()
        ->select('name', 'name_en', 'name_de', 'slug')
        ->orderBy('id')
        ->get()
        ->toArray(),
    'products' => Product::query()
        ->with('category:id,slug')
        ->orderBy('id')
        ->get()
        ->map(function (Product $p) {
            $row = $p->only([
                'name', 'name_en', 'name_de', 'slug', 'author', 'author_en', 'author_de',
                'description', 'description_en', 'description_de', 'price', 'sale_price',
                'stock', 'pages', 'language', 'publisher', 'age_limit', 'cover_type',
                'image', 'gallery', 'is_new', 'is_popular',
            ]);
            $row['category_slug'] = $p->category?->slug;
            $row['gallery'] = is_string($row['gallery'] ?? null)
                ? json_decode($row['gallery'], true)
                : ($row['gallery'] ?? null);

            return $row;
        })
        ->all(),
    'unboxing_videos' => UnboxingVideo::query()
        ->select('title', 'description', 'video_path')
        ->orderBy('id')
        ->get()
        ->toArray(),
    'users' => $users,
    'orders' => $orders,
    'order_items' => $orderItems,
    'messages' => $messages,
    'wishlists' => $wishlists,
    'reviews' => $reviews,
];

$dir = dirname($outputPath);
if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}

file_put_contents($outputPath, json_encode($export, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo 'Exported to ' . $outputPath . PHP_EOL;
echo 'categories: ' . count($export['categories']) . PHP_EOL;
echo 'products: ' . count($export['products']) . PHP_EOL;
echo 'unboxing_videos: ' . count($export['unboxing_videos']) . PHP_EOL;
echo 'users: ' . count($export['users']) . PHP_EOL;
echo 'orders: ' . count($export['orders']) . PHP_EOL;
echo 'order_items: ' . count($export['order_items']) . PHP_EOL;
echo 'messages: ' . count($export['messages']) . PHP_EOL;
echo 'wishlists: ' . count($export['wishlists']) . PHP_EOL;
echo 'reviews: ' . count($export['reviews']) . PHP_EOL;
