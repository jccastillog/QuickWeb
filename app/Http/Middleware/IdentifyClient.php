<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;

class IdentifyClient
{
    public function handle($request, Closure $next)
    {
        $exemptPaths = [
            '/',
            'pageadmin',
            'clients*',
            'clients.categories.create'
        ];

        foreach ($exemptPaths as $path) {
            if ($request->is($path)) {
                return $next($request);
            }
        }

        $domain = $this->extractDomain($request);
        
        $client = Client::where('domain', $domain)->first();

        if (!$client) {
            abort(404, 'Tienda no encontrada');
        }

        // Compartir el cliente con todas las vistas
        view()->share('currentClient', $client);

        // Inyectar en todas las solicitudes
        $request->attributes->add(['currentClient' => $client]);

        return $next($request);
    }

    protected function extractDomain($request)
    {
        $host = $request->getHost(); // Ej: "cliente1.quickweb.com.co" o "localhost"

        // Modo local: usar segmento de URL
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            return $request->segment(1) ?: config('client.default_client');
        }

        // Producción: usar subdominio
        $parts = explode('.', $host);

        // Si el dominio tiene al menos 3 partes, asumimos que el primero es el cliente
        if (count($parts) >= 3) {
            return $parts[0]; // cliente1
        }

        // Si no hay subdominio (acceso directo al dominio raíz), usa cliente por defecto
        return config('client.default_client');
    }
}