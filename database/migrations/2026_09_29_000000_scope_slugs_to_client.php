<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Los slugs de categorías y productos deben ser únicos por tienda, no globales.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->unique(['client_id', 'slug']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->unique(['client_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['client_id', 'slug']);
            $table->unique('slug');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['client_id', 'slug']);
            $table->unique('slug');
        });
    }
};
