<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::where('role', 'user')->pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        if (empty($userIds) || empty($productIds)) {
            return;
        }

        $comments = [
            ['Артбук перевершив очікування, багато ексклюзивних ілюстрацій.', 5],
            ['Чудове оформлення, ідеально для колекції.', 5],
            ['Папір щільний, нічого не просвічується — топ.', 4],
            ['Багато концепт-артів, яких не було в мережі.', 5],
            ['Класний подарунок для фанатів, виглядає дорого.', 4],
            ['Все прийшло добре запаковане, без пошкоджень.', 5],
            ['Ціна повністю відповідає якості.', 4],
            ['Дуже надихає, постійно переглядаю.', 5],
            ['Опис від авторів додає цінності артбуку.', 4],
            ['Очікувала більше сторінок за таку ціну.', 3],
            ['Деякі ілюстрації вже бачила онлайн, нічого нового.', 2],
            ['Обкладинка гарна, але всередині слабший контент.', 3],
            ['Друк нормальний, але кольори трохи тьмяні.', 3],
            ['Для новачків цікаво, але фанатам може бути нудно.', 3],
            ['Ціна завищена, як на такий обсяг.', 2],
            ['Є повтори ілюстрацій, що трохи розчарувало.', 3],
            ['Очікувала більше текстових пояснень до робіт.', 2],
            ['Кути були трохи пом\'яті після доставки.', 3],
            ['Не погано, але вдруге б не купувала.', 2],
        ];

        foreach ($comments as $index => $item) {
            $text = $item[0];
            $rating = $item[1];
            $productId = $productIds[$index % count($productIds)];
            $userId = $userIds[$index % count($userIds)];

            Review::firstOrCreate(
                [
                    'product_id' => $productId,
                    'user_id' => $userId,
                    'comment' => $text,
                ],
                ['rating' => $rating]
            );
        }
    }
}