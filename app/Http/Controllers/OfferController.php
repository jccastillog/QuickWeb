<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Offer;
use App\Models\Product;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Traits\HandlesMediaUploads;
use Exception;
use Illuminate\Support\Carbon;

class OfferController extends Controller
{
    use HandlesMediaUploads;

    public function create(Client $client)
    {
        $client->load([
                'products',
                'categories'
            ]);

        return view('pageadmin.offers.create', compact('client'));
    }

    public function store(StoreOfferRequest $request, Client $client)
    {
        try {
            $validated = $request->validated();
            $validated['client_id'] = $client->id;

            // Convertir fechas a formato correcto
            $validated['start_date'] = Carbon::parse($validated['start_date']);
            $validated['end_date'] = Carbon::parse($validated['end_date']);

            $offer = Offer::create($validated);

            // Subir imagen si existe
            if ($request->hasFile('image')) {
                $this->uploadMedia(
                    $offer,
                    $request->file('image'),
                    'offer_image'
                );
            }

            return redirect()->route('clients.show', [$client, $offer])
                ->with('success', 'Oferta creada exitosamente');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la oferta: ' . $e->getMessage());
        }
    }

    public function edit(Client $client, Offer $offer)
    {
        if ($offer->client_id !== $client->id) {
            abort(404);
        }

        $categories = $offer->categories;
        $products = $offer->products;
        $offer->load(['image.media']);

        return view('pageadmin.offers.edit', compact('client', 'offer','categories','products'));
    }

    public function update(StoreOfferRequest $request, Client $client, Offer $offer)
    {
        if ($offer->client_id !== $client->id) {
            abort(404);
        }

        try {
            $validated = $request->validated();

            // Convertir fechas a formato correcto
            $validated['start_date'] = Carbon::parse($validated['start_date']);
            $validated['end_date'] = Carbon::parse($validated['end_date']);

            $offer->update($validated);

            // Manejo de imagen
            if ($request->hasFile('image')) {
                $this->uploadMedia(
                    $offer,
                    $request->file('image'),
                    'offer_image',
                    true
                );
            } elseif ($request->has('remove_image') && $offer->image) {
                $this->deleteMedia($offer->image->media);
                $offer->image()->delete();
            }

            return redirect()->route('clients.show', [$client, $offer])
                ->with('success', 'Oferta actualizada exitosamente');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la oferta: ' . $e->getMessage());
        }
    }

    public function destroy(Client $client, Offer $offer)
    {
        if ($offer->client_id !== $client->id) {
            abort(404);
        }

        try {
            $offer->load(['image.media']);

            // Eliminar imagen asociada si existe
            if ($offer->image) {
                $this->deleteMedia($offer->image->media);
                $offer->image()->delete();
            }

            $offer->delete();

            return redirect()->route('clients.show', $client)
                ->with('success', 'Oferta eliminada exitosamente');

        } catch (Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la oferta: ' . $e->getMessage());
        }
    }
}