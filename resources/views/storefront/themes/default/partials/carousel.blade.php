<div id="carouselIndicators" class="carousel slide">
    @if($client->carouselImages && count($client->carouselImages) > 0)
        <!-- Mostrar carrusel normal si hay imágenes -->
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
    @else
        <!-- Mostrar mensaje por defecto cuando no hay imágenes -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="d-block w-100 bg-light text-center p-5" style="height: 300px;">
                    <div class="d-flex flex-column justify-content-center h-100">
                        <i class="fas fa-image fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No hay imágenes disponibles</h4>
                        <p class="text-muted">El carrusel se mostrará aquí cuando se agreguen imágenes</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>