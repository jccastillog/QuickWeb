@extends('pageadmin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Crear Nueva Página para {{ $client->name }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pages.store', $client) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Título*</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenido*</label>
                            <textarea class="form-control" id="content" name="content" rows="8" required></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="order" class="form-label">Orden</label>
                                <input type="number" class="form-control" id="order" name="order" min="0" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="active">Estado</label>
                                    <select class="form-control @error('active') is-invalid @enderror" id="active" name="active">
                                        <option value="1" selected>Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                    @error('active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Página</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection