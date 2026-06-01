<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\UnboxingVideo;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CatalogImportSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'yanapampukha2006@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('qwerty1234'),
                'role' => 'admin',
                'phone' => '+38 (044) 123-45-67',
            ]
        );

        $path = database_path('data/catalog.json');
        if (! file_exists($path)) {
            $this->command?->warn('catalog.json not found, skipping catalog import.');

            return;
        }

        $data = json_decode(file_get_contents($path), true);
        if (! is_array($data)) {
            $this->command?->error('Invalid catalog.json');

            return;
        }

        $categoryIds = [];
        foreach ($data['categories'] ?? [] as $category) {
            $record = Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'name_en' => $category['name_en'] ?? null,
                    'name_de' => $category['name_de'] ?? null,
                ]
            );
            $categoryIds[$category['slug']] = $record->id;
        }

        foreach ($data['products'] ?? [] as $product) {
            $categorySlug = $product['category_slug'] ?? null;
            unset($product['category_slug']);

            if (! $categorySlug || ! isset($categoryIds[$categorySlug])) {
                continue;
            }

            $product['category_id'] = $categoryIds[$categorySlug];
            $product['is_new'] = (bool) ($product['is_new'] ?? false);
            $product['is_popular'] = (bool) ($product['is_popular'] ?? false);

            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }

        foreach ($data['unboxing_videos'] ?? [] as $video) {
            UnboxingVideo::updateOrCreate(
                ['video_path' => $video['video_path']],
                [
                    'title' => $video['title'],
                    'description' => $video['description'] ?? null,
                ]
            );
        }

        UnboxingVideo::syncLegacyDefaults();

        $this->importUsers($data['users'] ?? []);
        $this->importOrders($data['orders'] ?? [], $data['order_items'] ?? []);
        $this->importMessages($data['messages'] ?? []);
        $this->importWishlists($data['wishlists'] ?? []);
        $this->importReviews($data['reviews'] ?? []);
    }

    /**
     * @param  array<int, array<string, mixed>>  $users
     */
    private function importUsers(array $users): void
    {
        if ($users === []) {
            return;
        }

        $now = now();

        foreach ($users as $user) {
            $email = $user['email'] ?? null;
            $password = $user['password'] ?? null;
            if (! $email || ! $password) {
                continue;
            }

            $row = [
                'name' => $user['name'] ?? 'User',
                'last_name' => $user['last_name'] ?? null,
                'phone' => $user['phone'] ?? null,
                'address' => $user['address'] ?? null,
                'avatar' => $user['avatar'] ?? null,
                'role' => $user['role'] ?? 'user',
                'updated_at' => $now,
            ];

            $exists = DB::table('users')->where('email', $email)->exists();

            if ($exists) {
                DB::table('users')->where('email', $email)->update(array_merge($row, ['password' => $password]));
            } else {
                DB::table('users')->insert(array_merge($row, [
                    'email' => $email,
                    'password' => $password,
                    'created_at' => $now,
                ]));
            }
        }

        $this->command?->info('Imported '.count($users).' users.');
    }

    /**
     * @param  array<int, array<string, mixed>>  $reviews
     */
    private function importReviews(array $reviews): void
    {
        if ($reviews === []) {
            return;
        }

        $imported = 0;

        foreach ($reviews as $review) {
            $productId = Product::query()->where('slug', $review['product_slug'] ?? '')->value('id');
            $userId = DB::table('users')->where('email', $review['user_email'] ?? '')->value('id');

            if (! $productId || ! $userId) {
                continue;
            }

            Review::updateOrCreate(
                [
                    'product_id' => $productId,
                    'user_id' => $userId,
                ],
                [
                    'rating' => (int) ($review['rating'] ?? 5),
                    'comment' => $review['comment'] ?? '',
                ]
            );
            $imported++;
        }

        $this->command?->info("Imported {$imported} reviews.");
    }

    /**
     * @param  array<int, array<string, mixed>>  $orders
     * @param  array<int, array<string, mixed>>  $items
     */
    private function importOrders(array $orders, array $items): void
    {
        if ($orders === []) {
            return;
        }

        $orderMap = [];

        foreach ($orders as $order) {
            $userId = DB::table('users')->where('email', $order['user_email'] ?? '')->value('id');
            if (! $userId) {
                continue;
            }

            $createdAt = $order['created_at'] ?? now();

            $record = Order::updateOrCreate(
                [
                    'user_id' => $userId,
                    'created_at' => $createdAt,
                    'total_price' => $order['total_price'] ?? 0,
                ],
                [
                    'shipping_cost' => $order['shipping_cost'] ?? 0,
                    'discount_amount' => $order['discount_amount'] ?? 0,
                    'status' => $order['status'] ?? 'pending',
                    'hidden_for_admin' => (bool) ($order['hidden_for_admin'] ?? false),
                    'shipping_method' => $order['shipping_method'] ?? null,
                    'payment_method' => $order['payment_method'] ?? null,
                    'name' => $order['name'] ?? '',
                    'last_name' => $order['last_name'] ?? null,
                    'email' => $order['email'] ?? null,
                    'phone' => $order['phone'] ?? null,
                    'address' => $order['address'] ?? null,
                    'zip_code' => $order['zip_code'] ?? null,
                    'receipt_image' => $order['receipt_image'] ?? null,
                    'updated_at' => $order['updated_at'] ?? $createdAt,
                ]
            );

            if (isset($order['legacy_id'])) {
                $orderMap[(int) $order['legacy_id']] = $record->id;
            }
        }

        $importedItems = 0;

        foreach ($items as $item) {
            $orderId = $orderMap[(int) ($item['order_legacy_id'] ?? 0)] ?? null;
            $productId = Product::query()->where('slug', $item['product_slug'] ?? '')->value('id');

            if (! $orderId || ! $productId) {
                continue;
            }

            OrderItem::updateOrCreate(
                [
                    'order_id' => $orderId,
                    'product_id' => $productId,
                ],
                [
                    'quantity' => (int) ($item['quantity'] ?? 1),
                    'price' => $item['price'] ?? 0,
                ]
            );
            $importedItems++;
        }

        $this->command?->info('Imported '.count($orders).' orders and '.$importedItems.' order items.');
    }

    /**
     * @param  array<int, array<string, mixed>>  $messages
     */
    private function importMessages(array $messages): void
    {
        if ($messages === []) {
            return;
        }

        $imported = 0;

        foreach ($messages as $message) {
            $senderId = DB::table('users')->where('email', $message['sender_email'] ?? '')->value('id');
            $receiverId = DB::table('users')->where('email', $message['receiver_email'] ?? '')->value('id');

            if (! $senderId || ! $receiverId) {
                continue;
            }

            $createdAt = $message['created_at'] ?? now();

            Message::updateOrCreate(
                [
                    'sender_id' => $senderId,
                    'receiver_id' => $receiverId,
                    'created_at' => $createdAt,
                    'content' => $message['content'] ?? '',
                ],
                [
                    'is_read' => (bool) ($message['is_read'] ?? false),
                    'updated_at' => $message['updated_at'] ?? $createdAt,
                ]
            );
            $imported++;
        }

        $this->command?->info("Imported {$imported} chat messages.");
    }

    /**
     * @param  array<int, array<string, mixed>>  $wishlists
     */
    private function importWishlists(array $wishlists): void
    {
        if ($wishlists === []) {
            return;
        }

        $imported = 0;

        foreach ($wishlists as $wishlist) {
            $userId = DB::table('users')->where('email', $wishlist['user_email'] ?? '')->value('id');
            $productId = Product::query()->where('slug', $wishlist['product_slug'] ?? '')->value('id');

            if (! $userId || ! $productId) {
                continue;
            }

            Wishlist::updateOrCreate(
                [
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]
            );
            $imported++;
        }

        $this->command?->info("Imported {$imported} wishlist items.");
    }
}
