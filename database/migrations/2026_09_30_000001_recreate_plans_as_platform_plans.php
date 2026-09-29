<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Los planes pasan de ser registros por tienda (sin uso) a planes de la plataforma
     * que se asignan a cada tienda. Se recrea la tabla con planes iniciales editables.
     */
    public function up(): void
    {
        Schema::dropIfExists('plans');

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2); // Precio mensual en pesos
            $table->unsignedInteger('product_limit')->nullable(); // null = ilimitado
            $table->boolean('allows_custom_domain')->default(false);
            $table->boolean('active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();

        DB::table('plans')->insert([
            [
                'name' => 'Básico',
                'slug' => 'basico',
                'description' => 'Tienda en subdominio de QuickWeb con pedidos por WhatsApp.',
                'price' => 39000,
                'product_limit' => 20,
                'allows_custom_domain' => false,
                'active' => true,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Negocio',
                'slug' => 'negocio',
                'description' => 'Más productos y dominio propio.',
                'price' => 69000,
                'product_limit' => 100,
                'allows_custom_domain' => true,
                'active' => true,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pro',
                'slug' => 'pro',
                'description' => 'Productos ilimitados y dominio propio.',
                'price' => 119000,
                'product_limit' => null,
                'allows_custom_domain' => true,
                'active' => true,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('interval');
            $table->integer('product_limit')->nullable();
            $table->integer('storage_limit')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }
};
