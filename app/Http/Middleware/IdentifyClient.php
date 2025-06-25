<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;
use Illuminate\Support\Str;

class IdentifyClient
{
    public function handle($request, Closure $next)
    {
        \Log::info('[Middleware] Ejecutando IdentifyClient para: ' . $request->getHost());
        $exemptPaths = [
            '/',
            'pageadmin',
            'clients*',
            'clients.categories.create'
        ];

        $currentPath = $request->path(); // ejemplo: 'pageadmin' o '/'
        $currentHost = $request->getHost(); // ejemplo: 'cliente1.quickweb.com.co'


        foreach ($exemptPaths as $path) {
            if ($request->is($path)) {
                \Log::info("[Middleware] Excepción de path: {$currentPath}");
                return $next($request);
            }
        }

        $mainDomain = 'quickweb.com.co';
        if (
            app()->environment('production') &&
            ($currentHost === $mainDomain || Str::endsWith($currentHost, ".{$mainDomain}") === false)
            && $currentPath === '/'
        ) {
            \Log::info("[Middleware] Acceso permitido a raíz principal de producción");
            return $next($request);
        }

        $domain = $this->extractDomain($request);
        \Log::info('[Middleware] Dominio extraído: ' . $domain);
        
        $client = Client::where('domain', $domain)->first();
        
        // Compartir el cliente con todas las vistas
        view()->share('currentClient', $client);

        // Inyectar en todas las solicitudes
        $request->attributes->add(['currentClient' => $client]);

        if (!$client) {
            \Log::warning('[Middleware] Cliente no encontrado para: ' . $domain);
            abort(404, 'Tienda no encontrada');
        }

        \Log::info('[Middleware] Cliente encontrado: ' . $client->store_name);

        return $next($request);
    }

    protected function extractDomain($request)
    {
        $host = $request->getHost(); // Ej: "cliente1.quickweb.com.co" o "localhost"
        $base = 'quickweb.com.co';

        // Modo local: usar segmento de URL
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            return $request->segment(1) ?: config('client.default_client');
        }

        if (Str::endsWith($host, $base) && $host !== $base) {
            return Str::before($host, '.' . $base);
        }

        return $host;
    }
}