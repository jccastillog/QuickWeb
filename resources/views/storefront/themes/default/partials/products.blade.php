<section id="productos" class="py-5 text-center">
    <div class="container">
        <h2 class="mb-4">{{ __('Productos Destacados') }}</h2>

        @php $count = $featuredProducts->count(); @endphp

        <div class="row justify-content-{{ $count === 1 ? 'center' : 'start' }}">
            @foreach ($featuredProducts as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
</section>