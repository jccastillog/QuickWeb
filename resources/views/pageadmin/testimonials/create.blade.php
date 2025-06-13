@extends('pageadmin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Agregar Testimonio para {{ $client->store_name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('testimonials.store', $client) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="author_name" class="form-label">Nombre del Autor*</label>
                            <input type="text" class="form-control" id="author_name" name="author_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="author_position" class="form-label">Cargo/Puesto</label>
                            <input type="text" class="form-control" id="author_position" name="author_position">
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenido*</label>
                            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Calificación*</label>
                            <select class="form-select" id="rating" name="rating" required>
                                <option value="5">★★★★★</option>
                                <option value="4">★★★★☆</option>
                                <option value="3">★★★☆☆</option>
                                <option value="2">★★☆☆☆</option>
                                <option value="1">★☆☆☆☆</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Imagen del Autor</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">Orden de Visualización</label>
                            <input type="number" class="form-control" id="order" name="order" min="0" value="0">
                        </div>

                        <div class="col-md-3 mb-2">
                            <div class="form-group">
                                <label for="active">Estado</label>
                                <select class="form-control @error('active') is-invalid @enderror" id="active"
                                    name="active">
                                    <option value="1" {{ old('active', 1) ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ !old('active', 1) ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Testimonio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
