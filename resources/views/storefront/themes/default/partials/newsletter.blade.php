@component('mail::message')
# ¡Gracias por suscribirte!

Aquí tienes el catálogo de {{ $client->store_name }}.

@component('mail::button', ['url' => route('products.index', $client)])
Ver Catálogo
@endcomponent

¡Estamos felices de tenerte con nosotros!  
@endcomponent
