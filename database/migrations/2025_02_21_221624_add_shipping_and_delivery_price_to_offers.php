<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->string(column: 'shipping_price')->after('price')->nullable(); // سعر الشحن
            $table->string('delivery_price')->after('shipping_price')->nullable(); // سعر التوصيل
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['shipping_price', 'delivery_price']);
        });
    }
};
