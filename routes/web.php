<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\StoreFrontController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\SocialNetworkController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsletterController;

// Rutas de autenticación
Route::get('/user/password', function () {
    return view('auth.passwords.update');
})->middleware('auth')->name('password.edit');

Route::get('/pageadmin', function () {
    return view('welcome');
})->name('welcome');

// Rutas exclusivas del administrador de la plataforma
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('clients', ClientController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');

    Route::get('clients/{client}/users/create', [UserController::class, 'create'])->name('clients.users.create');
    Route::post('clients/{client}/users', [UserController::class, 'store'])->name('clients.users.store');
});

// Rutas de administración de una tienda: admin o usuario dueño de la tienda.
// scopeBindings() garantiza que {category}, {product}, etc. pertenezcan a {client}.
Route::middleware(['auth', 'client.owner'])->prefix('clients/{client}')->scopeBindings()->group(function () {

    Route::get('/', [ClientController::class, 'show'])->name('clients.show');

    Route::get('/site-settings/create', [SiteSettingsController::class, 'create'])->name('site-settings.create');
    Route::post('/site-settings', [SiteSettingsController::class, 'store'])->name('site-settings.store');
    Route::get('/site-settings/edit', [SiteSettingsController::class, 'edit'])->name('site-settings.edit');
    Route::put('/site-settings', [SiteSettingsController::class, 'update'])->name('site-settings.update');

    Route::prefix('social-networks')->group(function () {
        Route::get('/create', [SocialNetworkController::class, 'create'])->name('social-networks.create');
        Route::post('/', [SocialNetworkController::class, 'store'])->name('social-networks.store');
        Route::get('/{socialNetwork}/edit', [SocialNetworkController::class, 'edit'])->name('social-networks.edit');
        Route::put('/{socialNetwork}', [SocialNetworkController::class, 'update'])->name('social-networks.update');
        Route::delete('/{socialNetwork}', [SocialNetworkController::class, 'destroy'])->name('social-networks.destroy');
    });

    Route::prefix('testimonials')->group(function () {
        Route::get('/create', [TestimonialController::class, 'create'])->name('testimonials.create');
        Route::post('/', [TestimonialController::class, 'store'])->name('testimonials.store');
        Route::get('/{testimonial}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
        Route::put('/{testimonial}', [TestimonialController::class, 'update'])->name('testimonials.update');
        Route::delete('/{testimonial}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
    });

    Route::prefix('pages')->group(function () {
        Route::get('/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('/', [PageController::class, 'store'])->name('pages.store');
        Route::get('/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::prefix('offers')->group(function () {
        Route::get('/create', [OfferController::class, 'create'])->name('offers.create');
        Route::post('/', [OfferController::class, 'store'])->name('offers.store');
        Route::get('/{offer}/edit', [OfferController::class, 'edit'])->name('offers.edit');
        Route::put('/{offer}', [OfferController::class, 'update'])->name('offers.update');
        Route::delete('/{offer}', [OfferController::class, 'destroy'])->name('offers.destroy');
    });
});

// Storefront público de cada tienda
if (app()->environment('production')) {

    Route::domain('{client}.quickweb.com.co')
        ->middleware(['web', 'identify.client'])
        ->group(function () {
            Route::get('/', [StoreFrontController::class, 'show'])->name('storefront.home');
            Route::get('/producto/{productSlug}', [StoreFrontController::class, 'showProduct'])->name('storefront.product');
            Route::get('/categoria/{categorySlug}', [StoreFrontController::class, 'showCategory'])->name('storefront.category');

            // Ruta para servir el CSS dinámico
            Route::get('/css/style.css', function (Illuminate\Http\Request $request) {
                try {
                    // Intentar obtener el cliente de tres formas diferentes
                    $client = $request->attributes->get('currentClient')
                        ?? app('currentClient', [])
                        ?? abort(404, 'Cliente no identificado');

                    if (!view()->exists('storefront.themes.default.style')) {
                        Log::error("Vista CSS no encontrada para el cliente: " . $client->domain);
                        abort(500, "Plantilla CSS no disponible");
                    }

                    return response()
                        ->view('storefront.themes.default.style', compact('client'))
                        ->header('Content-Type', 'text/css')
                        ->header('Cache-Control', 'public, max-age=86400');

                } catch (\Exception $e) {
                    Log::error("Error generando CSS: " . $e->getMessage());
                    abort(500, "Error generando hoja de estilos");
                }
            })->middleware('identify.client');

            Route::post('newsletter', [NewsletterController::class, 'subscribe'])
                ->middleware('throttle:newsletter')
                ->name('newsletter.subscribe');

        });

    Route::get('/', fn () => view('welcome'));
} else {
    Route::group(['middleware' => 'web'], function () {
        Route::group(['prefix' => '{domain}'], function () {
            Route::get('/', [StoreFrontController::class, 'show'])->name('storefront.home');
            Route::get('/producto/{productSlug}', [StoreFrontController::class, 'showProduct'])->name('storefront.product');
            Route::get('/categoria/{categorySlug}', [StoreFrontController::class, 'showCategory'])->name('storefront.category');

            Route::get('/css/style.css', function ($domain) {
                $client = \App\Models\Client::where('domain', $domain)->firstOrFail();
                return response()
                    ->view('storefront.themes.default.style', compact('client'))
                    ->header('Content-Type', 'text/css');
            });

            Route::post('newsletter', [NewsletterController::class, 'subscribe'])
                ->middleware('throttle:newsletter')
                ->name('newsletter.subscribe');
        });

        Route::get('/', fn () => view('welcome'));
    });
}

Route::post('api/newsletter/{domain}', [NewsletterController::class, 'subscribeViaDomain'])
    ->middleware('throttle:newsletter')
    ->name('newsletter.subscribe.fallback');
