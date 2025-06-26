<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Traits\HandlesMediaUploads;
use Exception;

class CategoryController extends Controller
{
    use HandlesMediaUploads;

    public function create(Client $client)
    {
        return view('pageadmin.categories.create', compact('client'));
    }

    public function store(StoreCategoryRequest $request, Client $client)
    {
        try {
            $validated = $request->validated();
            $validated['client_id'] = $client->id;

            $category = Category::create($validated);

            if ($request->hasFile('image')) {
                $this->uploadMedia(
                    $category,
                    $request->file('image'),
                    'category_image'
                );
            }

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Categoría creada exitosamente');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear la categoría: '.$e->getMessage());
        }
    }

    public function edit(Client $client, Category $category)
    {
        return view('pageadmin.categories.edit', compact('client', 'category'));
    }

    public function update(UpdateCategoryRequest $request, Client $client, Category $category)
    {
        try {
            $category->update($request->validated());

            if ($request->hasFile('image')) {
                $this->uploadMedia(
                    $category,
                    $request->file('image'),
                    'category_image',
                    true
                );
            } elseif ($request->has('remove_image') && $category->image) {
                $this->deleteMedia($category->image->media);
                $category->image()->delete();
            }

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Categoría actualizada exitosamente');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la categoría: '.$e->getMessage());
        }
    }

    public function destroy(Client $client, Category $category)
    {
        \Log::info('Attempting to delete category: '.$category->id);
        try {
            if ($category->image) {
                $this->deleteMedia($category->image->media);
                $category->image()->delete();
            }

            if ($category->products()->whereHas('offers')->exists()) {
                return back()->with('error', 'No puedes eliminar esta categoría porque sus productos tienen ofertas activas.');
            }

            $category->delete();
            \Log::info('Categoría eliminada de la BD');

            return redirect()
                ->route('clients.show', $client)
                ->with('success', 'Categoría eliminada exitosamente');

        } catch (Exception $e) {
            \Log::error('Fallo al eliminar categoría: ' . $e->getMessage());

            return back()
                ->with('error', 'Error al eliminar la categoría: '.$e->getMessage());
        }
    }
}
