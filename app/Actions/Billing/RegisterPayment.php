<?php

namespace App\Actions\Billing;

use App\Models\Client;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RegisterPayment
{
    /**
     * Registra un pago y extiende la vigencia de la tienda.
     *
     * Si la tienda está al día, los meses se suman desde su vencimiento actual
     * (no pierde días por pagar antes); si ya venció, desde hoy.
     */
    public function handle(Client $client, array $data, ?User $recordedBy = null): Payment
    {
        return DB::transaction(function () use ($client, $data, $recordedBy) {
            $today = now()->startOfDay();
            $currentEnd = $client->expires_at?->copy()->startOfDay();

            $periodStart = $currentEnd && $currentEnd->gte($today) ? $currentEnd : $today;
            $periodEnd = Carbon::parse($periodStart)->addMonthsNoOverflow((int) $data['months']);

            $planId = $data['plan_id'] ?? $client->plan_id;

            $payment = $client->payments()->create([
                'plan_id' => $planId,
                'recorded_by' => $recordedBy?->id,
                'amount' => $data['amount'],
                'months' => $data['months'],
                'method' => $data['method'],
                'reference' => $data['reference'] ?? null,
                'paid_at' => $data['paid_at'] ?? $today,
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'notes' => $data['notes'] ?? null,
            ]);

            $client->forceFill([
                'plan_id' => $planId,
                'expires_at' => $periodEnd,
                'billing_reminder_sent_on' => null,
            ])->save();

            return $payment;
        });
    }
}
