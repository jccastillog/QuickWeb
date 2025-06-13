@extends('pageadmin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Crear Nueva Categoría para {{ $client->store_name }}
                        </h6>
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('clients.categories.store', $client) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name" class="font-weight-bold">Nombre*</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="order" class="font-weight-bold">Orden</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                        id="order" name="order" min="0" value="{{ old('order', 0) }}">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="font-weight-bold">Descripción</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" type="checkbox" id="featured" name="featured"
                                            value="1" {{ old('featured') ? 'checked' : '' }}>
                                        <label class="form-check-label font-weight-bold" for="featured">Categoría
                                            Destacada</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="image" class="font-weight-bold">Imagen de la categoría</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Tamaño recomendado: 800x600 px</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Crear Categoría
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
