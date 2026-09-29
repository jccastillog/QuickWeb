<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Plan;
use App\Models\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Las rutas de subdominios y dominios propios solo existen en producción,
 * así que estas pruebas recargan routes/web.php en ese entorno.
 */
class CustomDomainTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['env'] = 'production';
        Route::setRoutes(new RouteCollection());
        Route::namespace('Laravel\Fortify\Http\Controllers')
            ->group(base_path('vendor/laravel/fortify/routes/routes.php'));
        Route::middleware('web')->group(base_path('routes/web.php'));
        Route::getRoutes()->refreshNameLookups();

        $client = Client::factory()->create([
            'domain' => 'demo',
            'store_name' => 'Tienda Demo',
            'custom_domain' => 'mitienda.com',
            'plan_id' => Plan::where('slug', 'negocio')->value('id'),
            'active' => true,
            'expires_at' => now()->addMonth(),
        ]);
        SiteSettings::factory()->create(['client_id' => $client->id]);
    }

    public function test_store_is_served_on_its_custom_domain(): void
    {
        $this->get('http://mitienda.com/')->assertOk()->assertSee('Tienda Demo');
        $this->get('http://www.mitienda.com/')->assertOk()->assertSee('Tienda Demo');
    }

    public function test_store_is_still_served_on_its_subdomain(): void
    {
        $this->get('http://demo.quickweb.com.co/')->assertOk()->assertSee('Tienda Demo');
    }

    public function test_links_use_the_custom_domain(): void
    {
        $this->get('http://demo.quickweb.com.co/')
            ->assertSee('https://mitienda.com/css/style.css', false)
            ->assertSee('action="https://mitienda.com/newsletter"', false);
    }

    public function test_unknown_domain_is_not_found(): void
    {
        $this->get('http://otrodominio.com/')->assertNotFound();
    }

    public function test_main_domain_is_not_treated_as_a_store(): void
    {
        $this->get('http://quickweb.com.co/')->assertOk()->assertDontSee('Tienda Demo');
    }
}
