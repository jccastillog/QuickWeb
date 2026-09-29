<x-mail::message>
# Hola, {{ $client->store_name }}

@if ($daysLeft > 0)
El plan **{{ $client->plan?->name ?? 'QuickWeb' }}** de tu tienda vence el **{{ $client->expires_at->format('d/m/Y') }}** ({{ $daysLeft }} {{ $daysLeft === 1 ? 'día' : 'días' }}).
@elseif ($daysLeft === 0)
El plan **{{ $client->plan?->name ?? 'QuickWeb' }}** de tu tienda vence **hoy**.
@else
El plan de tu tienda venció el **{{ $client->expires_at->format('d/m/Y') }}**.
@endif

@if ($daysLeft >= 0)
Renueva a tiempo para que tu tienda siga publicada y recibiendo pedidos.
@else
Tu tienda sigue publicada hasta el **{{ $client->suspendsOn()->subDay()->format('d/m/Y') }}**. Si no renuevas, se suspenderá temporalmente.
@endif

@if ($client->plan)
<x-mail::panel>
**Plan:** {{ $client->plan->name }}
**Valor mensual:** {{ \App\Support\Money::format($client->plan->price) }}
</x-mail::panel>
@endif

@if (config('quickweb.support_whatsapp'))
<x-mail::button :url="'https://wa.me/' . config('quickweb.support_whatsapp') . '?text=' . rawurlencode('Hola QuickWeb, quiero renovar el plan de mi tienda ' . $client->store_name . '.')" color="success">
Renovar por WhatsApp
</x-mail::button>
@endif

Gracias por confiar en nosotros,
**El equipo de QuickWeb**
</x-mail::message>
