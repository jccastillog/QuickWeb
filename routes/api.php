<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\StoreFrontController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('test', function() {
    try {
        return response()->json([
            'status' => 'API funcionando',
            'data' => [
                'clients_count' => App\Models\Client::count(),
                'first_client' => App\Models\Client::with('siteSettings')->first(),
                'categories_count' => App\Models\Category::count(),
                'products_count' => App\Models\Product::count(),
                'first_product' => App\Models\Product::with(['category', 'images'])->first()
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTrace()
        ], 500);
    }
});

// Rutas API para tiendas

    Route::get('store/{domain}', [StoreFrontController::class, 'getStoreData']);
    Route::get('store/{domain}/products/{productSlug}', [StoreFrontController::class, 'getProduct']);


/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */