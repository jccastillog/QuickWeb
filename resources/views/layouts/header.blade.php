<!-- Header con Redes Sociales -->
<header class="bg-dark text-white text-center py-2">
    <div class="container d-flex justify-content-between">
        <span>Síguenos en:</span>
        <div class="social-icons">
            @foreach($client->socialNetworks as $network)
                <a href="{{ $network->url }}" target="_blank">
                    <i class="bi bi-{{ $network->platform }}"></i>
                </a>
            @endforeach
        </div>
    </div>
</header>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-2">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3 text-primary" href="#">{{ $client->store_name }}</a>

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

        <div class="d-flex ms-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar productos..." id="searchInput">
                <button class="btn btn-primary" type="button" id="searchButton">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>
</nav>