<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;

class EnsureClientOwnership
{
    /**
     * Permite el acceso a /clients/{client}/... solo al admin o al usuario dueño de la tienda.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $client = $request->route('client');

        if (!$user) {
            abort(403);
        }

        if ($user->role === 'admin') {
            return $next($request);
        }

        if (!$client instanceof Client || $client->user_id !== $user->id) {
            abort(403, 'No tienes permiso para administrar esta tienda');
        }

        return $next($request);
    }
}
