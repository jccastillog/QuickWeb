@props(['product'])

<div class="card product-card p-3 h-100 w-100">
    @if ($product->image->isNotEmpty())
        @foreach ($product->image as $image)
            @if ($image->media)
                <div class="ratio ratio-4x3 mb-2">
                    <img src="{{ $image->media->full_url }}"
                         class="img-fluid object-fit-cover rounded-3"
                         alt="{{ $product->name }}">
                </div>
                @break
            @endif
        @endforeach
    @endif

    <h5 class="fw-bold text-dark">{{ $product->name }}</h5>
    <p class="text-muted small">{{ Str::limit($product->description, 100) }}</p>
    <div class="mt-auto">
        <span class="badge bg-primary fs-6">${{ number_format($product->price, 0) }}</span>
    </div>
</div>