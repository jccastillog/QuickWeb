<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Ofertas</h5>
        <a href="{{-- {{ route('offers.create', ['client_id' => $client->id]) }} --}}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus"></i> Nueva Oferta
        </a>
    </div>
    <div class="card-body">
        @if($client->offers->count() > 0)
        <div class="row">
            @foreach($client->offers as $offer)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $offer->title }}</h5>
                                <p class="card-text">{{ Str::limit($offer->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-success">
                                        Descuento: {{ $offer->discount }}%
                                    </span>
                                    <small class="text-muted">
                                        {{ $offer->start_date->format('d/m/Y') }} - {{ $offer->end_date->format('d/m/Y') }}
                                    </small>
                                </div>
                                @if($offer->product)
                                <p class="mt-2 mb-0">
                                    <small>Producto: {{ $offer->product->name }}</small>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-info">No hay ofertas registradas</div>
        @endif
    </div>
</div>