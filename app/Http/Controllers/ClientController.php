<?php


namespace App\Http\Controllers;

use App\Http\Traits\HandlesMediaUploads;
use App\Models\Client;
use App\Models\Category;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Exception;

class ClientController extends Controller
{
    use HandlesMediaUploads;
    public function index()
    {
        $clients = Client::with([
            'siteSettings',
            'logo.media',
            'favicon.media',
            ])->orderByDesc('id')->paginate(10);
        $client = new Client();
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
                'categories',
                'logo.media',
                'favicon.media',
                'categories.image.media',
                'products.image.media',
                'products.category',
                'products.offers',
                'offers.image.media'
            ],
        );

        return view('pageadmin.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $clients = Client::with([
            'siteSettings',
            'logo.media',
            'favicon.media',
            ])->orderByDesc('id')->paginate(10);

        $client->load([
            'siteSettings',
            'logo.media',
            'favicon.media',
            ]);

        return view('pageadmin.index', compact('clients', 'client'));
    }

    public function store(StoreClientRequest $request)
    {
        try {
            $validated = $request->validated();
            $client = Client::create($validated);

            if ($request->hasFile('logo')) {
                $this->uploadMedia(
                    $client,
                    $request->file('logo'),
                    'logo'
                );
            }

            if ($request->hasFile('favicon')) {
                $this->uploadMedia(
                    $client,
                    $request->file('favicon'),
                    'favicon'
                );
            }

            $client->siteSettings()->create($request->all());

            return redirect()
                ->route('clients.index')
                ->with('success', 'Tienda creada exitosamente');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la tienda: '.$e->getMessage());
        }
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        try {
            $client->update($request->validated());

            if ($request->hasFile('logo')) {
                $this->uploadMedia(
                    $client,
                    $request->file('logo'),
                    'logo',
                    true
                );
            } elseif ($request->has('remove_logo') && $client->logo) {
                $this->deleteMedia($client->logo->media);
                $client->logo()->delete();
            }

            if ($request->hasFile('favicon')) {
                $this->uploadMedia(
                    $client,
                    $request->file('favicon'),
                    'favicon',
                    true
                );
            } elseif ($request->has('remove_favicon') && $client->favicon) {
                $this->deleteMedia($client->favicon->media);
                $client->favicon()->delete();
            }

            if ($client->siteSettings) {
                $client->siteSettings->update($request->all());
            }

            return redirect()
                ->route('clients.index')
                ->with('success', 'Tienda actualizada exitosamente');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la tienda: '.$e->getMessage());
        }
    }

    public function destroy(Client $client)
    {
        try {
            if ($client->logo) {
                $this->deleteMedia($client->logo->media);
                $client->logo()->delete();
            }

            if ($client->favicon) {
                $this->deleteMedia($client->favicon->media);
                $client->favicon()->delete();
            }

            $client->delete();

            return redirect()
                ->route('clients.index')
                ->with('success', 'Tienda eliminada exitosamente');

        } catch (Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la tienda: '.$e->getMessage());
        }
    }
}
