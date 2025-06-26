<section id="testimonios" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">{{ __('Testimonios') }}</h2>
        <div id="carouselTestimonios" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($client->testimonials as $key => $testimonial)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="d-flex flex-column align-items-center text-center px-3 px-md-5">
                            @if ($testimonial->image)
                                <div class="mb-3">
                                    <img src="{{ $testimonial->image->media->full_url }}" class="rounded-circle shadow" alt="{{ $testimonial->author_name }}" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            @endif
                            <p class="fst-italic text-muted">“{{ $testimonial->content }}”</p>
                            <h6 class="fw-bold mb-0">{{ $testimonial->author_name }}</h6>
                            @if ($testimonial->author_position)
                                <small class="text-muted">{{ $testimonial->author_position }}</small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTestimonios" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselTestimonios" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>

        </div>
    </div>
</section>
