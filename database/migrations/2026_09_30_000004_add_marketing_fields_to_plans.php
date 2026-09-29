<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Características que la landing muestra por plan (una por línea) y plan destacado.
     * El límite de productos y el dominio se muestran a partir de sus propios campos.
     */
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->text('features')->nullable()->after('description');
            $table->boolean('highlighted')->default(false)->after('allows_custom_domain');
        });

        $features = [
            'basico' => "Carrito con pedidos por WhatsApp\nPágina propia para cada producto\nOfertas y códigos promocionales\nPanel de administración fácil de usar\nHosting y certificado SSL incluidos",
            'negocio' => "Todo lo del plan Básico\nIdeal para catálogos medianos",
            'pro' => "Todo lo del plan Negocio\nPara catálogos grandes sin límites",
        ];

        foreach ($features as $slug => $text) {
            DB::table('plans')->where('slug', $slug)->update(['features' => $text]);
        }

        DB::table('plans')->where('slug', 'negocio')->update(['highlighted' => true]);
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['features', 'highlighted']);
        });
    }
};
