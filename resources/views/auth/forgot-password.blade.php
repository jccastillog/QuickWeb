@extends('pageadmin.layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header text-center bg-white">
        <h5 class="mb-0"><i class="bi bi-unlock me-2"></i> ¿Olvidaste tu Contraseña?</h5>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send-check"></i> Enviar enlace
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