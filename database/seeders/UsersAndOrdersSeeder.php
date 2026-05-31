<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersAndOrdersSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::where('stock', '>', 0)->get();
        if ($products->isEmpty()) {
            $this->command->warn('No products with stock found. Skipping orders.');
            return;
        }

        $usersData = [
            ['name' => 'Олександр Коваленко', 'email' => 'oleksandr.kovalenko@example.com'],
            ['name' => 'Марія Шевченко', 'email' => 'maria.shevchenko@example.com'],
            ['name' => 'Дмитро Бондаренко', 'email' => 'dmytro.bondarenko@example.com'],
            ['name' => 'Анна Мельник', 'email' => 'anna.melnyk@example.com'],
            ['name' => 'Ігор Петренко', 'email' => 'ihor.petrenko@example.com'],
        ];

        foreach ($usersData as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'user',
                ]
            );

            for ($i = 0; $i < 2; $i++) {
                $itemsCount = rand(1, 3);
                $orderProducts = $products->random(min($itemsCount, $products->count()));
                $totalPrice = 0;
                $orderItemsData = [];

                foreach ($orderProducts as $product) {
                    $qty = rand(1, 2);
                    $price = $product->price;
                    $totalPrice += $price * $qty;
                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'price' => $price,
                    ];
                }

                $statuses = ['pending', 'paid', 'shipped'];
                $shippingMethods = ['nova_poshta', 'ukrposhta', 'pickup'];
                $paymentMethods = ['card', 'cod', 'bank'];
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $totalPrice,
                    'discount_amount' => 0,
                    'status' => $statuses[array_rand($statuses)],
                    'shipping_method' => $shippingMethods[array_rand($shippingMethods)],
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'name' => $user->name,
                    'last_name' => '',
                    'email' => $user->email,
                    'phone' => '+38 (0' . rand(50, 99) . ') ' . rand(100, 999) . '-' . rand(10, 99) . '-' . rand(10, 99),
                    'address' => 'м. Київ, вул. Хрещатик, ' . rand(1, 100),
                    'zip_code' => (string) rand(10000, 99999),
                ]);

                foreach ($orderItemsData as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }
            }
        }

        $this->command->info('Created 5 users with 2 orders each.');
    }
}
