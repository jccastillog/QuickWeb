<?php


namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Category;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with([
            'siteSettings', 
            'socialNetworks', 
            'plans', 
            'pages', 
            'testimonials',
            'logo.media', 
            'favicon.media', 
            ])->orderByDesc('id')->paginate(10);
        $client = new Client(); // Objeto vacío para el formulario de creación
        return view('pageadmin.index', compact('clients', 'client'));
    }

        public function show(Client $client)
    {
        // Cargar relaciones necesarias
        $client->load([
            'siteSettings', 
            'socialNetworks', 
            'plans', 
            'pages', 
            'testimonials',
            'offers',
            'categories' =>  function($query) {
                $query->with(['image', 'products']);
            },
            'products' => function($query) {
                $query->with(['images', 'category', 'offers']);
            },
            'logo.media',
            'favicon.media'
        ],
        );

        return view('pageadmin.show', compact('client'));
    }

    public function edit(Client $client)
    {

        $clients = Client::with([
            'siteSettings', 
            'socialNetworks', 
            'plans', 
            'pages', 
            'testimonials',
            'logo.media', 
            'favicon.media', 
            ])->orderByDesc('id')->paginate(10);

        $client->load([
            'logo.media',
            'favicon.media'
        ],);

        return view('pageadmin.index', compact('clients', 'client'));
    }

    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();
        $client = Client::create($validated);

        if ($request->validated('logo')) {
            $client->uploadLogo($request->file('logo'));
        }

        // Subir favicon si se proporcionó
        if ($request->validated('favicon')) {
            $client->uploadFavicon($request->file('favicon'));
        }

        // Crear configuraciones iniciales
        $client->siteSettings()->create($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Tienda creada exitosamente');
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        // Manejar logo
        if ($request->hasFile('logo')) {
            $client->uploadLogo($request->file('logo'));
        } elseif ($request->hasFile('remove_logo') && $client->logo) {
            $client->logo->delete();
        }

        // Manejar favicon
        if ($request->hasFile('favicon')) {
            $client->uploadFavicon($request->file('favicon'));
        } elseif ($request->hasFile('remove_favicon') && $client->favicon) {
            $client->favicon->delete();
        }

        // Actualizar configuraciones
        if ($client->siteSettings) {
            $client->siteSettings->update($request->all());
        }

        return redirect()->route('clients.index')
            ->with('success', 'Tienda actualizada');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')
            ->with('success', 'Tienda eliminada');
    }
}