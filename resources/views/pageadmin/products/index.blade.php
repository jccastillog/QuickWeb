{{-- @dd($products) --}}
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Productos</h5>
            <a href="{{ route('products.create', [$client, $products]) }}"
                class="btn btn-sm btn-primary">
                <i class="bi bi-plus"></i> Nuevo Producto
            </a>
    </div>
    <div class="card-body">
        @if ($products->count() > 0)
            <!-- Cambiado de $client->products a $products -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <!-- Cambiado de $client->products a $products -->
                            <tr>
                                <td>
                                    @if ($product->image->count() > 0)
                                        <img src="{{ $product->image->first()->media->full_url }}" width="50"
                                            height="50" class="rounded" alt="{{ $product->name }}">
                                    @else
                                        <span class="text-muted">Sin imagen</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->active ? 'success' : 'danger' }}">
                                        {{ $product->active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', [$client, $product]) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form id="delete-form" action="{{ route('products.destroy', [$client, $product]) }}"
                                        method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="confirmDelete()">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $products->links('pagination::bootstrap-5') }} <!-- Agregado paginación -->
            </div>
        @else
            <div class="alert alert-info">No hay productos registrados</div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        function confirmDelete() {
            if (confirm('¿Estás seguro de que deseas eliminar este testimonio?')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endpush
