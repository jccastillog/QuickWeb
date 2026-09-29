@extends('pageadmin.layouts.app')

@section('title', 'Planes')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h3 class="m-0 font-weight-bold text-primary">Planes QuickWeb</h3>
                <a href="{{ route('plans.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Nuevo plan
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Plan</th>
                                <th class="text-end">Precio / mes</th>
                                <th class="text-center">Productos</th>
                                <th class="text-center">Dominio propio</th>
                                <th class="text-center">Tiendas</th>
                                <th class="text-center">Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($plans as $plan)
                                <tr>
                                    <td>
                                        <strong>{{ $plan->name }}</strong>
                                        @if ($plan->description)
                                            <div class="small text-muted">{{ $plan->description }}</div>
                                        @endif
                                    </td>
                                    <td class="text-end">{{ App\Support\Money::format($plan->price) }}</td>
                                    <td class="text-center">{{ $plan->product_limit_label }}</td>
                                    <td class="text-center">
                                        <i class="bi {{ $plan->allows_custom_domain ? 'bi-check-circle-fill text-success' : 'bi-dash text-muted' }}"></i>
                                    </td>
                                    <td class="text-center">{{ $plan->clients_count }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $plan->active ? 'success' : 'secondary' }}">
                                            {{ $plan->active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('plans.edit', $plan) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No hay planes creados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="small text-muted mb-0">
                    Un plan inactivo no se ofrece al asignar tiendas, pero las tiendas que ya lo tienen lo conservan.
                </p>
            </div>
        </div>
    </div>
@endsection
