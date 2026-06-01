<?php

declare(strict_types=1);

/**
 * Export catalog, users (password hashes), and reviews to database/data/catalog.json.
 * Run from shop/: php scripts/export-site-data.php
 */

$root = dirname(__DIR__);

require $root . '/vendor/autoload.php';

$app = require $root . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\UnboxingVideo;
use App\Models\User;
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
echo 'reviews: ' . count($export['reviews']) . PHP_EOL;
