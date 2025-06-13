@extends('pageadmin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Editar Testimonio de {{ $testimonial->author_name }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('testimonials.update', [$client, $testimonial]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="author_name" class="form-label">Nombre del Autor*</label>
                                <input type="text" class="form-control" id="author_name" name="author_name"
                                    value="{{ old('author_name', $testimonial->author_name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="author_position" class="form-label">Cargo/Puesto</label>
                                <input type="text" class="form-control" id="author_position" name="author_position"
                                    value="{{ old('author_position', $testimonial->author_position) }}">
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Contenido*</label>
                                <textarea class="form-control" id="content" name="content" rows="4" required>{{ old('content', $testimonial->content) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="rating" class="form-label">Calificación*</label>
                                <select class="form-select" id="rating" name="rating" required>
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}"
                                            {{ $testimonial->rating == $i ? 'selected' : '' }}>
                                            {{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Imagen del Autor</label>
                                <input type="file" class="form-control" id="image" name="image">

                                @if ($testimonial->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $testimonial->image->media->path) }}"
                                            alt="{{ $testimonial->author_name }}" class="img-thumbnail"
                                            style="max-width: 150px;">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="remove_image"
                                                name="remove_image">
                                            <label class="form-check-label" for="remove_image">
                                                Eliminar imagen actual
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="order" class="form-label">Orden de Visualización</label>
                                <input type="number" class="form-control" id="order" name="order" min="0"
                                    value="{{ old('order', $testimonial->order) }}">
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="form-group">
                                    <label for="active">Estado</label>
                                    <select class="form-control @error('active') is-invalid @enderror" id="active"
                                        name="active">
                                        <option value="1" {{ old('active', $testimonial->active) ? 'selected' : '' }}>
                                            Activo</option>
                                        <option value="0" {{ !old('active', $testimonial->active) ? 'selected' : '' }}>
                                            Inactivo</option>
                                    </select>
                                    @error('active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">Cancelar</a>
                                <div>
                                    <button type="submit" class="btn btn-primary">Actualizar Testimonio</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="confirmDelete()">Eliminar</button>
                                </div>
                            </div>
                        </form>

                        <form id="delete-form" action="{{ route('testimonials.destroy', [$client, $testimonial]) }}"
                            method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('¿Estás seguro de que deseas eliminar este testimonio?')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endsection
