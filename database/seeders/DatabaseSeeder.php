<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
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

        $categories = [
            ['name' => 'Аніме', 'slug' => 'anime'],
            ['name' => 'Відеоігри', 'slug' => 'video-games'],
            ['name' => 'Хорор', 'slug' => 'horror'],
            ['name' => 'Комікси', 'slug' => 'comics'],
            ['name' => 'Інші', 'slug' => 'others'],
        ];

        $categoryIds = [];
        foreach ($categories as $cat) {
            $category = Category::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name']]
            );
            $categoryIds[$cat['slug']] = $category->id;
        }

        $products = [
            [
                'category_slug' => 'anime',
                'name' => 'Мистецтво Віднесених привидами',
                'slug' => 'art-of-spirited-away',
                'author' => 'Хаяо Міядзакі',
                'description' => 'Прекрасна колекція концепт-артів з шедевра студії Ghibli.',
                'price' => 45.00,
                'stock' => 10,
                'is_new' => true,
                'is_popular' => true,
            ],
            [
                'category_slug' => 'video-games',
                'name' => 'Мистецтво Elden Ring',
                'slug' => 'art-of-elden-ring',
                'author' => 'FromSoftware',
                'description' => 'Офіційний артбук гри року.',
                'price' => 55.00,
                'stock' => 5,
                'is_new' => true,
                'is_popular' => true,
            ],
            [
                'category_slug' => 'horror',
                'name' => 'Артбук Джюндзі Іто',
                'slug' => 'junji-ito-artbook',
                'author' => 'Джюндзі Іто',
                'description' => 'Моторошні ілюстрації від майстра хорору.',
                'price' => 40.00,
                'stock' => 0,
                'is_new' => false,
                'is_popular' => true,
            ],
        ];

        foreach ($products as $prod) {
            $categorySlug = $prod['category_slug'];
            unset($prod['category_slug']);

            Product::firstOrCreate(
                ['slug' => $prod['slug']],
                array_merge($prod, ['category_id' => $categoryIds[$categorySlug]])
            );
        }
    }
}
