<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class AdminBillingDigestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param Collection<int, \App\Models\Client> $clients tiendas por vencer, vencidas o suspendidas
     */
    public function __construct(public Collection $clients)
    {
    }

    public function build()
    {
        return $this->subject("QuickWeb: {$this->clients->count()} tiendas por cobrar")
            ->markdown('emails.admin-billing-digest');
    }
}
