<?php

// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Traits\HandlesMediaUploads;

class CategoryController extends Controller
{
    use HandlesMediaUploads;
    public function index(Client $client)
    {
        $categories = $client->categories()->paginate(10);
        return view('categories.index', compact('categories', 'client'));
    }

    public function create(Client $client)
    {
        return view('categories.create', compact('client'));
    }

    public function store(StoreCategoryRequest $request, Client $client)
    {
        $category = $client->categories()->create($request->validated());
        
        // Manejar imagen si existe
        if ($request->hasFile('image')) {
            $this->uploadImage($category, $request->file('image'));
        }
        
        return redirect()->route('clients.categories.show', [$client, $category])
            ->with('success', 'Categoría creada');
    }

    public function show(Client $client, Category $category)
    {
        $category->load('products');
        return view('categories.show', compact('client', 'category'));
    }

    public function edit(Client $client, Category $category)
    {
        return view('categories.edit', compact('client', 'category'));
    }

    public function update(UpdateCategoryRequest $request, Client $client, Category $category)
    {
        $category->update($request->validated());
        
        // Actualizar imagen si se proporciona
        if ($request->hasFile('image')) {
            $this->uploadImage($category, $request->file('image'), true);
        }
        
        return redirect()->route('clients.categories.show', [$client, $category])
            ->with('success', 'Categoría actualizada');
    }

    public function destroy(Client $client, Category $category)
    {
        $category->delete();
        return redirect()->route('clients.categories.index', $client)
            ->with('success', 'Categoría eliminada');
    }
    
    protected function uploadImage($model, $file, $replace = false)
    {
        // Implementación de subida de imagen
        // (Ver sección de MediaController para implementación completa)
    }
}