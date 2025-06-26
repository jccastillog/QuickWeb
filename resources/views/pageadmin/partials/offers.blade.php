<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Ofertas</h5>
        <a href="{{ route('offers.create',  $client) }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus"></i> Nueva Oferta
        </a>
    </div>
    <div class="card-body">
        @if ($client->offers->count() > 0)

                <div class="row">
                    <div class="col-md-12">
                        
                            <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Imagen</th>
                                                    <th>Título</th>
                                                    <th>Descuento</th>
                                                    <th>Producto</th>
                                                    <th>Fecha Inicio - Fin</th>
                                                    <th>Estado</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($client->offers as $offer)
                                                    <tr>
                                                        <td class="text-center">
                                                            @if ($offer->image)
                                                                <img src="{{ $offer->image->media->full_url }}"
                                                                    alt="{{ $offer->title }}" class="img-thumbnail"
                                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                                            @else
                                                                <span class="text-muted">Sin imagen</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $offer->title }}</td>
                                                        <td class="text-center">
                                                            {{ $offer->discount_value }}
                                                        </td>
                                                        <td>
                                                            {{ $offer->product ? $offer->product->name : 'General' }}
                                                        </td>
                                                        <td>
                                                            {{ $offer->start_date->format('d/m/Y') }} -
                                                            {{ $offer->end_date->format('d/m/Y') }}
                                                        </td>
                                                        <td class="text-center">
                                                            <span
                                                                class="badge bg-{{ $offer->status === 'Activa' ? 'success' : ($offer->status === 'Expirada' ? 'danger' : 'warning') }}">
                                                                {{ $offer->status }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('offers.edit', [$client, $offer]) }}"
                                                                class="btn btn-sm btn-warning" title="Editar">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                    </div>
                </div>
        @else
            <div class="alert alert-info">No hay ofertas registradas</div>
        @endif
    </div>
</div>
