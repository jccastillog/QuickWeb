<?php

use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\API\StoreFrontController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\SocialNetworkController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OfferController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta temporal de prueba - Eliminar después de las pruebas

Route::get('/quick-test', function () {
    $client = App\Models\Client::first();

    if (!$client) {
        $client = App\Models\Client::create([
            'domain' => 'testquick.com',
            'store_name' => 'Test Quick',
            'active' => true
        ]);
    }

    return response()->json([
        'status' => 'OK',
        'client' => $client->only('id', 'domain', 'store_name'),
        'message' => 'Conexión exitosa con la base de datos'
    ]);
});

Route::get('/test-multi-domain/{clientId}', function ($clientId) {
    // Simular diferentes dominios
    $domains = [
        1 => 'hilpert.com',
        2 => 'cliente2.test'
    ];

    if (!array_key_exists($clientId, $domains)) {
        abort(404, 'Cliente no existe');
    }

    // Obtener el cliente como lo haría tu middleware
    $client = App\Models\Client::where('domain', $domains[$clientId])->first();

    if (!$client) {
        // Crear cliente demo si no existe
        $client = App\Models\Client::create([
            'domain' => $domains[$clientId],
            'store_name' => "Tienda Demo $clientId",
            'active' => true
        ]);

        // Crear categoría demo
        $client->categories()->create([
            'name' => "Categoría Demo $clientId",
            'description' => "Esta es la tienda del cliente $clientId"
        ]);
    }

    // Renderizar una vista simple
    return view('test-domain', [
        'client' => $client,
        'categories' => $client->categories
    ]);
});


Route::get('/pageadmin', function () {
    return view('welcome');
})->name('welcome');

// Rutas para el administrador de tiendas (Clients)
Route::resource('clients', ClientController::class)->only([
    'index',
    'show',
    'store',
    'update',
    'destroy'
]);

Route::get('clients/{client}/edit', [ClientController::class, 'edit'])
    ->name('clients.edit');

Route::get('clients/{client}/site-settings/create', [SiteSettingsController::class, 'create'])
    ->name('site-settings.create');

Route::post('clients/{client}/site-settings', [SiteSettingsController::class, 'store'])
    ->name('site-settings.store');

Route::get('clients/{client}/site-settings/edit', [SiteSettingsController::class, 'edit'])
    ->name('site-settings.edit');

Route::put('clients/{client}/site-settings', [SiteSettingsController::class, 'update'])
    ->name('site-settings.update');

//Rutas para Social Networks
Route::prefix('clients/{client}/social-networks')->group(function () {
    Route::get('/create', [SocialNetworkController::class, 'create'])->name('social-networks.create');
    Route::post('/', [SocialNetworkController::class, 'store'])->name('social-networks.store');
    Route::get('/{socialNetwork}/edit', [SocialNetworkController::class, 'edit'])->name('social-networks.edit');
    Route::put('/{socialNetwork}', [SocialNetworkController::class, 'update'])->name('social-networks.update');
    Route::delete('/{socialNetwork}', [SocialNetworkController::class, 'destroy'])->name('social-networks.destroy');
});

Route::prefix('clients/{client}/testimonials')->group(function () {
    Route::get('/create', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('/', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::put('/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
});

Route::prefix('clients/{client}/pages')->group(function () {
    Route::get('/create', [PageController::class, 'create'])->name('pages.create');
    Route::post('/', [PageController::class, 'store'])->name('pages.store');
    Route::get('/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
});

Route::prefix('clients/{client}/categories')->group(function () {
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});


Route::prefix('clients/{client}/products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::prefix('clients/{client}/offers')->group(function () {
    Route::get('/create', [OfferController::class, 'create'])->name('offers.create');
    Route::post('/', [OfferController::class, 'store'])->name('offers.store');
    Route::get('/{offer}/edit', [OfferController::class, 'edit'])->name('offers.edit');
    Route::put('/{offer}', [OfferController::class, 'update'])->name('offers.update');
    Route::delete('/{offer}', [OfferController::class, 'destroy'])->name('offers.destroy');
});




// routes/web.php

Route::get('/test/store/{domain?}', function ($domain = 'tienda1.test') {
    return view('test.store', ['domain' => $domain]);
});


if (app()->environment('production')) {
    Route::domain('{client}.quickweb.com.co')->group(function () {
        // rutas para subdominios
        Route::domain('{client}.quickweb.com.co')->group(function () {
            Route::get('/', [StoreFrontController::class, 'show'])->name('storefront.home');
            Route::get('/category/{categorySlug}', [StoreFrontController::class, 'showCategory'])->name('storefront.category');
            Route::get('/product/{productSlug}', [StoreFrontController::class, 'showProduct'])->name('storefront.product');
        });
    });
} else {
    Route::group(['middleware' => 'web'], function() {
        Route::group(['prefix' => '{domain}'], function() {
            Route::get('/', [StoreFrontController::class, 'show'])->name('storefront.home');
            Route::get('/category/{categorySlug}', [StoreFrontController::class, 'showCategory'])->name('storefront.category');
            Route::get('/product/{productSlug}', [StoreFrontController::class, 'showProduct'])->name('storefront.product');
        });

        // Rutas directas (para producción)
        Route::get('/', function() {
            return view('welcome');
        });
    });
}









