<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Category;
use App\Models\Product;

class StoreFrontController extends Controller
{
    public function show($domain = null)
    {
        // Obtener el cliente del middleware
        $client = request()->attributes->get('currentClient');

        // Si no hay cliente, abortar
        if (!$client) {
            abort(404, 'Tienda no encontrada');
        }

        // Cargar relaciones necesarias
        $client->load(['siteSettings', 'socialNetworks']);

        $categories = Category::with(['image'])
            ->where('client_id', $client->id)
            ->get();

        $featuredProducts = Product::with(['image'])
            ->whereHas('category', function($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->where('active', true)
            ->where('featured', true)
            ->limit(6)
            ->get();

        return view('storefront.themes.default.home', compact('client', 'categories', 'featuredProducts'));
    }

    public function showCategory($domain, $categorySlug)
    {
        $client = Client::where('domain', $domain)->firstOrFail();

        $category = Category::with(['products' => function($query) {
                        $query->with(['image'])->where('active', true);
                    }])
                    ->where('client_id', $client->id)
                    ->where('slug', $categorySlug)
                    ->firstOrFail();

        return view('storefront.themes.default.category', compact('client', 'category'));
    }

    public function showProduct($domain, $productSlug)
    {
        $client = Client::where('domain', $domain)->firstOrFail();

        $product = Product::with(['category', 'image'])
            ->whereHas('category', function($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->where('slug', $productSlug)
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('storefront.themes.default.product', compact('client', 'product', 'relatedProducts'));
    }

    public function getStoreData($domain)
    {
        $client = Client::with(['siteSettings', 'socialNetworks' , 'pages', 'testimonials', 'offers'])
            ->where('domain', $domain)
            ->firstOrFail();

        $categories = Category::with([
            'products' => function ($query) {
                $query->where('active', true)->with(['image']);
            }
        ])->where('client_id', $client->id)
            ->get();

        return response()->json([
            'success' => true,
            'client' => $client,
            'categories' => $categories,
        ]);
    }

    public function getProduct($domain, $productSlug)
    {
        $client = Client::where('domain', $domain)->firstOrFail();

        $product = Product::with(['category', 'image'])
            ->whereHas('category', function ($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->where('slug', $productSlug)
            ->firstOrFail();

        return response()->json([
            'product' => $product,
            'relatedProducts' => $this->getRelatedProducts($product)
        ]);
    }

    protected function getRelatedProducts($product)
    {
        return Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }
}
