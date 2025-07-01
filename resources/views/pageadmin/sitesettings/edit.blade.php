@extends('pageadmin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Editar Configuración del Sitio para {{ $client->store_name }}</h6>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{ route('site-settings.update', $client) }}" method="POST">
                @csrf
                @method('PUT')
                @include('pageadmin.sitesettings.partials.form')
                <button type="submit" class="btn btn-primary">Actualizar Configuración</button>
                <a href="{{ route('clients.show', $client) }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection