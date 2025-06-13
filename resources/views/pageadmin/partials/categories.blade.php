<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Categorías</h5>
        <a href="{{ route('categories.create', $client) }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus"></i> Nueva Categoría
        </a>
    </div>
    <div class="card-body">
        @if ($client->categories->count() > 0)
            <div class="row">
                @foreach ($client->categories as $category)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if ($category->image)
                                <img src="{{ $category->image->media->full_url }}" class="card-img-top"
                                    alt="{{ $category->name }}" style="height: 150px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                <p class="card-text">{{ $category->description }}</p>
                                <p class="text-muted">Orden: {{ $category->order }}</p>
                                <span class="badge bg-{{ $category->featured ? 'success' : 'secondary' }}">
                                    {{ $category->featured ? 'Destacado' : 'Normal' }}
                                </span>
                                <p class="text-muted mt-2">
                                    Productos: {{ $category->products->count() }}
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('categories.edit', [$client, $category]) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">No hay categorías registradas</div>
        @endif
    </div>
</div>
