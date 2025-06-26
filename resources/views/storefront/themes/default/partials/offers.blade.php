<!-- resources/views/storefront/themes/default/partials/offers.blade.php -->
<section id="offers" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">{{ ('Ofertas Especiales') }}</h2>

        @if ($activeOffers->count() > 0)
            <div class="row g-4 justify-content-{{ $activeOffers->count() === 1 ? 'center' : 'start' }}">
                @foreach ($activeOffers->take($offersToShow) as $offer)
                    @php
                        $product = $offer->product;
                        $discountedPrice =
                            $offer->type === 'percentage'
                                ? $product->price * (1 - $offer->discount / 100)
                                : $product->price - $offer->discount_amount;
                    @endphp

                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">
                            <span class="position-absolute top-0 end-0 m-2 badge rounded-pill bg-danger">
                                @if ($offer->type === 'percentage')
                                    -{{ $offer->discount }}%
                                @else
                                    Oferta
                                @endif
                            </span>

                            @if ($offer->image)
                                <div class="ratio ratio-4x3">
                                    <img src="{{ $offer->image->media->full_url }}"
                                        class="img-fluid object-fit-cover rounded-top" alt="{{ $product->name }}">
                                </div>
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-white"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="fw-bold text-dark mb-1">{{ $offer->title }}</h5>
                                <p class="text-muted small mb-2">
                                    {{ Str::limit($offer->description ?? $product->description, 100) }}
                                </p>
                                <div class="badge bg-danger position-absolute top-0 end-0 m-2 fs-6">
                                    @if ($offer->type === 'percentage')
                                        <span
                                            class="text-decoration-line-through text-muted">${{ number_format($product->price, 0) }}</span>
                                    @endif
                                    <span
                                        class="fw-bold fs-5 text-primary">${{ number_format($discountedPrice, 0) }}
                                    </span>
                                </div>

                                @if ($offer->promo_code)
                                    <div class="mb-3">
                                        <small class="text-muted">Código: <span
                                                class="badge bg-light text-dark">{{ $offer->promo_code }}</span></small>
                                    </div>
                                @endif
                            </div>

                            @if ($offer->end_date >= now())
                                <div class="card-footer bg-white border-top-0">
                                    <small class="text-muted">
                                        <i class="far fa-clock me-1"></i>
                                        Termina en: {{ $offer->end_date->diffForHumans() }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($activeOffers->count() > $offersToShow)
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-outline-primary rounded-pill px-4">
                        {{ ('Ver más ofertas') }} ({{ $activeOffers->count() - $offersToShow }} más)
                    </a>
                </div>
            @endif
        @else
            <div class="alert alert-info text-center mb-0">
                <i class="fas fa-info-circle me-2"></i>
                {{ ('Actualmente no hay ofertas disponibles') }}
            </div>
        @endif
    </div>
</section>
