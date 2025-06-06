    @extends('pageadmin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Listado de Clientes -->
            <div class="col-md-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Clientes Quickweb</h6>
                        <button class="btn btn-sm btn-primary" onclick="resetForm()">
                            <i class="fas fa-plus"></i> Nueva Tienda
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr class="text-center bold">
                                        <th>Nombre</th>
                                        <th>Dominio</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($clients as $item)
                                        <tr>
                                            <td>{{ $item->store_name }}</td>
                                            <td>{{ $item->domain }}</td>
                                            <td>
                                                <span class="badge bg-{{ $item->active ? 'success' : 'danger' }}">
                                                    {{ $item->active ? 'Activa' : 'Inactiva' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('clients.edit', $item) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('clients.show', $item) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No hay tiendas registradas</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            <div class="pagination">
                                {{ $clients->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="col-md-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ $client->exists ? 'Editar' : 'Crear' }} Tienda
                        </h6>
                    </div>
                    <div class="card-body">
                        <form id="client-form"
                            action="{{ $client->exists ? route('clients.update', $client) : route('clients.store') }}"
                            method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @if ($client->exists)
                                @method('PUT')
                            @endif
                            <!-- Sección de Información Básica -->
                            <div class="form-row mb-3">
                                <div class="form-group col-md-12 d-flex justify-content-start align-items-center"> 
                                    <div class="mr-3">
                                        <label for="logo">Logo</label>
                                        <div>
                                            @if($client->logo && $client->logo->media)
                                                <img src="{{ $client->logo->media->full_url }}" 
                                                    alt="{{ $client->store_name }}" 
                                                    class="img-thumbnail" 
                                                    style="width: 80px; height: 80px; object-fit: contain;">
                                            @else
                                                <span class="text-muted">Sin logo</span>
                                            @endif
                                        </div>
                                        <input type="file" class="form-control-file @error('logo') is-invalid @enderror"
                                            id="logo" 
                                            name="logo" 
                                            accept="image/*">
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <h3>...</h3>
                                    <div>
                                        <label for="favicon">Favicon</label>
                                        <div>
                                            @if($client->favicon && $client->favicon->media)
                                                <img src="{{ $client->favicon->media->full_url }}" 
                                                    alt="{{ $client->store_name }}" 
                                                    class="img-thumbnail" 
                                                    style="width: 80px; height: 80px; object-fit: contain;">
                                            @else
                                                <span class="text-muted">Sin favicon</span>
                                            @endif
                                        </div>
                                        <input type="file" class="form-control-file @error('favicon') is-invalid @enderror"
                                            id="favicon" name="favicon" accept="image/*">
                                            @error('favicon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <td class="text-center">
                                <div class="form-group col-md-6">
                                    <label for="store_name">Nombre de la Tienda*</label>
                                    <input type="text" class="form-control @error('store_name') is-invalid @enderror"
                                        id="store_name" name="store_name"
                                        value="{{ old('store_name', $client->store_name) }}" required>
                                    @error('store_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="domain">Dominio*</label>
                                    <input type="text" class="form-control @error('domain') is-invalid @enderror"
                                        id="domain" name="domain" value="{{ old('domain', $client->domain) }}"
                                        required>
                                    @error('domain')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sección de Diseño -->
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="primary_color">Color Primario</label>
                                    <input type="color" class="form-control @error('primary_color') is-invalid @enderror"
                                        id="primary_color" name="primary_color"
                                        value="{{ old('primary_color', $client->primary_color ?? '#007bff') }}">
                                    @error('primary_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="secondary_color">Color Secundario</label>
                                    <input type="color"
                                        class="form-control @error('secondary_color') is-invalid @enderror"
                                        id="secondary_color" name="secondary_color"
                                        value="{{ old('secondary_color', $client->secondary_color ?? '#6c757d') }}">
                                    @error('secondary_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="theme">Tema</label>
                                    <select class="form-control @error('theme') is-invalid @enderror" id="theme"
                                        name="theme">
                                        <option value="light"
                                            {{ old('theme', $client->theme) == 'light' ? 'selected' : '' }}>Claro</option>
                                        <option value="dark"
                                            {{ old('theme', $client->theme) == 'dark' ? 'selected' : '' }}>Oscuro</option>
                                    </select>
                                    @error('theme')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Sección de Configuración -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="font">Fuente</label>
                                    <input type="text" class="form-control @error('font') is-invalid @enderror"
                                        id="font" name="font" value="{{ old('font', $client->font) }}"
                                        placeholder="Ej: 'Roboto', sans-serif">
                                    @error('font')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="expires_at">Fecha de Expiración</label>
                                    <input type="date" class="form-control @error('expires_at') is-invalid @enderror"
                                        id="expires_at" name="expires_at"
                                        value="{{ old('expires_at', optional($client->expires_at)->format('Y-m-d')) }}">
                                    @error('expires_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="timezone">Zona Horaria</label>
                                <select class="form-control @error('timezone') is-invalid @enderror" id="timezone"
                                    name="timezone">
                                    @foreach (DateTimeZone::listIdentifiers() as $zone)
                                        <option value="{{ $zone }}"
                                            {{ old('timezone', $client->timezone) == $zone ? 'selected' : '' }}>
                                            {{ $zone }}</option>
                                    @endforeach
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="active" name="active" value="1"
                                    {{ old('active', $client->active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Tienda Activa</label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> {{ $client->exists ? 'Actualizar' : 'Guardar' }}
                                </button>

                                @if ($client->exists)
                                    <button type="button" class="btn btn-danger"
                                        onclick="if(confirm('¿Eliminar esta tienda?')) {
                                            document.getElementById('delete-form').submit();
                                        }">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                @endif
                            </div>
                        </form>

                        @if ($client->exists)
                            <form id="delete-form" action="{{ route('clients.destroy', $client) }}" method="POST"
                                class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function resetForm() {
            document.getElementById('client-form').reset();
            window.location.href = "{{ route('clients.index') }}";
        }
    </script>
@endpush
