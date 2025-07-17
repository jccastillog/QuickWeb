    <footer id="contacto" class="bg-dark text-white py-4">

        <a href="https://wa.me/{{ $client->siteSettings->whatsapp }}" target="_blank"
            id="whatsappButton"
            class="btn btn-success rounded-circle position-fixed"
            style="width:60px; height:60px; bottom:30px; left:30px; z-index:1000;">
            <i class="bi bi-whatsapp fs-4"></i>
        </a>

        <div class="container">
            <div class="row">
                <!-- Acerca de Nosotros -->
                @include('storefront.themes.default.partials.about')

                <!-- Contacto -->
                @include('storefront.themes.default.partials.contact')

                <!-- Políticas y Términos -->

                @include('storefront.themes.default.partials.legal')

                <!-- Redes Sociales -->
                @include('storefront.themes.default.partials.social')


                <div class="col-md-6 mx-auto">
                    <h5 class="text-center mb-3 text-primary">Recibe nuestro catálogo actual</h5>

                    @php
                        $action = Route::has('newsletter.subscribe')
                            ? route('newsletter.subscribe')
                            : route('newsletter.subscribe.fallback', ['domain' => $client->domain]);
                    @endphp

                    <form id="newsletterForm" method="POST" action="{{ $action }}" class="d-flex">
                        @csrf
                        <input type="email" name="email" class="form-control" placeholder="Tu correo electrónico" required>
                        <button type="submit" class="btn btn-primary ms-2">Suscribirse</button>
                    </form>

                    <div id="newsletterMessage" class="text-center mt-2 small" style="display:none;"></div>
                </div>

            <!-- Fila de Copyright -->
            <div class="row mt-3 border-top pt-3 text-center">
                <div class="col-12">
                    <p class="mb-0">
                        &copy; 2025 QuickWeb. Todos los derechos reservados. | Diseñado
                        por
                        <a href="https://quickweb.com.co" class="text-white fw-bold text-decoration-none"
                            target="_blank">QuickWeb</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
