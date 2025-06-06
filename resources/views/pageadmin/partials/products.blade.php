<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Productos</h5>
        <a href="{{-- {{ route('products.create', ['client_id' => $client->id]) }} --}}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus"></i> Nuevo Producto
        </a>
    </div>
    <div class="card-body">
        @if($client->products->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Slug</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Peso</th>
                        <th>Dimensiones</th>
                        <th>Tags</th>
                        <th>Estado</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->products as $product)
                    <tr>
                        <td>
                            @if($product->images->count() > 0)
                            <img src="{{-- {{ $product->images->first()->getUrl('thumb') }} --}}" width="50" height="50" class="rounded" alt="{{ $product->name }}">
                            @else
                            <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->slug }}</td>
                        <td>{{ Str::limit($product->description, 50) }}</td>
                        <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->weight }} kg</td>
                        <td>Largo:{{ $product->length }} Ancho:{{ $product->width }} Alto:{{$product->height}} </td>
                        <td>{{ $product->tags ? $product->tags : 'Sin tags' }}</td>
                        <td>{{ $product->active ? 'Activo' : 'Inactivo' }}</td>
                        <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{-- {{ route('products.edit', $product) }} --}}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">No hay productos registrados</div>
        @endif
    </div>
</div>