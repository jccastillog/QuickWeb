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
                <div class="col-md-3">
                    <div class="text-center mb-4">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#infoModal"
                            data-title="Manos de Lotto" data-content="#contenidoMarca">
                            Acerca de Nosotros
                        </button>
                    </div>
                </div>

                <!-- Contacto -->
                <div class="col-md-3">
                    <h5 class="fw-bold">Contacto</h5>
                    <p><i class="bi bi-envelope"></i> {{ $client->siteSettings->email }}</p>
                    <p><i class="bi bi-phone"></i> {{ $client->siteSettings->phone }}</p>
                    <p><i class="bi bi-geo-alt"></i>{{ $client->siteSettings->street_address }} - {{ $client->siteSettings->city }}</p>
                </div>

                <!-- Políticas y Términos -->
                <div class="col-md-3">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#infoModal"
                        data-title="Políticas y Términos Legales" data-content="#contenidoLegal">
                        Términos legales
                    </button>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="text-white text-decoration-none">Política de Privacidad</a>
                        </li>
                        <li>
                            <a href="#" class="text-white text-decoration-none">Términos y Condiciones</a>
                        </li>
                        <li>
                            <a href="#" class="text-white text-decoration-none">Política de Devoluciones</a>
                        </li>
                    </ul>
                </div>

                <!-- Redes Sociales -->
                <div class="col-md-3 text-center">
                    <h5 class="fw-bold">Síguenos</h5>
                    <div class="social-icons">
                        @foreach($client->socialNetworks as $network)
                            <a href="{{ $network->url }}" target="_blank">
                                <i class="bi bi-{{ $network->platform }}"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 mx-auto">
                    <h5 class="text-center mb-3">Suscríbete a nuestro newsletter</h5>
                    <form id="newsletterForm" class="d-flex">
                        <input type="email" class="form-control" placeholder="Tu correo electrónico" required>
                        <button type="submit" class="btn btn-primary ms-2">Suscribirse</button>
                    </form>
                    <div id="newsletterMessage" class="text-center mt-2 small"></div>
                </div>
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
