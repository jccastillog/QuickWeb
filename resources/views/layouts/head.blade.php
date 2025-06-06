<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title id="titlepage">{{ $client->store_name ?? 'Manos de Lotto' }}</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />

@if($currentClient->is_custom_domain)
    <!-- Usar recursos del propio dominio -->
    <link rel="stylesheet" href="https://{{ $currentClient->domain }}/css/style.css">
@else
    <!-- Usar recursos centralizados -->
    <link rel="stylesheet" href="{{ asset('css/clients/'.$currentClient->id.'.css') }}">
@endif

@if($client->favicon)
<link rel="icon" href="{{ asset($client->favicon_path) }}" />
@endif

@yield('meta-tags')