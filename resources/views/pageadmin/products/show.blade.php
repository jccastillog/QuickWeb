@extends('pageadmin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Detalles del Producto: {{ $product->name }}</h6>
                        <div>
                            <a href="{{ route('categories.products.edit', [$category, $product]) }}"
                                class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="{{ route('clients.products.index', $client) }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if ($product->featuredImage)
                                    <img src="{{ $product->featuredImage->media->full_url }}" alt="{{ $product->name }}"
                                        class="img-fluid rounded mb-3">
                                @else
                                    <div class="bg-light p-5 text-center text-muted rounded mb-3">
                                        <i class="fas fa-image fa-3x mb-2"></i>
                                        <p>No hay imagen disponible</p>
                                    </div>
                                @endif

                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0 font-weight-bold">Información Básica</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</p>
                                        <p><strong>Código de Barras:</strong> {{ $product->barcode ?? 'N/A' }}</p>
                                        <p><strong>Stock:</strong> {{ $product->stock }}</p>
                                        <p><strong>Estado:</strong>
                                            <span class="badge bg-{{ $product->active ? 'success' : 'danger' }}">
                                                {{ $product->active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </p>
                                        <p><strong>Destacado:</strong>
                                            <span class="badge bg-{{ $product->featured ? 'primary' : 'secondary' }}">
                                                {{ $product->featured ? 'Sí' : 'No' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0 font-weight-bold">Detalles del Producto</h6>
                                    </div>
                                    <div class="card-body">
                                        <h4 class="mb-3">{{ $product->name }}</h4>
                                        <div class="mb-4">
                                            @if ($product->has_discount)
                                                <span
                                                    class="text-danger h4"><del>${{ number_format($product->compare_price, 2) }}</del></span>
                                                <span
                                                    class="h3 text-primary ml-2">${{ number_format($product->price, 2) }}</span>
                                                <span
                                                    class="badge bg-danger ml-2">-{{ $product->discount_percentage }}%</span>
                                            @else
                                                <span
                                                    class="h3 text-primary">${{ number_format($product->price, 2) }}</span>
                                            @endif
                                        </div>

                                        <h5 class="mt-4">Descripción</h5>
                                        <p class="text-muted">{{ $product->description }}</p>

                                        <h5 class="mt-4">Categoría</h5>
                                        <p>{{ $product->category->name }}</p>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0 font-weight-bold">Galería de Imágenes</h6>
                                    </div>
                                    <div class="card-body">
                                        @if ($product->image->count() > 0)
                                            <div class="row">
                                                @foreach ($product->image as $image)
                                                    <div class="col-md-3 mb-3">
                                                        <img src="{{ $image->media->full_url }}"
                                                            alt="{{ $product->name }}" class="img-thumbnail">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">No hay imágenes adicionales</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
