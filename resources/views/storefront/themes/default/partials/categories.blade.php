<section id="categorias" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">{{ __('Categorías') }}</h2>

        @foreach ($categories as $category)
            <div class="row g-4 align-items-center mb-5 @if ($loop->even) flex-row-reverse @endif">
                <div class="col-md-6">
                    <div class="text-start text-md-{{ $loop->even ? 'end' : 'start' }}">
                        <h3 class="fw-bold">{{ $category->name }}</h3>
                        <p class="text-muted">{{ $category->description }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    @if ($category->image)
                        <div class="ratio ratio-4x3">
                            <img src="{{ $category->image->media->full_url }}" alt="{{ $category->name }}" class="img-fluid rounded-3 shadow-sm object-fit-cover">
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>