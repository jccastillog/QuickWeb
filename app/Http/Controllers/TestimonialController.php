<?php

namespace App\Http\Controllers;

use App\Http\Traits\HandlesMediaUploads;
use App\Models\Client;
use App\Models\Testimonial;
use App\Http\Requests\StoreTestimonialRequest;

use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use HandlesMediaUploads;
    public function create(Client $client)
    {
        return view('pageadmin.testimonials.create', compact('client'));
    }

    public function store(StoreTestimonialRequest $request, Client $client)
    {
        try {
            $validated = $request->validated();
            $validated['client_id'] = $client->id;

            $testimonial = Testimonial::create($validated);

            if ($request->hasFile('image')) {
                $this->uploadMedia(
                    $testimonial,
                    $request->file('image'),
                    'testimonial_image'
                );
            }

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Testimonio creado exitosamente');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear el testimonio: '.$e->getMessage());
        }
    }

    public function edit(Client $client, Testimonial $testimonial)
    {
        return view('pageadmin.testimonials.edit', compact('client', 'testimonial'));
    }

    public function update(StoreTestimonialRequest $request, Client $client, Testimonial $testimonial)
    {
        try {
            $testimonial->update($request->validated());

            if ($request->hasFile('image')) {
                $this->uploadMedia(
                    $testimonial,
                    $request->file('image'),
                    'testimonial_image',
                    true
                );
            } elseif ($request->has('remove_image') && $testimonial->image) {
                $this->deleteMedia($testimonial->image->media);
                $testimonial->image()->delete();
            }

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Testimonio actualizado exitosamente');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el testimonio: '.$e->getMessage());
        }
    }

    public function destroy(Client $client, Testimonial $testimonial)
    {
        try {

            if ($testimonial->image) {
                $this->deleteMedia($testimonial->image->media);
                $testimonial->image()->delete();
            }

            $testimonial->delete();

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Testimonio eliminado exitosamente');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar el testimonio: '.$e->getMessage());
        }
    }
}
