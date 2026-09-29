<x-mail::message>
# Tiendas por cobrar

<x-mail::table>
| Tienda | Plan | Pagado hasta | Estado |
|:-------|:-----|:-------------|:-------|
@foreach ($clients as $client)
| {{ $client->store_name }} | {{ $client->plan?->name ?? '—' }} | {{ $client->expires_at->format('d/m/Y') }} | {{ $client->billingStatusLabel() }} |
@endforeach
</x-mail::table>

<x-mail::button :url="url('/clients')">
Abrir el panel
</x-mail::button>

**QuickWeb**
</x-mail::message>
