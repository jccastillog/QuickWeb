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

/* Botones con el color de la tienda. Se usan las variables de Bootstrap para que
   hover, focus y active conserven el color; el oscurecimiento se hace con filter
   porque CSS no puede oscurecer un color arbitrario de forma confiable. */
.btn-primary {
    --bs-btn-bg: var(--color-primario);
    --bs-btn-border-color: var(--color-primario);
    --bs-btn-hover-bg: var(--color-primario);
    --bs-btn-hover-border-color: var(--color-primario);
    --bs-btn-active-bg: var(--color-primario);
    --bs-btn-active-border-color: var(--color-primario);
    --bs-btn-disabled-bg: var(--color-primario);
    --bs-btn-disabled-border-color: var(--color-primario);
}
.btn-primary:hover,
.btn-primary:focus-visible {
    filter: brightness(0.9);
}
.btn-primary:active {
    filter: brightness(0.8);
}

.btn-outline-primary {
    --bs-btn-color: var(--color-primario);
    --bs-btn-border-color: var(--color-primario);
    --bs-btn-hover-bg: var(--color-primario);
    --bs-btn-hover-border-color: var(--color-primario);
    --bs-btn-hover-color: #fff;
    --bs-btn-active-bg: var(--color-primario);
    --bs-btn-active-border-color: var(--color-primario);
    --bs-btn-active-color: #fff;
}

.btn {
    transition: filter .15s ease-in-out, background-color .15s ease-in-out, color .15s ease-in-out;
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