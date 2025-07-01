@extends('pageadmin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Editar Red Social para {{ $client->store_name }}</h6>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('social-networks.update', [$client, $socialNetwork]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="platform">Plataforma*</label>
                                <select class="form-control @error('platform') is-invalid @enderror" id="platform"
                                    name="platform" required>
                                    <option value="">Seleccione una plataforma</option>
                                    @foreach ($platforms as $key => $name)
                                        <option value="{{ $key }}"
                                            {{ old('platform', $socialNetwork->platform) == $key ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('platform')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url">URL*</label>
                                <input type="url" class="form-control @error('url') is-invalid @enderror" id="url"
                                    name="url" value="{{ old('url', $socialNetwork->url) }}" required>
                                @error('url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="icon_class">Clase del Icono</label>
                                <input type="text" class="form-control @error('icon_class') is-invalid @enderror"
                                    id="icon_class" name="icon_class"
                                    value="{{ old('icon_class', $socialNetwork->icon_class) }}"
                                    placeholder="Ej: bi bi-facebook">
                                @error('icon_class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="order">Orden</label>
                                <input type="number" min="0"
                                    class="form-control @error('order') is-invalid @enderror" id="order" name="order"
                                    value="{{ old('order', $socialNetwork->order) }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="active">Estado</label>
                                <select class="form-control @error('active') is-invalid @enderror" id="active"
                                    name="active">
                                    <option value="1" {{ old('active', $socialNetwork->active) ? 'selected' : '' }}>
                                        Activo</option>
                                    <option value="0" {{ !old('active', $socialNetwork->active) ? 'selected' : '' }}>
                                        Inactivo</option>
                                </select>
                                @error('active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Red Social</button>
                    <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">Cancelar</a>
                </form>

                <hr>

                <form action="{{ route('social-networks.destroy', [$client, $socialNetwork]) }}" method="POST"
                    class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('¿Estás seguro de eliminar esta red social?')">
                        <i class="fas fa-trash"></i> Eliminar Red Social
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
