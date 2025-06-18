<div id="clientCarousel" class="carousel slide" data-bs-ride="carousel">
    @if ($allImages && $allImages->count() > 0)
        <!-- Indicadores -->
        <div class="carousel-indicators">
            @foreach ($allImages as $key => $media)
                <button type="button" data-bs-target="#clientCarousel" data-bs-slide-to="{{ $key }}"
                    class="{{ $loop->first ? 'active' : '' }}"></button>
            @endforeach
        </div>

        <!-- Imágenes -->
        <div class="carousel-inner">
            @foreach ($allImages as $key => $media)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ $media->full_url }}" class="d-block w-100" style="height: 500px; object-fit: cover;"
                        alt="Imagen {{ $key + 1 }}">
                </div>
            @endforeach
        </div>

        <!-- Controles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#clientCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#clientCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    @else
        <!-- Mensaje cuando no hay imágenes -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="d-block w-100 bg-light text-center p-5" style="height: 500px;">
                    <div class="d-flex flex-column justify-content-center h-100">
                        <i class="fas fa-image fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No hay imágenes disponibles</h4>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>