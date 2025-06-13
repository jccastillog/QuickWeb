<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información del Cliente</h5>
    </div>
    <div class="card-body">
        <!-- Primera fila con dos columnas -->
        <div class="row mb-4">
            <!-- Columna izquierda - Configuración Principal -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Configuración Principal</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            @if($client->logo && $client->logo->media)
                                <div class="me-3 text-center">
                                    <img src="{{ $client->logo->media->full_url }}"
                                        alt="{{ $client->store_name }}"
                                        class="img-thumbnail mb-1"
                                        style="width: 80px; height: 80px; object-fit: contain;">
                                    <div class="small text-muted">Logo</div>
                                </div>
                            @else
                                <div class="me-3 text-center">
                                    <span class="d-block border p-4 mb-1 text-muted">Sin logo</span>
                                    <div class="small text-muted">Logo</div>
                                </div>
                            @endif

                            @if($client->favicon && $client->favicon->media)
                                <div class="text-center">
                                    <img src="{{ $client->favicon->media->full_url }}"
                                        alt="{{ $client->store_name }}"
                                        class="img-thumbnail mb-1"
                                        style="width: 80px; height: 80px; object-fit: contain;">
                                    <div class="small text-muted">Favicon</div>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="d-block border p-4 mb-1 text-muted">Sin favicon</span>
                                    <div class="small text-muted">Favicon</div>
                                </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="40%">Nombre de Tienda:</th>
                                    <td>{{ $client->store_name }}</td>
                                </tr>
                                <tr>
                                    <th>Dominio:</th>
                                    <td>
                                        <a href="http://{{ $client->domain }}" target="_blank">
                                            {{ $client->domain }}
                                            <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        <span class="badge bg-{{ $client->active ? 'success' : 'danger' }}">
                                            {{ $client->active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                </tr>
                                @if($client->expires_at)
                                <tr>
                                    <th>Expiración:</th>
                                    <td>{{ $client->expires_at->format('d/m/Y') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Tema:</th>
                                    <td>{{ ucfirst($client->theme) }}</td>
                                </tr>
                                <tr>
                                    <th>Fuente:</th>
                                    <td>{{ $client->font }}</td>
                                </tr>
                                <tr>
                                    <th>Zona Horaria:</th>
                                    <td>{{ $client->timezone }}</td>
                                </tr>
                                <tr>
                                    <th>Colores:</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="color-badge me-2" style="background-color: {{ $client->primary_color }}"></span>
                                            Primario: {{ $client->primary_color }}
                                        </div>
                                        <div class="d-flex align-items-center mt-2">
                                            <span class="color-badge me-2" style="background-color: {{ $client->secondary_color }}"></span>
                                            Secundario: {{ $client->secondary_color }}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha - Configuración del Sitio -->
            <div class="col-md-6">
                @if($client->siteSettings)
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Configuración del Sitio</h6>
                            <a href="{{ route('site-settings.edit', $client) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="40%">Teléfono:</th>
                                    <td>{{ $client->siteSettings->phone }}</td>
                                </tr>
                                <tr>
                                    <th>WhatsApp:</th>
                                    <td>{{ $client->siteSettings->whatsapp }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $client->siteSettings->email }}</td>
                                </tr>
                                <tr>
                                    <th>Dirección:</th>
                                    <td>
                                        {{ $client->siteSettings->street_address }},<br>
                                        {{ $client->siteSettings->city }}, {{ $client->siteSettings->state }},<br>
                                        {{ $client->siteSettings->country }} {{ $client->siteSettings->postal_code }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Acerca de:</th>
                                    <td>{{ $client->siteSettings->about_text }}</td>
                                </tr>
                                <tr>
                                    <th>Titulo del Dominio:</th>
                                    <td>{{ $client->siteSettings->meta_title }}</td>
                                <tr>
                                    <th>Descripción del Dominio:</th>
                                    <td>{{ $client->siteSettings->meta_description }}</td>
                                </tr>
                                <tr>
                                    <th>Horario:</th>
                                    <td>{{ $client->siteSettings->business_hours }}</td>
                                </tr>
                                <tr>
                                    <th>Google Analytics:</th>
                                    <td>{{ $client->siteSettings->google_analytics_id ?? 'No configurado' }}</td>
                                </tr>
                                <tr>
                                    <th>Creado:</th>
                                    <td>{{ $client->siteSettings->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Actualizado:</th>
                                    <td>{{ $client->siteSettings->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="card h-100">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Configuración del Sitio</h6>
                            <a href="{{ route('site-settings.create', $client) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus"></i> Añadir Configuración
                            </a>
                        </div>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="text-center text-muted">
                            <i class="bi bi-gear fs-1"></i>
                            <p class="mt-2">No hay configuración del sitio</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Segunda fila - Redes Sociales -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Redes Sociales</h6>
                            <a href="{{ route('social-networks.create', $client) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus"></i> Añadir
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($client->socialNetworks->count() > 0)
                        <div class="row">
                            @foreach($client->socialNetworks as $network)
                            <div class="col-6 mb-3">
                                <div class="d-flex align-items-center p-2 border rounded">
                                    <i class="{{ $network->icon_class }} fs-4 me-3 text-primary"></i>
                                    <div>
                                        <h6 class="mb-0">{{ ucfirst($network->platform) }}</h6>
                                        <small class="text-muted text-truncate d-block" style="max-width: 150px;">
                                            <a href="{{ $network->url }}" target="_blank">Ver enlace</a>
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $network->active ? 'success' : 'secondary' }} ms-auto">
                                        {{ $network->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                    <div class="ms-2">
                                        <a href="{{ route('social-networks.edit', [$client, $network]) }}"
                                        class="btn btn-sm btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="alert alert-info mb-0">No hay redes sociales configuradas</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tercera fila - Testimonios -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Testimonios</h6>
                            <a href="{{ route('testimonials.create', $client) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus"></i> Añadir
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($client->testimonials->count() > 0)
                        <div class="row">
                            @foreach($client->testimonials as $testimonial)
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="card-title">{{ $testimonial->author_name }}</h6>
                                                @if($testimonial->author_position)
                                                <p class="text-muted small mb-2">{{ $testimonial->author_position }}</p>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="text-warning me-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star{{ $i <= $testimonial->rating ? '-fill' : '' }}"></i>
                                                    @endfor
                                                </div>
                                                <a href="{{ route('testimonials.edit', [$client, $testimonial]) }}"
                                                class="btn btn-sm btn-outline-warning" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <p class="card-text mt-2">"{{ $testimonial->content }}"</p>
                                        <span class="badge bg-{{ $testimonial->active ? 'success' : 'secondary' }}">
                                            {{ $testimonial->active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="alert alert-info mb-0">No hay testimonios registrados</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quinta fila - Páginas -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Páginas</h6>
                            <a href="{{ route('pages.create', $client) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus"></i> Añadir
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($client->pages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Estado</th>
                                        <th>Orden</th>
                                        <th>Creado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->pages->sortBy('order') as $page)
                                    <tr>
                                        <td>{{ $page->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $page->active ? 'success' : 'secondary' }}">
                                                {{ $page->active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>{{ $page->order }}</td>
                                        <td>{{ $page->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('pages.edit', [$client, $page]) }}"
                                            class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('pages.destroy', [$client, $page]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('¿Eliminar esta página?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info mb-0">No hay páginas configuradas</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuarta fila - Planes -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Planes</h6>
                            <a href="{{-- {{ route('plans.create', ['client_id' => $client->id]) }} --}}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus"></i> Añadir
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($client->plans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Intervalo</th>
                                        <th>Límite Productos</th>
                                        <th>Límite Almacenamiento</th>
                                        <th>Estado</th>
                                        <th>Creado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client->plans as $plan)
                                    <tr>
                                        <td>{{ $plan->name }}</td>
                                        <td>${{ number_format($plan->price, 2) }}</td>
                                        <td>{{ ucfirst($plan->interval) }}</td>
                                        <td>{{ $plan->product_limit }}</td>
                                        <td>{{ $plan->storage_limit }}</td>
                                        <td>
                                            <span class="badge bg-{{ $plan->active ? 'success' : 'secondary' }}">
                                                {{ $plan->active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>{{ $plan->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="alert alert-info mb-0">No hay planes configurados</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
