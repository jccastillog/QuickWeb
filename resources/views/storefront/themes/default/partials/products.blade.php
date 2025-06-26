<section id="productos" class="py-5 text-center">
    <div class="container">
        <h2 class="mb-4">{{ __('Productos Destacados') }}</h2>
        @php $count = $featuredProducts->count(); @endphp
        <div class="row justify-content-{{ $count === 1 ? 'center' : 'start' }}">
            @foreach ($featuredProducts as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                    <div class="card product-card p-3 h-100">
                        @if ($product->image->isNotEmpty())
                            @foreach ($product->image as $image)
                                @if ($image->media)
                                    <div class="ratio ratio-4x3 mb-2">
                                        <img src="{{ $image->media->full_url }}" class="img-fluid object-fit-cover rounded-3" alt="{{ $product->name }}">
                                    </div>
                                    @break
                                @endif
                            @endforeach
                        @endif

                        <h5 class="fw-bold text-dark">{{ $product->name }}</h5>
                        <p class="text-muted small">{{ Str::limit($product->description, 90) }}</p>
                        <div class="mt-auto">
                            <span class="badge bg-primary fs-6">${{ number_format($product->price, 0) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>