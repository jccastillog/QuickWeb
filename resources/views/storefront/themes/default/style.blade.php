:root {
    --color-primario: {{ $client->primary_color ?? '#8ac1ff' }};
    --color-secundario: {{ $client->secondary_color ?? '#6c757d' }};
    --fuente-base: {{ $client->font ?? 'sans-serif' }};
}

body {
    font-family: var(--fuente-base);
    color: #212529;
    background-color: #fff;
}

/* Ejemplo de uso de colores personalizados */
.btn-primary {
    background-color: var(--color-primario);
    border-color: var(--color-primario);
}
.btn-primary:hover {
    background-color: darken(var(--color-primario), 10%);
    border-color: darken(var(--color-primario), 10%);
}

.text-primary {
    color: var(--color-primario) !important;
}
.bg-primary {
    background-color: var(--color-primario) !important;
}

#infoModalBody {
    white-space: pre-wrap;
    line-height: 1.6;
    text-align: justify;
    font-size: 0.95rem;
}

.modal-content::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200px;
    height: 200px;
    background-image: url('{{ $client->logo->media->full_url ?? asset('images/logo.png') }}');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    opacity: 0.05;
    transform: translate(-50%, -50%);
    pointer-events: none;
}

.modal-body {
    padding: 2rem;
}