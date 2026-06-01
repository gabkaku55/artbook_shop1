<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\UnboxingVideo;
use App\Models\User;
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
}
