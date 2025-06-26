:root {
    --color-primario: {{ $client->primary_color ?? '#8ac1ff' }};
    --color-secundario: {{ $client->secondary_color ?? '#6c757d' }};
    --fuente-base: {{ $client->font_family ?? 'sans-serif' }};
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