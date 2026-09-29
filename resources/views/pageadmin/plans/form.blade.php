@extends('pageadmin.layouts.app')

@section('title', $plan->exists ? 'Editar plan' : 'Nuevo plan')

@section('content')
    <div class="container-fluid" style="max-width: 720px;">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h3 class="m-0 font-weight-bold text-primary">
                    {{ $plan->exists ? 'Editar plan ' . $plan->name : 'Nuevo plan' }}
                </h3>
                <a href="{{ route('plans.index') }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ $plan->exists ? route('plans.update', $plan) : route('plans.store') }}">
                    @csrf
                    @if ($plan->exists)
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nombre*</label>
                            <input type="text" id="name" name="name" required maxlength="100"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $plan->name) }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="slug" class="form-label">Identificador*</label>
                            <input type="text" id="slug" name="slug" required maxlength="100"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $plan->slug) }}" placeholder="ej: negocio">
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea id="description" name="description" rows="2" maxlength="500"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $plan->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="features" class="form-label">Características para la página de QuickWeb</label>
                            <textarea id="features" name="features" rows="5" maxlength="2000"
                                class="form-control @error('features') is-invalid @enderror"
                                placeholder="Una por línea">{{ old('features', $plan->features) }}</textarea>
                            <small class="form-text text-muted">
                                Una por línea. El límite de productos y el tipo de dominio se agregan solos.
                            </small>
                            @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="price" class="form-label">Precio mensual (COP)*</label>
                            <input type="number" id="price" name="price" required min="0" step="100"
                                class="form-control @error('price') is-invalid @enderror"
                                value="{{ old('price', $plan->price !== null ? (int) $plan->price : null) }}">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="product_limit" class="form-label">Límite de productos</label>
                            <input type="number" id="product_limit" name="product_limit" min="1"
                                class="form-control @error('product_limit') is-invalid @enderror"
                                value="{{ old('product_limit', $plan->product_limit) }}" placeholder="Vacío = ilimitados">
                            @error('product_limit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="sort_order" class="form-label">Orden</label>
                            <input type="number" id="sort_order" name="sort_order" min="0"
                                class="form-control @error('sort_order') is-invalid @enderror"
                                value="{{ old('sort_order', $plan->sort_order ?? 0) }}">
                            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="allows_custom_domain"
                                    name="allows_custom_domain" value="1"
                                    {{ old('allows_custom_domain', $plan->allows_custom_domain) ? 'checked' : '' }}>
                                <label class="form-check-label" for="allows_custom_domain">Incluye dominio propio</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="highlighted" name="highlighted"
                                    value="1" {{ old('highlighted', $plan->highlighted) ? 'checked' : '' }}>
                                <label class="form-check-label" for="highlighted">Destacar como "Más popular"</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1"
                                    {{ old('active', $plan->active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Activo (se ofrece al asignar tiendas)</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> {{ $plan->exists ? 'Actualizar' : 'Crear plan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
