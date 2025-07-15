@extends('pageadmin.layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Nuevo Usuario para {{ $client->store_name }}</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('clients.users.store', $client) }}">
            @csrf

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Correo</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Crear Usuario
            </button>
        </form>
    </div>
</div>
@endsection