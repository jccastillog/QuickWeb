<?php

// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Traits\HandlesMediaUploads;

class ProductController extends Controller
{
    use HandlesMediaUploads;
    public function index(Category $category)
    {
        $products = $category->products()->paginate(12);
        return view('products.index', compact('category', 'products'));
    }

    public function create(Category $category)
    {
        return view('products.create', compact('category'));
    }

    public function store(StoreProductRequest $request, Category $category)
    {
        $product = $category->products()->create($request->validated());
        
        // Manejar imágenes
        if ($request->hasFile('images')) {
            $this->uploadImages($product, $request->file('images'));
        }
        
        return redirect()->route('categories.products.show', [$category, $product])
            ->with('success', 'Producto creado');
    }

    public function show(Category $category, Product $product)
    {
        $product->load('images.media');
        return view('products.show', compact('category', 'product'));
    }

    public function edit(Category $category, Product $product)
    {
        $product->load('images.media');
        return view('products.edit', compact('category', 'product'));
    }

    public function update(UpdateProductRequest $request, Category $category, Product $product)
    {
        $product->update($request->validated());
        
        // Manejar nuevas imágenes
        if ($request->hasFile('images')) {
            $this->uploadImages($product, $request->file('product_gallery'));
        }
        
        return redirect()->route('categories.products.show', [$category, $product])
            ->with('success', 'Producto actualizado');
    }

    public function destroy(Category $category, Product $product)
    {
        $product->delete();
        return redirect()->route('categories.products.index', $category)
            ->with('success', 'Producto eliminado');
    }
    
    protected function uploadImages($product, $files)
    {
        // Implementación de subida múltiple de imágenes
        // (Ver sección de MediaController para implementación completa)
    }
}