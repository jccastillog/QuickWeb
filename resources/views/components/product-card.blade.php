@props(['product'])

@php
    $storeClient = $currentClient ?? $product->client;
    $productUrl = $storeClient->storeUrl('producto/' . $product->slug);
    $firstImage = $product->image->first(fn ($image) => $image->media);
@endphp

<div class="card product-card p-3 h-100 w-100 position-relative">
    @if ($product->regular_price)
        <span class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-danger" style="z-index: 1;">Oferta</span>
    @endif

    <a href="{{ $productUrl }}" class="text-decoration-none">
        @if ($firstImage)
            <div class="ratio ratio-4x3 mb-2">
                <img src="{{ $firstImage->media->full_url }}"
                     class="img-fluid object-fit-cover rounded-3"
                     alt="{{ $product->name }}" loading="lazy">
            </div>
        @endif

        <h5 class="fw-bold text-dark">{{ $product->name }}</h5>
    </a>
    <p class="text-muted small">{{ Str::limit($product->description, 100) }}</p>

    <div class="mt-auto d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div>
            @if ($product->regular_price)
                <small class="text-muted text-decoration-line-through d-block">{{ App\Support\Money::format($product->regular_price) }}</small>
            @endif
            <span class="badge bg-primary fs-6">{{ App\Support\Money::format($product->final_price) }}</span>
        </div>
        <x-add-to-cart-button :product="$product" :client="$storeClient" class="btn btn-sm btn-primary" />
    </div>
</div>
