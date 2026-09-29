<?php

namespace App\Http\Controllers;

use App\Actions\Billing\RegisterPayment;
use App\Models\Client;
use App\Models\Payment;
use App\Support\Money;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function store(Request $request, Client $client, RegisterPayment $registerPayment)
    {
        $data = $request->validate([
            'plan_id' => ['required', Rule::exists('plans', 'id')],
            'months' => ['required', Rule::in(Payment::MONTH_OPTIONS)],
            'amount' => 'required|numeric|min:0',
            'method' => ['required', Rule::in(array_keys(Payment::METHODS))],
            'reference' => 'nullable|string|max:100',
            'paid_at' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment = $registerPayment->handle($client, $data, $request->user());

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Pago de ' . Money::format($payment->amount) . ' registrado. La tienda queda activa hasta el '
                . $payment->period_end->format('d/m/Y') . '.');
    }
}
