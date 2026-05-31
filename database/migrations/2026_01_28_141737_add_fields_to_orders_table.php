<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('name');
            $table->string('address')->nullable()->after('phone');
            $table->string('zip_code')->nullable()->after('address');
            $table->string('payment_method')->nullable()->after('shipping_method');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['last_name', 'address', 'zip_code', 'payment_method', 'discount_amount']);
        });
    }
};
