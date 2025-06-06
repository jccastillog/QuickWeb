<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Testimonial;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function create(Client $client)
    {
        return view('pageadmin.testimonials.create', compact('client'));
    }

    public function store(StoreTestimonialRequest $request, Client $client)
    {
        try {
            $validated = $request->validated();
            $validated['client_id'] = $client->id;
            
            Testimonial::create($validated);

            if ($request->hasFile('testimonial_image')) {
                $testimonial->uploadImage($request->file('testimonial_image'));
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
        $testimonial->load([
            'testimonialImage.media',
        ],);

        return view('pageadmin.testimonials.edit', compact('client', 'testimonial'));
    }

    public function update(StoreTestimonialRequest $request, Client $client, Testimonial $testimonial)
    {
        try {
            $validated = $request->validated();

            $testimonial->update($validated);

            if ($request->hasFile('testimonial_image')) {
                $testimonial->uploadImage($request->file('testimonial_image'));
            } 
            
            if ($request->has('remove_image') && $testimonial->testimonialImage) {
                $testimonial->testimonialImage->delete();
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