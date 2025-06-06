<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteSettingsRequest;
use App\Models\SiteSettings;
use App\Models\Client;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function create(Client $client)
    {
        return view('pageadmin.sitesettings.create', compact('client'));
    }

    public function store(StoreSiteSettingsRequest $request, Client $client)
    {
        try {
            $validated = $request->validated();
            
            $client->siteSettings()->create($validated);

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Configuración del sitio creada exitosamente');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la configuración: '.$e->getMessage());
        }
    }

    public function edit(Client $client)
    {
        $siteSettings = $client->siteSettings;
        return view('pageadmin.sitesettings.edit', compact('client', 'siteSettings'));
    }

    public function update(StoreSiteSettingsRequest $request, Client $client)
    {
        try {
            
            $client->siteSettings()->update($request->validated());

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Configuración del sitio creada exitosamente');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la configuración: '.$e->getMessage());
        }
    }
}