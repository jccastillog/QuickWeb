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

        $currentPath = $request->path(); // Ej: 'pageadmin' o '/'
        $currentHost = $request->getHost(); // Ej: 'cliente1.quickweb.com.co'
        if (app()->environment('local') ? $mainDomain = '127.0.0.1' : $mainDomain = 'quickweb.com.co');

        $isMainDomain = $currentHost === $mainDomain || $currentHost === "www.{$mainDomain}";

        // Excepciones permitidas solo si es el dominio principal (no subdominios)
        $exemptPaths = [
            '/',              // solo permitimos "/" si es dominio principal
            'pageadmin',
            'clients*',
            'plans*',
            'clients.categories.create',
            'login',
            'user/password',
            'logout',
            'forgot-password',
            'reset-password*'
        ];

        foreach ($exemptPaths as $path) {
            if ($request->is($path) && $isMainDomain) {
                \Log::info("[Middleware] Excepción permitida en dominio principal para: {$currentPath}");
                return $next($request);
            }
        }

        // Continuar con identificación del cliente para subdominios o dominios personalizados
        $client = $this->findClient($request);

        if (!$client || !$client->active) {
            \Log::warning('[Middleware] Cliente no encontrado o inactivo para: ' . $currentHost . '/' . $currentPath);
            abort(404, 'Tienda no encontrada');
        }

        if ($client->isSuspended()) {
            return response()->view('storefront.suspended', ['client' => $client], 503);
        }

        \Log::info('[Middleware] Cliente encontrado: ' . $client->store_name);

        // Inyectar en todas las solicitudes
        $request->attributes->add(['currentClient' => $client]);
        // Compartir el cliente con todas las vistas
        view()->share('currentClient', $client);
        // Registrar en el contenedor de servicios
        app()->instance('currentClient', $client);

        return $next($request);
    }

    protected function findClient($request): ?Client
    {
        $host = strtolower($request->getHost()); // Ej: "cliente1.quickweb.com.co" o "localhost"
        $base = 'quickweb.com.co';

        // Modo local: usar segmento de URL como dominio
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            $domain = $request->segment(1) ?: config('client.default_client', 'demo');

            return Client::where('domain', $domain)->first();
        }

        // Si es un subdominio de quickweb.com.co, extraer solo el subdominio
        if (Str::endsWith($host, '.' . $base)) {
            return Client::where('domain', Str::before($host, '.' . $base))->first();
        }

        // Dominio propio de la tienda (con o sin www)
        $customDomain = preg_replace('/^www\./', '', $host);

        return Client::where('custom_domain', $customDomain)->first()
            ?? Client::where('domain', $host)->first();
    }
}
