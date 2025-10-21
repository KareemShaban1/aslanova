<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('email_payments', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('payment_status'); // الحالة الافتراضية "pending"
            $table->string('shipping_price')->after('total')->nullable(); // سعر الشحن

        });
    }

    public function down()
    {
        Schema::table('email_payments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
