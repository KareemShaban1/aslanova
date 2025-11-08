<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            // Drop and re-add the column as nullable
            $table->dropColumn('url');
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('url')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('advertisements', function (Blueprint $table) {
            $table->dropColumn('url');
        });

        Schema::table('advertisements', function (Blueprint $table) {
            $table->string('url')->after('image');
        });
    }
};