<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtbooksManualSeeder extends Seeder
{
    public function run(): void
    {
        $games = Category::where('name_en', 'Video Games')->first();
        $anime = Category::where('name_en', 'Anime')->first();
        $horror = Category::where('name_en', 'Horror')->first();

        $defaultDescriptionUk = 'Офіційний артбук з ілюстраціями, концепт-артами та матеріалами створення.';
        $defaultDescriptionEn = 'Official artbook with illustrations, concept art and making-of materials.';
        $defaultDescriptionDe = 'Offizielles Artbook mit Illustrationen, Concept Art und Making-of-Materialien.';

        $items = [
            ['name' => 'Артбук Зоревир: Крізь всесвіт', 'price' => 900, 'category' => $games],
            ['name' => 'Лорбук NieR: Automata. Путівник світом', 'price' => 1200, 'category' => $games],
            ['name' => 'Артбук Українська магічна академія (Делюкс-видання)', 'price' => 1200, 'category' => $anime],
            ['name' => 'Артбук Українська магічна академія (Базове видання)', 'price' => 800, 'category' => $anime],
            ['name' => 'Артбук Химерні візії. Збірка ілюстрацій Джюнджі Іто', 'price' => 1200, 'category' => $horror],
            ['name' => 'Артбук Світ гри Death Stranding 2: On the Beach', 'price' => 1200, 'category' => $games],
            ['name' => 'Ілюстрована книга Mofusand. Робочі будні Нявкобратиків', 'price' => 250, 'category' => $anime],
            ['name' => 'Артбук Мистецтво й створення серіалу «Аркейн»', 'price' => 1290, 'category' => $anime],
            ['name' => 'Артбук Світ гри S.T.A.L.K.E.R. 2: Heart of Chornobyl', 'price' => 1200, 'category' => $games],
            ['name' => 'Артбук Євангеліон. Збірка ілюстрацій 2007–2017', 'price' => 950, 'category' => $anime],
            ['name' => 'Лорбук God of War: Перекази й легенди', 'price' => 795, 'category' => $games],
            ['name' => 'Артбук Bloodborne: Офіційні ілюстрації', 'price' => 1200, 'category' => $games],
            ['name' => 'Артбук Ігровий світ трилогії Total War: Warhammer', 'price' => 1200, 'category' => $games],
            ['name' => 'Артбук Світ гри Horizon Zero Dawn', 'price' => 950, 'category' => $games],
            ['name' => 'Артбук Світ гри Far Cry 6', 'price' => 810, 'category' => $games],
            ['name' => 'Артбук Український бестіарій', 'price' => 800, 'category' => $horror],
            ['name' => 'Артбук Створення світу гри Hogwarts Legacy', 'price' => 1200, 'category' => $games],
            ['name' => 'Артбук Світ гри God of War', 'price' => 650, 'category' => $games],
            ['name' => 'Артбук Ігровий світ трилогії Mass Effect', 'price' => 920, 'category' => $games],
            ['name' => 'Артбук Світ гри The Last of Us', 'price' => 750, 'category' => $games],
        ];

        foreach ($items as $item) {
            if (!$item['category']) {
                continue;
            }

            $nameUk = $item['name'];

            Product::updateOrCreate(
                ['slug' => Str::slug($nameUk)],
                [
                    'category_id' => $item['category']->id,
                    'name' => $nameUk,
                    'name_en' => $nameUk,
                    'name_de' => $nameUk,
                    'author' => null,
                    'author_en' => null,
                    'author_de' => null,
                    'description' => $defaultDescriptionUk,
                    'description_en' => $defaultDescriptionEn,
                    'description_de' => $defaultDescriptionDe,
                    'price' => $item['price'],
                    'stock' => 10,
                    'pages' => null,
                    'language' => 'uk',
                    'publisher' => null,
                    'age_limit' => null,
                    'image' => null,
                    'gallery' => [],
                    'is_new' => true,
                    'is_popular' => true,
                ]
            );
        }
    }
}
