<div id="carouselIndicators" class="carousel slide">
    <div class="carousel-indicators">
        @foreach($client->carouselImages as $key => $image)
            <button type="button" 
                    data-bs-target="#carouselIndicators" 
                    data-bs-slide-to="{{ $key }}" 
                    class="{{ $loop->first ? 'active' : '' }}" 
                    aria-label="Slide {{ $key + 1 }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($client->carouselImages as $key => $image)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img src="{{ asset($image->path) }}" class="d-block w-100" alt="Slide {{ $key + 1 }}">
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>