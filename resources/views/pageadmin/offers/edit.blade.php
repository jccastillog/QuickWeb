@extends('pageadmin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Editar Oferta: {{ $offer->title }}</h6>
                        <div>
                            <a href="{{ route('clients.show', [$client, $offer]) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Volver
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('offers.update', [$client, $offer]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Paso 1: Información Básica -->
                            <div class="mb-5">
                                <h5 class="border-bottom pb-2 mb-3">1. Información Básica</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="title" class="font-weight-bold">Título*</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $offer->title) }}"
                                            required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="type" class="font-weight-bold">Tipo de Oferta*</label>
                                        <select class="form-control @error('type') is-invalid @enderror" id="type"
                                            name="type" required>
                                            <option value="percentage"
                                                {{ old('type', $offer->type) == 'percentage' ? 'selected' : '' }}>Porcentaje
                                                de descuento</option>
                                            <option value="fixed_amount"
                                                {{ old('type', $offer->type) == 'fixed_amount' ? 'selected' : '' }}>Monto
                                                fijo de descuento</option>
                                            <option value="buy_x_get_y"
                                                {{ old('type', $offer->type) == 'buy_x_get_y' ? 'selected' : '' }}>Compra X
                                                lleva Y</option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="font-weight-bold">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3">{{ old('description', $offer->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Paso 2: Alcance de la Oferta -->
                            <div class="mb-5">
                                <h5 class="border-bottom pb-2 mb-3">2. Alcance de la Oferta</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="font-weight-bold">Aplicar a:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="scope" id="scope_all"
                                                value="all"
                                                {{ old('scope', $offer->product_id ? 'product' : ($offer->category_id ? 'category' : 'all')) == 'all' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="scope_all">
                                                Todos los productos
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="scope"
                                                id="scope_category" value="category"
                                                {{ old('scope', $offer->category_id ? 'category' : '') == 'category' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="scope_category">
                                                Una categoría específica
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="scope" id="scope_product"
                                                value="product"
                                                {{ old('scope', $offer->product_id ? 'product' : '') == 'product' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="scope_product">
                                                Un producto específico
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Selector de Categoría -->
                                    <div class="form-group col-md-6" id="category-selector" style="display: none;">
                                        <label for="category_id" class="font-weight-bold">Seleccionar Categoría</label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id">
                                            <option value="">Seleccione una categoría</option>
                                            @foreach ($client->categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $offer->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Selector de Producto -->
                                    <div class="form-group col-md-6" id="product-selector" style="display: none;">
                                        <label for="product_id" class="font-weight-bold">Seleccionar Producto</label>
                                        <select class="form-control @error('product_id') is-invalid @enderror"
                                            id="product_id" name="product_id">
                                            <option value="">Seleccione un producto</option>
                                            @foreach ($client->products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ old('product_id', $offer->product_id) == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 3: Detalles del Descuento -->
                            <div class="mb-5">
                                <h5 class="border-bottom pb-2 mb-3">3. Detalles del Descuento</h5>
                                <div class="form-row">
                                    <!-- Descuento porcentual -->
                                    <div class="form-group col-md-4" id="discount-percentage"
                                        style="{{ old('type', $offer->type) == 'percentage' ? '' : 'display: none;' }}">
                                        <label for="discount" class="font-weight-bold">Porcentaje de Descuento*</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" min="0" max="100"
                                                class="form-control @error('discount') is-invalid @enderror"
                                                id="discount" name="discount"
                                                value="{{ old('discount', $offer->discount) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            @error('discount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Descuento por monto fijo -->
                                    <div class="form-group col-md-4" id="discount-amount"
                                        style="{{ old('type', $offer->type) == 'fixed_amount' ? '' : 'display: none;' }}">
                                        <label for="discount_amount" class="font-weight-bold">Monto de Descuento*</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" step="0.01" min="0"
                                                class="form-control @error('discount_amount') is-invalid @enderror"
                                                id="discount_amount" name="discount_amount"
                                                value="{{ old('discount_amount', $offer->discount_amount) }}">
                                            @error('discount_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Promo code -->
                                    <div class="form-group col-md-4">
                                        <label for="promo_code" class="font-weight-bold">Código Promocional
                                            (opcional)</label>
                                        <input type="text"
                                            class="form-control @error('promo_code') is-invalid @enderror" id="promo_code"
                                            name="promo_code" value="{{ old('promo_code', $offer->promo_code) }}">
                                        @error('promo_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Paso 4: Vigencia y Visualización -->
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 mb-3">4. Vigencia y Visualización</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="start_date" class="font-weight-bold">Fecha de Inicio*</label>
                                        <input type="datetime-local"
                                            class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                                            name="start_date"
                                            value="{{ old('start_date', $offer->start_date->format('Y-m-d\TH:i')) }}"
                                            required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="end_date" class="font-weight-bold">Fecha de Fin*</label>
                                        <input type="datetime-local"
                                            class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                                            name="end_date"
                                            value="{{ old('end_date', $offer->end_date->format('Y-m-d\TH:i')) }}"
                                            required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row mt-3">
                                    <div class="form-group col-md-6">
                                        <label for="image" class="font-weight-bold">Imagen de la Oferta</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Tamaño recomendado: 800x400 px</small>

                                        @if ($offer->image)
                                            <div class="mt-3">
                                                <img src="{{ $offer->image->media->full_url }}"
                                                    alt="{{ $offer->title }}" class="img-thumbnail"
                                                    style="max-width: 200px;">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" id="remove_image"
                                                        name="remove_image" {{ old('remove_image') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remove_image">
                                                        Eliminar imagen actual
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6 d-flex align-items-end">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="active"
                                                name="active" value="1"
                                                {{ old('active', $offer->active) ? 'checked' : '' }}>
                                            <label class="form-check-label font-weight-bold" for="active">
                                                Oferta Activa
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                    <i class="fas fa-trash"></i> Eliminar Oferta
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar Oferta
                                </button>
                            </div>
                        </form>

                        <form id="delete-form" action="{{ route('offers.destroy', [$client, $offer]) }}" method="POST"
                            class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Documento cargado - Script de ofertas iniciado');

            // Elementos del DOM
            const scopeRadios = document.querySelectorAll('input[name="scope"]');
            const typeSelect = document.getElementById('type');
            const categorySelector = document.getElementById('category-selector');
            const productSelector = document.getElementById('product-selector');
            const discountPercentage = document.getElementById('discount-percentage');
            const discountAmount = document.getElementById('discount-amount');

            // Función para actualizar los campos de alcance
            function updateScopeFields() {
                console.log('Actualizando campos de alcance...');
                
                // Ocultar ambos selectores primero
                if(categorySelector) categorySelector.style.display = 'none';
                if(productSelector) productSelector.style.display = 'none';

                // Obtener el radio button seleccionado
                const selectedScope = document.querySelector('input[name="scope"]:checked');
                
                if(selectedScope) {
                    console.log('Alcance seleccionado:', selectedScope.value);
                    
                    if(selectedScope.value === 'category' && categorySelector) {
                        categorySelector.style.display = 'block';
                    } else if(selectedScope.value === 'product' && productSelector) {
                        productSelector.style.display = 'block';
                    }
                }
            }

            // Función para actualizar los campos de tipo
            function updateTypeFields() {
                console.log('Actualizando campos de tipo...');
                
                // Ocultar ambos campos de descuento primero
                if(discountPercentage) discountPercentage.style.display = 'none';
                if(discountAmount) discountPercentage.style.display = 'none';

                if(typeSelect) {
                    console.log('Tipo seleccionado:', typeSelect.value);
                    
                    if(typeSelect.value === 'percentage' && discountPercentage) {
                        discountPercentage.style.display = 'block';
                    } else if(typeSelect.value === 'fixed_amount' && discountAmount) {
                        discountAmount.style.display = 'block';
                    }
                }
            }

            // Añadir event listeners
            if(scopeRadios) {
                scopeRadios.forEach(radio => {
                    radio.addEventListener('change', updateScopeFields);
                });
            }

            if(typeSelect) {
                typeSelect.addEventListener('change', updateTypeFields);
            }

            // Ejecutar al cargar la página
            updateScopeFields();
            updateTypeFields();

            // Forzar actualización después de un breve retraso para valores old()
            setTimeout(() => {
                updateScopeFields();
                updateTypeFields();
            }, 100);
        });
        </script>
        @endpush
@endsection
