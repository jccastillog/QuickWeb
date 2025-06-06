<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\SocialNetwork;
use App\Http\Requests\StoreSocialNetworkRequest;
use Illuminate\Http\Request;

class SocialNetworkController extends Controller
{
    public function create(Client $client)
    {
        $platforms = SocialNetwork::availablePlatforms();
        return view('pageadmin.social-networks.create', compact('client', 'platforms'));
    }

    public function store(StoreSocialNetworkRequest $request, Client $client)
    {
        try {
            $validated = $request->validated();
            $validated['client_id'] = $client->id;
            
            if (empty($validated['icon_class'])) {
                $validated['icon_class'] = 'bi bi-' . $validated['platform'];
            }
            
            SocialNetwork::create($validated);

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Red social agregada exitosamente');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la red social: ' . $e->getMessage());
        }
    }

    public function edit(Client $client, SocialNetwork $socialNetwork)
    {
        $platforms = SocialNetwork::availablePlatforms();
        return view('pageadmin.social-networks.edit', compact('client', 'socialNetwork', 'platforms'));
    }

    public function update(StoreSocialNetworkRequest $request, Client $client, SocialNetwork $socialNetwork)
    {
        try {
            $validated = $request->validated();
            
            // Actualizar icono si no se especifica
            if (empty($validated['icon_class'])) {
                $validated['icon_class'] = 'bi bi-' . $validated['platform'];
            }
            
            $socialNetwork->update($validated);

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Red social actualizada exitosamente');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la red social: ' . $e->getMessage());
        }
    }

    public function destroy(Client $client, SocialNetwork $socialNetwork)
    {
        try {
            $socialNetwork->delete();
            
            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Red social eliminada exitosamente');
                
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la red social: ' . $e->getMessage());
        }
    }
}