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
        $host = $request->getHost();
        
        // Si es localhost o IP local, usa el primer segmento de la URL como dominio
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            return $request->segment(1) ?: config('app.default_client');
        }
        
        // Para entornos de producción, usa el host completo
        return $host;
    }
}