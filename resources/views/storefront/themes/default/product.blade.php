@extends('layouts.app')

@php
    $images = $product->image->filter(fn ($image) => $image->media)->values();
    $productUrl = $client->storeUrl('producto/' . $product->slug);
    $categoryUrl = $product->category ? $client->storeUrl('categoria/' . $product->category->slug) : null;
    $summary = Str::limit(strip_tags($product->description), 160);

    $whatsappMessage = "Hola {$client->store_name}, me interesa este producto:\n\n"
        . "• {$product->name} — " . \App\Support\Money::format($product->final_price) . "\n\n{$productUrl}";
@endphp

@section('title', $product->name . ' | ' . $client->store_name)
@section('description', $summary)

@section('meta-tags')
    <link rel="canonical" href="{{ $productUrl }}">
    <meta property="og:type" content="product">
    <meta property="og:site_name" content="{{ $client->store_name }}">
    <meta property="og:title" content="{{ $product->name }} — {{ \App\Support\Money::format($product->final_price) }}">
    <meta property="og:description" content="{{ $summary }}">
    <meta property="og:url" content="{{ $productUrl }}">
    @if ($images->isNotEmpty())
        <meta property="og:image" content="{{ $images->first()->media->full_url }}">
    @endif
    <meta property="product:price:amount" content="{{ $product->final_price }}">
    <meta property="product:price:currency" content="COP">
    <meta name="twitter:card" content="summary_large_image">

    <script type="application/ld+json">
        {!! json_encode(array_filter([
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $summary,
            'sku' => $product->sku,
            'image' => $images->map(fn ($image) => $image->media->full_url)->all() ?: null,
            'category' => $product->category?->name,
            'offers' => [
                '@type' => 'Offer',
                'url' => $productUrl,
                'priceCurrency' => 'COP',
                'price' => $product->final_price,
                'availability' => 'https://schema.org/InStock',
                'seller' => ['@type' => 'Organization', 'name' => $client->store_name],
            ],
        ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
    </script>
@endsection

@section('content')
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ $client->storeUrl() }}">Inicio</a></li>
                @if ($categoryUrl)
                    <li class="breadcrumb-item"><a href="{{ $categoryUrl }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-4 g-lg-5">
            {{-- Galería --}}
            <div class="col-md-6">
                @if ($images->count() > 1)
                    <div id="productGallery" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner rounded-3 shadow-sm">
                            @foreach ($images as $image)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ $image->media->full_url }}" class="object-fit-cover w-100"
                                            alt="{{ $image->custom_properties['alt_text'] ?? $product->name }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productGallery" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productGallery" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                @elseif ($images->isNotEmpty())
                    <div class="ratio ratio-1x1">
                        <img src="{{ $images->first()->media->full_url }}" class="object-fit-cover rounded-3 shadow-sm w-100"
                            alt="{{ $product->name }}">
                    </div>
                @else
                    <div class="ratio ratio-1x1 bg-light rounded-3 d-flex align-items-center justify-content-center">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-image text-muted display-1"></i>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Información y compra --}}
            <div class="col-md-6">
                @if ($product->category)
                    <a href="{{ $categoryUrl }}" class="text-uppercase small text-muted text-decoration-none">
                        {{ $product->category->name }}
                    </a>
                @endif

                <h1 class="fw-bold h2 mt-1">{{ $product->name }}</h1>

                <div class="d-flex align-items-baseline gap-3 my-3">
                    <span class="fs-2 fw-bold text-primary">{{ \App\Support\Money::format($product->final_price) }}</span>
                    @if ($product->regular_price)
                        <span class="fs-5 text-muted text-decoration-line-through">{{ \App\Support\Money::format($product->regular_price) }}</span>
                        <span class="badge bg-danger">Oferta</span>
                    @endif
                </div>

                @if ($product->activeOffer)
                    <div class="alert alert-danger py-2 small">
                        <i class="bi bi-tag me-1"></i>
                        <strong>{{ $product->activeOffer->title }}</strong>
                        · válida hasta {{ $product->activeOffer->end_date->format('d/m/Y') }}
                        @if ($product->activeOffer->promo_code)
                            · código <span class="badge bg-light text-dark">{{ $product->activeOffer->promo_code }}</span>
                        @endif
                    </div>
                @endif

                <div class="text-muted mb-4" style="white-space: pre-line;">{{ $product->description }}</div>

                <div class="d-flex gap-2 align-items-stretch mb-3">
                    <label for="productQty" class="visually-hidden">Cantidad</label>
                    <input type="number" id="productQty" class="form-control text-center" value="1" min="1" max="999"
                        style="max-width: 90px;">
                    <x-add-to-cart-button :product="$product" :client="$client" qty-input="#productQty"
                        class="btn btn-primary btn-lg flex-grow-1">
                        <i class="bi bi-bag-plus me-1"></i> Agregar al pedido
                    </x-add-to-cart-button>
                </div>

                @if ($client->siteSettings?->whatsapp_number)
                    <a href="https://wa.me/{{ $client->siteSettings->whatsapp_number }}?text={{ rawurlencode($whatsappMessage) }}"
                        target="_blank" rel="noopener" class="btn btn-outline-success w-100">
                        <i class="bi bi-whatsapp me-1"></i> Preguntar por WhatsApp
                    </a>
                @endif

                @if ($product->sku)
                    <p class="small text-muted mt-3 mb-0">Referencia: {{ $product->sku }}</p>
                @endif
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <section class="mt-5 pt-4 border-top">
                <h2 class="h4 fw-bold mb-4">También te puede interesar</h2>
                <div class="row">
                    @foreach ($relatedProducts as $related)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                            <x-product-card :product="$related" />
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
