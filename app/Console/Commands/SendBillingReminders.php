<?php

namespace App\Console\Commands;

use App\Mail\AdminBillingDigestMail;
use App\Mail\BillingReminderMail;
use App\Models\Client;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBillingReminders extends Command
{
    protected $signature = 'quickweb:billing-reminders';

    protected $description = 'Envía recordatorios de vencimiento a los dueños de tienda y un resumen al administrador';

    public function handle(): int
    {
        $clients = Client::with(['plan', 'user', 'siteSettings'])
            ->where('active', true)
            ->whereNotNull('expires_at')
            ->get();

        $reminderDays = config('quickweb.billing.reminder_days');
        $sent = 0;

        foreach ($clients as $client) {
            $daysLeft = $client->daysUntilExpiry();

            if (!in_array($daysLeft, $reminderDays, true) || $client->billing_reminder_sent_on?->isToday()) {
                continue;
            }

            $email = $client->user?->email ?? $client->siteSettings?->email;
            if (!$email) {
                $this->warn("Sin correo para {$client->store_name}");
                continue;
            }

            Mail::to($email)->send(new BillingReminderMail($client, $daysLeft));
            $client->forceFill(['billing_reminder_sent_on' => today()])->save();
            $sent++;
        }

        $this->info("Recordatorios enviados: {$sent}");

        $this->sendAdminDigest($clients);

        return self::SUCCESS;
    }

    /**
     * Resumen para el administrador: tiendas por vencer, en gracia, o suspendidas en los últimos 30 días.
     */
    private function sendAdminDigest($clients): void
    {
        $pending = $clients
            ->filter(fn (Client $client) => in_array($client->billingStatus(), ['por_vencer', 'en_gracia'])
                || ($client->isSuspended() && $client->daysUntilExpiry() >= -30))
            ->sortBy('expires_at')
            ->values();

        if ($pending->isEmpty()) {
            return;
        }

        $recipients = config('quickweb.admin_email')
            ? [config('quickweb.admin_email')]
            : User::where('role', 'admin')->pluck('email')->all();

        if (empty($recipients)) {
            $this->warn('No hay correo de administrador para el resumen');
            return;
        }

        Mail::to($recipients)->send(new AdminBillingDigestMail($pending));
        $this->info("Resumen enviado al administrador ({$pending->count()} tiendas)");
    }
}
