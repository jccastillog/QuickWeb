<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title id="titlepage">{{ $client->siteSettings->meta_title ?? 'Quickweb' }}</title>
<meta name="description" content="{{ $client->siteSettings->meta_description ?? 'Descripción predeterminada' }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />

<link rel="stylesheet" href="{{ $currentClient->url }}/css/style.css">

@if($client->favicon)
<link rel="icon" href="{{ asset($client->favicon->media->full_url) }}" />
@endif

@yield('meta-tags')