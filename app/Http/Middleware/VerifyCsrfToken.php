<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/',
        // Formulario público de catálogo (sin sesión, con límite de envíos): en dominios
        // propios la cookie de sesión puede no existir y el token CSRF fallaría
        'newsletter',
        '*/newsletter',
        'api/newsletter/*',
    ];
}
