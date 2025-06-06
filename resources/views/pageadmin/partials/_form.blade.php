<form id="client-form" action="{{ $client->exists ? route('clients.update', $client) : route('clients.store') }}"
    method="POST">
    @csrf
    @if ($client->exists)
        @method('PUT')
    @endif

    <input type="hidden" id="client-id" name="id" value="{{ $client->id ?? '' }}">

    <div class="form-group">
        <label for="name">Nombre del Cliente</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $client->name) }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="domain">Dominio</label>
        <input type="text" class="form-control @error('domain') is-invalid @enderror" id="domain" name="domain"
            value="{{ old('domain', $client->domain) }}" required>
        @error('domain')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="theme">Plantilla</label>
        <select class="form-control @error('theme') is-invalid @enderror" id="theme" name="theme" required>
            <option value="default" {{ old('theme', $client->theme) == 'default' ? 'selected' : '' }}>Default</option>
            <option value="modern" {{ old('theme', $client->theme) == 'modern' ? 'selected' : '' }}>Modern</option>
            <option value="classic" {{ old('theme', $client->theme) == 'classic' ? 'selected' : '' }}>Classic</option>
        </select>
        @error('theme')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
            {{ old('is_active', $client->is_active) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Activo</label>
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ $client->exists ? 'Actualizar' : 'Guardar' }}
        </button>

        @if ($client->exists)
            <button type="button" class="btn btn-danger"
                onclick="if(confirm('¿Eliminar este cliente?')) {
                        document.getElementById('delete-form').submit();
                    }">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        @endif
    </div>
</form>

@if ($client->exists)
    <form id="delete-form" action="{{ route('clients.destroy', $client) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endif
