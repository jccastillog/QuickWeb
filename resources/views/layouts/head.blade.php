<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
@php
    $defaultTitle = $client->siteSettings->meta_title ?? $client->store_name;
    $defaultDescription = $client->siteSettings->meta_description ?? Str::limit(strip_tags($client->siteSettings->about_text ?? ''), 160);
@endphp
<title id="titlepage">@yield('title', $defaultTitle)</title>
<meta name="description" content="@yield('description', $defaultDescription)">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />

<link rel="stylesheet" href="{{ $client->url }}/css/style.css">

@if($client->favicon)
<link rel="icon" href="{{ asset($client->favicon->media->full_url) }}" />
@endif

{{-- Open Graph: vista previa al compartir el enlace en WhatsApp, Facebook, etc. --}}
@hasSection('meta-tags')
    @yield('meta-tags')
@else
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $client->store_name }}">
    <meta property="og:title" content="{{ $defaultTitle }}">
    <meta property="og:description" content="{{ $defaultDescription }}">
    <meta property="og:url" content="{{ $client->url }}">
    @if($client->logo?->media)
    <meta property="og:image" content="{{ $client->logo->media->full_url }}">
    @endif
@endif

<!-- Google tag (gtag.js) -->
@php
    $analyticsIds = array_filter(['G-2DD4RTEQJX', $client->siteSettings->google_analytics_id ?? null]);
@endphp
<script async src="https://www.googletagmanager.com/gtag/js?id={{ reset($analyticsIds) }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    @foreach ($analyticsIds as $analyticsId)
    gtag('config', @json($analyticsId));
    @endforeach
</script>
