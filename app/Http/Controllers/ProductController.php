<?php

// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Client;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Traits\HandlesMediaUploads;
use Exception;

class ProductController extends Controller
{
    use HandlesMediaUploads;
    public function index(Client $client)
    {
        $products = $client->products()->with(['category', 'image.media'])->paginate(12);

        return view('pageadmin.products.index', compact('client', 'products'));
    }


    public function create(Client $client)
    {
        $client->load([
                'categories',
                'categories.image.media'
            ]);
        return view('pageadmin.products.create', compact('client'));
    }

    public function store(StoreProductRequest $request, Client $client)
    {
        $validated = $request->validated();
        $validated['client_id'] = $client->id;

        $product = Product::create($validated);

        if ($request->hasFile('image')) {
                $this->uploadMedia(
                    $product,
                    $request->file('image'),
                    'product_gallery'
                );
        }

        return redirect()->route('clients.show', $client)->with('success', 'Producto creado');
    }

    public function show(Client $client, Product $product)
    {
        if ($product->client_id !== $client->id) {
            abort(404);
        }

        $product->load(['category', 'image.media', 'offers']);
        return view('pageadmin.products.show', compact('client', 'product'));
    }

    public function edit(Client $client, Product $product)
    {
        if ($product->client_id !== $client->id) {
            abort(404);
        }

        $categories = $product->categories;
        $product->load(['featuredImage.media']);

        return view('pageadmin.products.edit', compact('client', 'product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Client $client, Product $product)
    {
        if ($product->client_id !== $client->id) {
            abort(404);
        }

        $product->update($request->validated());

            if ($request->hasFile('image')) {
                $this->uploadMedia(
                    $product,
                    $request->file('image'),
                    'product_gallery',
                    true
                );
            } elseif ($request->has('remove_image') && $product->image) {
                $this->deleteMedia($product->image->media);
                $product->image()->delete();
            }

        return redirect()->route('clients.show', $client)
            ->with('success', 'Producto actualizado');
    }

    public function destroy(Client $client, Product $product)
    {
        $product->load(['featuredImage.media', 'image.media']);

        if ($product->client_id !== $client->id) {
            abort(404);
        }

        try {
            if ($product->image->isNotEmpty()) {
                foreach ($product->image as $image) {
                    $this->deleteMedia($image->media);
                    $image->delete();
                }
            }
            
            if ($product->featuredImage) {
                $this->deleteMedia($product->featuredImage->media);
                $product->featuredImage()->delete();
            }

            $product->delete();

            return redirect()->route('clients.show', $client)
                ->with('success', 'Producto eliminado correctamente');

        } catch (Exception $e) {
            return back()
                ->with('error', 'Error al eliminar el producto: '.$e->getMessage())
                ->withInput();
        }
    }
}
