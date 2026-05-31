<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $productsDrops = [];
        if (Schema::hasColumn('products', 'discount_percent')) {
            $productsDrops[] = 'discount_percent';
        }
        if (Schema::hasColumn('products', 'format')) {
            $productsDrops[] = 'format';
        }
        if (Schema::hasColumn('products', 'weight')) {
            $productsDrops[] = 'weight';
        }
        if (!empty($productsDrops)) {
            Schema::table('products', function (Blueprint $table) use ($productsDrops) {
                $table->dropColumn($productsDrops);
            });
        }

        if (Schema::hasColumn('orders', 'subtotal')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('subtotal');
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'discount_percent')) {
                $table->unsignedTinyInteger('discount_percent')->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'format')) {
                $table->string('format')->nullable()->after('pages');
            }
            if (!Schema::hasColumn('products', 'weight')) {
                $table->string('weight')->nullable()->after('format');
            }
        });

        if (!Schema::hasColumn('orders', 'subtotal')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('subtotal', 10, 2)->nullable()->after('total_price');
            });
        }
    }
};
