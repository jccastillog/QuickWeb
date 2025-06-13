<section id="testimonios" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">{{ __('Testimonios') }}</h2>
        <div id="carouselTestimonios" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($client->testimonials as $key => $testimonial)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            @if ($testimonial->image_path)
                                <img src="{{ asset($testimonial->image_path) }}" class="testimonial-img"
                                    alt="{{ $testimonial->author_name }}">
                            @endif
                            <p class="mt-3 testimonial-text">{{ $testimonial->content }}</p>
                            <h6>{{ $testimonial->author_name }}</h6>
                            @if ($testimonial->author_position)
                                <small>{{ $testimonial->author_position }}</small>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
