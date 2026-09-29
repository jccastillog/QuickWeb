<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BillingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Client $client, public int $daysLeft)
    {
    }

    public function build()
    {
        $subject = match (true) {
            $this->daysLeft > 0 => "Tu plan de {$this->client->store_name} vence en {$this->daysLeft} " . ($this->daysLeft === 1 ? 'día' : 'días'),
            $this->daysLeft === 0 => "Tu plan de {$this->client->store_name} vence hoy",
            default => "Tu plan de {$this->client->store_name} está vencido",
        };

        return $this->subject($subject)->markdown('emails.billing-reminder');
    }
}
