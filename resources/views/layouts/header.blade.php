<!-- Header con Redes Sociales -->
<header class="bg-dark text-white text-center py-2">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-md-between gap-2">
        <span class="small text-uppercase">Síguenos en:</span>
        <div class="social-icons d-flex gap-3">
            @foreach($client->socialNetworks as $network)
                <a href="{{ $network->url }}" target="_blank" class="text-white fs-5">
                    <i class="bi bi-{{ $network->platform }}"></i>
                </a>
            @endforeach
        </div>
    </div>
</header>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-2 sticky-top shadow-sm">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-3 text-primary" href="#">
            <img src="{{ $client->logo->media->full_url }}" alt="Logo" style="height: 40px;">
            {{ $client->store_name }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link fw-semibold fs-5" href="#">{{ __('Inicio') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold fs-5" href="#categorias">{{ __('Categorías') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold fs-5" href="#productos">{{ __('Productos') }}</a>
                </li>
            </ul>
        </div>

        <div class="d-none d-lg-flex ms-lg-4 gap-2">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar productos..." id="searchInput">
                <button class="btn btn-primary" type="button" id="searchButton">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>
</nav>