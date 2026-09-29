<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Product;
use App\Models\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    private Client $client;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->makeStore('demo');
        $this->category = Category::create(['client_id' => $this->client->id, 'name' => 'Ropa']);
    }

    private function makeStore(string $domain): Client
    {
        $client = Client::factory()->create(['domain' => $domain, 'store_name' => 'Tienda ' . $domain, 'active' => true]);
        SiteSettings::factory()->create(['client_id' => $client->id, 'whatsapp' => '300 123 4567']);

        return $client;
    }

    private function makeProduct(array $attributes = []): Product
    {
        return Product::create(array_merge([
            'client_id' => $this->client->id,
            'category_id' => $this->category->id,
            'name' => 'Camiseta Azul',
            'description' => 'Camiseta de algodón',
            'price' => 50000,
            'stock' => 10,
            'active' => true,
        ], $attributes));
    }

    // En entornos no productivos el storefront se sirve como /{domain}/...
    private function storeUrl(string $path = '', string $domain = 'demo'): string
    {
        return "http://{$domain}.quickweb.com.co/{$domain}" . ($path ? "/{$path}" : '');
    }

    public function test_product_page_shows_product_with_cart_button_and_share_tags(): void
    {
        $product = $this->makeProduct();

        $this->get($this->storeUrl('producto/camiseta-azul'))
            ->assertOk()
            ->assertSee('Camiseta Azul')
            ->assertSee('$50.000')
            ->assertSee('data-add-to-cart', false)
            ->assertSee('data-price="50000"', false)
            ->assertSee('<meta property="og:title"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('https://wa.me/573001234567', false);

        $this->assertSame(50000.0, $product->final_price);
    }

    public function test_product_from_another_store_is_not_found(): void
    {
        $other = $this->makeStore('otra');
        $otherCategory = Category::create(['client_id' => $other->id, 'name' => 'Varios']);
        Product::create([
            'client_id' => $other->id,
            'category_id' => $otherCategory->id,
            'name' => 'Producto Ajeno',
            'description' => 'x',
            'price' => 1000,
        ]);

        $this->get($this->storeUrl('producto/producto-ajeno'))->assertNotFound();
        $this->get($this->storeUrl('producto/producto-ajeno', 'otra'))->assertOk();
    }

    public function test_inactive_product_is_not_found(): void
    {
        $this->makeProduct(['active' => false]);

        $this->get($this->storeUrl('producto/camiseta-azul'))->assertNotFound();
    }

    public function test_category_page_lists_only_its_active_products(): void
    {
        $this->makeProduct();
        $this->makeProduct(['name' => 'Pantalón Oculto', 'active' => false]);
        $otherCategory = Category::create(['client_id' => $this->client->id, 'name' => 'Zapatos']);
        $this->makeProduct(['name' => 'Tenis', 'category_id' => $otherCategory->id]);

        $this->get($this->storeUrl('categoria/ropa'))
            ->assertOk()
            ->assertSee('Camiseta Azul')
            ->assertDontSee('Pantalón Oculto')
            ->assertDontSee('Tenis');
    }

    public function test_active_percentage_offer_lowers_the_cart_price(): void
    {
        $product = $this->makeProduct();
        $this->makeOffer($product, ['type' => 'percentage', 'discount' => 20]);

        $this->get($this->storeUrl('producto/camiseta-azul'))
            ->assertOk()
            ->assertSee('data-price="40000"', false)
            ->assertSee('$40.000')
            ->assertSee('$50.000');
    }

    public function test_fixed_amount_offer_is_applied(): void
    {
        $product = $this->makeProduct();
        $this->makeOffer($product, ['type' => 'fixed_amount', 'discount_amount' => 5000]);

        $this->assertSame(45000.0, $product->fresh()->final_price);
    }

    public function test_expired_offer_is_ignored(): void
    {
        $product = $this->makeProduct();
        $this->makeOffer($product, [
            'discount' => 50,
            'start_date' => now()->subMonth(),
            'end_date' => now()->subDay(),
        ]);

        $this->assertSame(50000.0, $product->fresh()->final_price);
    }

    public function test_home_links_to_product_pages_and_survives_offer_without_product(): void
    {
        $this->makeProduct(['featured' => true]);
        Offer::create([
            'client_id' => $this->client->id,
            'title' => 'Descuento general',
            'discount' => 10,
            'start_date' => now()->subDay(),
            'end_date' => now()->addWeek(),
        ]);

        $this->get($this->storeUrl())
            ->assertOk()
            ->assertSee($this->storeUrl('producto/camiseta-azul'), false)
            ->assertSee('Descuento general');
    }

    public function test_whatsapp_number_gets_country_code(): void
    {
        $settings = new SiteSettings(['whatsapp' => '+57 (300) 123-4567']);
        $this->assertSame('573001234567', $settings->whatsapp_number);

        $settings = new SiteSettings(['whatsapp' => '300 123 4567']);
        $this->assertSame('573001234567', $settings->whatsapp_number);
    }

    private function makeOffer(Product $product, array $attributes): Offer
    {
        return Offer::create(array_merge([
            'client_id' => $this->client->id,
            'product_id' => $product->id,
            'title' => 'Promo',
            'start_date' => now()->subDay(),
            'end_date' => now()->addWeek(),
            'active' => true,
        ], $attributes));
    }
}
