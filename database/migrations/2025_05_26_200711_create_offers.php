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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('discount', 5, 2)->nullable(); // Porcentaje
            $table->decimal('discount_amount', 10, 2)->nullable(); // Monto fijo
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->enum('type', ['percentage', 'fixed_amount', 'buy_x_get_y'])->default('percentage');
            $table->string('promo_code')->nullable()->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
