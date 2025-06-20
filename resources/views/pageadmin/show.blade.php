@extends('pageadmin.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">
                    <i class="bi bi-shop"></i> 
                    <a href="{{ app()->environment('local') 
                        ? 'http://127.0.0.1:8000/' . $client->domain 
                        : url('/' . $client->domain) }}">
                        {{ $client->store_name }}
                    </a>
                </h1>
                <div>
                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Editar
                    </a>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas -->
    <ul class="nav nav-tabs mb-4" id="clientTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button">Información</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button">Categorías</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button">Productos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="offers-tab" data-bs-toggle="tab" data-bs-target="#offers" type="button">Ofertas</button>
        </li>
    </ul>

    <!-- Contenido de Pestañas -->
    <div class="tab-content" id="clientTabsContent">
        <!-- Pestaña de Información -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            @include('pageadmin.partials.client-info')
        </div>

        <!-- Pestaña de Categorías -->
        <div class="tab-pane fade" id="categories" role="tabpanel">
            @include('pageadmin.partials.categories')
        </div>

        <!-- Pestaña de Productos -->
        <div class="tab-pane fade" id="products" role="tabpanel">
            @include('pageadmin.products.index', [
                'client' => $client,
                'products' => $client->products()->with(['category', 'image.media'])->paginate(12),
            ])
        </div>

        <!-- Pestaña de Ofertas -->
        <div class="tab-pane fade" id="offers" role="tabpanel">
            @include('pageadmin.partials.offers')
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-tabs .nav-link.active {
        font-weight: 600;
        border-bottom: 3px solid #4e73df;
    }
    .card-img-overlay {
        background: rgba(0, 0, 0, 0.3);
    }
</style>
@endpush

@push('scripts')
<script>
    // Activar pestañas y guardar la selección
    document.addEventListener('DOMContentLoaded', function() {
        const tabElms = document.querySelectorAll('button[data-bs-toggle="tab"]');

        tabElms.forEach(tabEl => {
            tabEl.addEventListener('shown.bs.tab', function(event) {
                localStorage.setItem('lastTab', event.target.id);
            });
        });

        const lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            const tab = new bootstrap.Tab(document.getElementById(lastTab));
            tab.show();
        }
    });
</script>
@endpush
