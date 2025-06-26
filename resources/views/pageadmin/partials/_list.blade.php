<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>Nombre</th>
                <th>Dominio</th>
                <th>Plantilla</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->domain }}</td>
                    <td>{{ ucfirst($item->theme) }}</td>
                    <td>
                        <span class="badge badge-{{ $item->is_active ? 'success' : 'danger' }}">
                            {{ $item->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('clients.edit', $item) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay clientes registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
