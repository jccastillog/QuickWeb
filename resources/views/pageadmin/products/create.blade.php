@extends('pageadmin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                        <h6 class="m-0 font-weight-bold">Nuevo Producto para {{ $client->store_name }}</h6>
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.store', $client) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="name" class="font-weight-bold">Nombre del Producto*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="font-weight-bold">Descripción*</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="4" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="m-0 font-weight-bold">Configuración</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="category_id" class="font-weight-bold">Categoría*</label>
                                                <select class="form-control @error('category_id') is-invalid @enderror"
                                                    id="category_id" name="category_id" required>
                                                    @foreach ($client->categories as $cat)
                                                        <option value="{{ $cat->id }}"
                                                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold d-block">Estado</label>
                                                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                                    <label
                                                        class="btn btn-outline-success {{ old('active', 1) ? 'active' : '' }}">
                                                        <input type="radio" name="active" value="1"
                                                            {{ old('active', 1) ? 'checked' : '' }}> Activo
                                                    </label>
                                                    <label
                                                        class="btn btn-outline-danger {{ !old('active', 1) ? 'active' : '' }}">
                                                        <input type="radio" name="active" value="0"
                                                            {{ !old('active', 1) ? 'checked' : '' }}> Inactivo
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="font-weight-bold d-block">Destacado</label>
                                                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                                                    <label
                                                        class="btn btn-outline-primary {{ old('featured') ? 'active' : '' }}">
                                                        <input type="radio" name="featured" value="1"
                                                            {{ old('featured') ? 'checked' : '' }}> Sí
                                                    </label>
                                                    <label
                                                        class="btn btn-outline-secondary {{ !old('featured') ? 'active' : '' }}">
                                                        <input type="radio" name="featured" value="0"
                                                            {{ !old('featured') ? 'checked' : '' }}> No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold">Precios y Stock</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="price" class="font-weight-bold">Precio*</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="number" step="0.01" min="0"
                                                        class="form-control @error('price') is-invalid @enderror"
                                                        id="price" name="price" value="{{ old('price') }}" required>
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="compare_price" class="font-weight-bold">Precio
                                                    Comparación</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="number" step="0.01" min="0"
                                                        class="form-control @error('compare_price') is-invalid @enderror"
                                                        id="compare_price" name="compare_price"
                                                        value="{{ old('compare_price') }}">
                                                    @error('compare_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="stock" class="font-weight-bold">Stock*</label>
                                                <input type="number" min="0"
                                                    class="form-control @error('stock') is-invalid @enderror"
                                                    id="stock" name="stock" value="{{ old('stock', 0) }}"
                                                    required>
                                                @error('stock')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold">Identificadores</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sku" class="font-weight-bold">SKU</label>
                                                <input type="text"
                                                    class="form-control @error('sku') is-invalid @enderror" id="sku"
                                                    name="sku" value="{{ old('sku') }}">
                                                @error('sku')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="barcode" class="font-weight-bold">Código de Barras</label>
                                                <input type="text"
                                                    class="form-control @error('barcode') is-invalid @enderror"
                                                    id="barcode" name="barcode" value="{{ old('barcode') }}">
                                                @error('barcode')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold">Imágenes</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="image" class="font-weight-bold">Imagen Principal*</label>
                                        <div class="custom-file">
                                            <input type="file"
                                                class="custom-file-input @error('image') is-invalid @enderror"
                                                id="image" name="image" accept="image/*">
                                            <label class="custom-file-label" for="image">Seleccionar archivo...</label>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="form-text text-muted">Tamaño recomendado: 800x800 px. Formatos: JPG,
                                            PNG, WEBP</small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save mr-2"></i> Crear Producto
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Actualizar label de archivo seleccionado
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("image").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
@endpush
