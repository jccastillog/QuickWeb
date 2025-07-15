@extends('pageadmin.layouts.app')

@section('title', 'Definir Nueva Contraseña')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header text-center bg-white">
        <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i> Establecer Nueva Contraseña</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ request()->email }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-arrow-repeat"></i> Actualizar Contraseña
                </button>
            </div>
        </form>

        <div class="mt-3 text-center">
            <a href="{{ route('login') }}" class="text-decoration-none text-muted">
                Volver al inicio de sesión
            </a>
        </div>
    </div>
</div>
@endsection