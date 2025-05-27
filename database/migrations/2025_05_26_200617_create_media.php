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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->uuid('uuid')->unique(); // Para referencias seguras
            $table->string('type'); // 'Logo','favicon',.
            $table->string('name'); // Nombre descriptivo del archivo
            $table->string('filename'); // Nombre original del archivo
            $table->string('path'); // Ruta relativa en el filesystem/storage
            $table->string('full_url'); // URL completa accesible públicamente
            $table->string('mime_type');
            $table->unsignedBigInteger('size'); // Tamaño en bytes
            $table->json('variations')->nullable(); // Para diferentes tamaños/versiones
            $table->string('disk')->default('public'); // Soporte para múltiples discos
            $table->string('checksum')->nullable(); // Para detectar duplicados
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
