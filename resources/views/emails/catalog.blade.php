<x-mail::message>
# ¡Bienvenido a {{ $client->store_name }}!

{{ $client->siteSettings->about_text }}

<x-mail::panel>
📍 **Ubicación:** {{ $client->siteSettings->street_address }}, {{ $client->siteSettings->city }}, {{ $client->siteSettings->state }}  
📞 **Teléfono:** {{ $client->siteSettings->phone }}  
💬 **WhatsApp:** {{ $client->siteSettings->whatsapp }}  
📧 **Email:** {{ $client->siteSettings->email }}  
🕒 **Horario de atención:** {{ $client->siteSettings->business_hours }}
</x-mail::panel>

@if($client->siteSettings->meta_title)
## {{ $client->siteSettings->meta_title }}
@endif

@if($client->siteSettings->meta_description)
{{ $client->siteSettings->meta_description }}
@endif


@isset($pdfCatalogPath)
<x-mail::button :url="$pdfCatalogPath">
Descarga el catálogo en PDF
</x-mail::button>
@endisset

Gracias por tu interés,  
**El equipo de {{ $client->store_name }}**
</x-mail::message>