<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Category;
use App\Models\Product;

class StoreFrontController extends Controller
{
    public function show($domain)
    {
        // El cliente ya está disponible gracias al middleware
        $client = request()->attributes->get('currentClient');

        $client = Client::with(['siteSettings', 'socialNetworks'])
            ->where('domain', $domain)
            ->firstOrFail();

        $categories = Category::with(['image'])
            ->where('client_id', $client->id)
            ->where('active', true)
            ->get();

        $featuredProducts = Product::with(['images'])
            ->whereHas('category', function($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->where('active', true)
            ->where('featured', true)
            ->limit(6)
            ->get();

        return view('storefront.themes.default.home', compact('client', 'categories', 'featuredProducts'));
        
        // Resto de la lógica igual...
    }

    public function showCategory($domain, $categorySlug)
    {
        $client = Client::where('domain', $domain)->firstOrFail();
        
        $category = Category::with(['products' => function($query) {
                        $query->with(['images'])->where('active', true);
                    }])
                    ->where('client_id', $client->id)
                    ->where('slug', $categorySlug)
                    ->firstOrFail();

        return view('storefront.themes.default.category', compact('client', 'category'));
    }

    public function showProduct($domain, $productSlug)
    {
        $client = Client::where('domain', $domain)->firstOrFail();

        $product = Product::with(['category', 'images'])
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
        $client = Client::with(['siteSettings', 'socialNetworks' /*, 'plans', 'pages', 'testimonials' */])
            ->where('domain', $domain)
            ->firstOrFail();

        $categories = Category::with([
            'products' => function ($query) {
                $query->where('active', true)->with(['images']);
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

        $product = Product::with(['category', 'images'])
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