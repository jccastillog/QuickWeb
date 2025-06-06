<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function create(Client $client)
    {
        return view('pageadmin.pages.create', compact('client'));
    }

    public function store(StorePageRequest $request, Client $client)
    {
        try {
            $validated = $request->validated();
            
            $page = $client->pages()->create($validated);

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Página creada exitosamente');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la página: '.$e->getMessage());
        }
    }

    public function edit(Client $client, Page $page)
    {
        return view('pageadmin.pages.edit', compact('client', 'page'));
    }

    public function update(StorePageRequest $request, Client $client, Page $page)
    {
        try {
            $page->update($request->validated());

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Página actualizada exitosamente');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la página: '.$e->getMessage());
        }
    }

    public function destroy(Client $client, Page $page)
    {
        try {
            $page->delete();
            
            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Página eliminada exitosamente');
                
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la página: '.$e->getMessage());
        }
    }
}