<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('plan_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $table->string('custom_domain')->nullable()->unique()->after('domain');
            // Evita enviar el mismo recordatorio de cobro dos veces el mismo día
            $table->date('billing_reminder_sent_on')->nullable()->after('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn(['plan_id', 'custom_domain', 'billing_reminder_sent_on']);
        });
    }
};
