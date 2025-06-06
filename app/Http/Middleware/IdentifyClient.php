<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;

class IdentifyClient
{
    public function handle($request, Closure $next)
    {
        if (in_array($domain = $request->getHost(), ['localhost', '127.0.0.1'])) {
            return $next($request);
        }

        $domain = $request->getHost(); // Obtiene el dominio completo

        $client = Client::where('domain', $domain)
            ->orWhere('domain', 'like', '%.' . $domain)
            ->first();

        if (!$client) {
            abort(404, 'Tienda no encontrada');
        }

        // Compartir el cliente con todas las vistas
        view()->share('currentClient', $client);

        // Inyectar en todas las solicitudes
        $request->attributes->add(['currentClient' => $client]);

        return $next($request);
    }
}