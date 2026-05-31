<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $alterations = [
            ['users', 'id', 'bigint unsigned', 'ID користувача'],
            ['users', 'name', 'varchar(255)', 'Ім\'я'],
            ['users', 'email', 'varchar(255)', 'Email'],
            ['users', 'password', 'varchar(255)', 'Пароль'],
            ['users', 'role', 'varchar(255)', 'Роль (user/admin)'],
            ['users', 'phone', 'varchar(255)', 'Телефон'],
            ['users', 'address', 'text', 'Адреса'],
            ['users', 'avatar', 'varchar(255)', 'Аватар'],
            ['sessions', 'user_id', 'bigint unsigned', 'ID користувача'],
            ['orders', 'user_id', 'bigint unsigned', 'ID користувача'],
            ['orders', 'total_price', 'decimal(10,2)', 'Підсумок (грн)'],
            ['orders', 'subtotal', 'decimal(10,2)', 'Проміжна сума (грн)'],
            ['orders', 'shipping_cost', 'decimal(10,2)', 'Вартість доставки (грн)'],
            ['orders', 'status', 'varchar(255)', 'Статус замовлення'],
            ['orders', 'payment_method', 'varchar(255)', 'Спосіб оплати'],
            ['orders', 'shipping_method', 'varchar(255)', 'Спосіб доставки'],
            ['orders', 'discount_amount', 'decimal(10,2)', 'Сума знижки (грн)'],
            ['orders', 'name', 'varchar(255)', 'Ім\'я покупця'],
            ['orders', 'last_name', 'varchar(255)', 'Прізвище покупця'],
            ['orders', 'email', 'varchar(255)', 'Email'],
            ['orders', 'phone', 'varchar(255)', 'Телефон'],
            ['orders', 'address', 'varchar(255)', 'Адреса доставки'],
            ['orders', 'zip_code', 'varchar(255)', 'Поштовий індекс'],
            ['orders', 'receipt_image', 'varchar(255)', 'Фото квитанції'],
            ['orders', 'hidden_for_admin', 'tinyint(1)', 'Приховано в адмінці'],
            ['order_items', 'order_id', 'bigint unsigned', 'ID замовлення'],
            ['order_items', 'product_id', 'bigint unsigned', 'ID товару'],
            ['order_items', 'quantity', 'int', 'Кількість'],
            ['order_items', 'price', 'decimal(10,2)', 'Ціна за одиницю (грн)'],
            ['products', 'category_id', 'bigint unsigned', 'ID категорії'],
            ['products', 'name', 'varchar(255)', 'Назва товару'],
            ['products', 'slug', 'varchar(255)', 'URL slug'],
            ['products', 'author', 'varchar(255)', 'Автор'],
            ['products', 'price', 'decimal(10,2)', 'Ціна (грн)'],
            ['products', 'stock', 'int', 'Залишок на складі'],
            ['products', 'image', 'varchar(255)', 'Зображення'],
            ['products', 'is_new', 'tinyint(1)', 'Новинка'],
            ['products', 'is_popular', 'tinyint(1)', 'Популярний'],
            ['categories', 'id', 'bigint unsigned', 'ID категорії'],
            ['categories', 'name', 'varchar(255)', 'Назва'],
            ['categories', 'slug', 'varchar(255)', 'URL slug'],
            ['reviews', 'product_id', 'bigint unsigned', 'ID товару'],
            ['reviews', 'user_id', 'bigint unsigned', 'ID користувача'],
            ['reviews', 'rating', 'tinyint', 'Оцінка (1-5)'],
            ['reviews', 'comment', 'text', 'Відгук'],
            ['messages', 'sender_id', 'bigint unsigned', 'ID відправника'],
            ['messages', 'receiver_id', 'bigint unsigned', 'ID отримувача'],
            ['messages', 'content', 'text', 'Текст повідомлення'],
            ['messages', 'is_read', 'tinyint(1)', 'Прочитано'],
            ['wishlists', 'user_id', 'bigint unsigned', 'ID користувача'],
            ['wishlists', 'product_id', 'bigint unsigned', 'ID товару'],
        ];

        $driver = Schema::getConnection()->getDriverName();

        foreach ($alterations as [$table, $column, $type, $comment]) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column)) {
                continue;
            }

            try {
                if ($driver === 'mysql') {
                    $commentEscaped = addslashes($comment);
                    DB::statement("ALTER TABLE `{$table}` MODIFY COLUMN `{$column}` {$type} COMMENT '{$commentEscaped}'");
                } elseif ($driver === 'pgsql') {
                    $commentEscaped = str_replace("'", "''", $comment);
                    DB::statement("COMMENT ON COLUMN \"{$table}\".\"{$column}\" IS '{$commentEscaped}'");
                }
            } catch (\Throwable) {
                continue;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
