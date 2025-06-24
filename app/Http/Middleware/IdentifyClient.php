<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;
use Illuminate\Support\Str;

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

        \Log::info('[Middleware] Host detectado: ' . $request->getHost());
        \Log::info('[Middleware] Dominio interpretado: ' . $domain);
        if (!$client) {
            \Log::warning('[Middleware] Cliente no encontrado para: ' . $domain);
            abort(404, 'Tienda no encontrada');
        }

        \Log::info('[Middleware] Cliente encontrado: ' . $client->store_name);



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
        $base = 'quickweb.com.co';

        // Modo local: usar segmento de URL
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            return $request->segment(1) ?: config('client.default_client');
        }

        if (Str::endsWith($host, $base)) {
            return Str::before($host, '.' . $base); // devuelve 'quickweb'
        }

        // Si no hay subdominio (acceso directo al dominio raíz), usa cliente por defecto
        return $host;
    }
}