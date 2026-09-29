@props([
    'product',
    'client',
    // Selector de un <input> con la cantidad a agregar (página de producto)
    'qtyInput' => null,
])

@php
    $firstImage = $product->image->first(fn ($image) => $image->media);
@endphp

<button type="button" {{ $attributes->merge(['class' => 'btn btn-primary']) }}
    data-add-to-cart
    data-id="{{ $product->id }}"
    data-name="{{ $product->name }}"
    data-price="{{ $product->final_price }}"
    data-image="{{ $firstImage?->media->full_url }}"
    data-url="{{ $client->storeUrl('producto/' . $product->slug) }}"
    @if ($qtyInput) data-qty-input="{{ $qtyInput }}" @endif>
    @if ($slot->isEmpty())
        <i class="bi bi-bag-plus me-1"></i> Agregar
    @else
        {{ $slot }}
    @endif
</button>
