<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('paypal_payments', function (Blueprint $table) {
            $table->string('city')->nullable()->after('country');
            $table->string('house_number')->nullable()->after('street');
        });
    }

    public function down()
    {
        Schema::table('paypal_payments', function (Blueprint $table) {
            $table->dropColumn(['city', 'house_number']);
        });
    }
};