<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientAccessTest extends TestCase
{
    use RefreshDatabase;

    // El panel vive en el dominio principal (ver IdentifyClient)
    private const PANEL = 'http://quickweb.com.co';

    private function admin(): User
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        return $admin;
    }

    private function storeOwner(): array
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['active' => true]);
        $client->forceFill(['user_id' => $user->id])->save();

        return [$user, $client];
    }

    public function test_guest_cannot_create_users_for_a_store(): void
    {
        $client = Client::factory()->create();

        $this->get(self::PANEL . "/clients/{$client->id}/users/create")->assertRedirect('/login');

        $this->post(self::PANEL . "/clients/{$client->id}/users", [
            'name' => 'Intruso',
            'email' => 'intruso@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ])->assertRedirect('/login');

        $this->assertDatabaseMissing('users', ['email' => 'intruso@example.com']);
        $this->assertNull($client->fresh()->user_id);
    }

    public function test_store_owner_cannot_use_admin_routes(): void
    {
        [$user, $client] = $this->storeOwner();

        $this->actingAs($user)->get(self::PANEL . '/clients')->assertForbidden();
        $this->actingAs($user)->get(self::PANEL . "/clients/{$client->id}/users/create")->assertForbidden();
        $this->actingAs($user)->delete(self::PANEL . "/clients/{$client->id}")->assertForbidden();
    }

    public function test_store_owner_cannot_access_another_store(): void
    {
        [$user] = $this->storeOwner();
        $otherClient = Client::factory()->create();

        $this->actingAs($user)->get(self::PANEL . "/clients/{$otherClient->id}/products")->assertForbidden();
        $this->actingAs($user)->get(self::PANEL . "/clients/{$otherClient->id}/categories/create")->assertForbidden();
    }

    public function test_store_owner_can_access_own_store(): void
    {
        [$user, $client] = $this->storeOwner();

        $this->actingAs($user)->get(self::PANEL . "/clients/{$client->id}/categories/create")->assertOk();
    }

    public function test_admin_can_access_any_store(): void
    {
        $client = Client::factory()->create();

        $this->actingAs($this->admin())->get(self::PANEL . "/clients/{$client->id}/categories/create")->assertOk();
    }

    public function test_nested_resources_must_belong_to_the_store_in_the_url(): void
    {
        [$user, $client] = $this->storeOwner();

        $otherClient = Client::factory()->create();
        $foreignCategory = Category::create(['client_id' => $otherClient->id, 'name' => 'Ajena']);

        $this->actingAs($user)
            ->delete(self::PANEL . "/clients/{$client->id}/categories/{$foreignCategory->id}")
            ->assertNotFound();

        $this->assertDatabaseHas('categories', ['id' => $foreignCategory->id]);
    }

    public function test_product_cannot_use_a_category_from_another_store(): void
    {
        [$user, $client] = $this->storeOwner();

        $otherClient = Client::factory()->create();
        $foreignCategory = Category::create(['client_id' => $otherClient->id, 'name' => 'Ajena']);

        $this->actingAs($user)
            ->post(self::PANEL . "/clients/{$client->id}/products", [
                'category_id' => $foreignCategory->id,
                'name' => 'Producto',
                'description' => 'Descripción',
                'price' => 1000,
                'stock' => 1,
                'featured' => 0,
                'active' => 1,
            ])
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseMissing('products', ['name' => 'Producto']);
    }

    public function test_different_stores_can_use_the_same_category_name(): void
    {
        [$user, $client] = $this->storeOwner();

        $otherClient = Client::factory()->create();
        Category::create(['client_id' => $otherClient->id, 'name' => 'Ropa']);

        $this->actingAs($user)
            ->post(self::PANEL . "/clients/{$client->id}/categories", ['name' => 'Ropa'])
            ->assertSessionHasNoErrors();

        $this->assertSame(2, Category::where('slug', 'ropa')->count());
    }

    public function test_same_product_slug_is_allowed_in_different_stores(): void
    {
        $clientA = Client::factory()->create();
        $clientB = Client::factory()->create();
        $categoryA = Category::create(['client_id' => $clientA->id, 'name' => 'A']);
        $categoryB = Category::create(['client_id' => $clientB->id, 'name' => 'B']);

        foreach ([[$clientA, $categoryA], [$clientB, $categoryB]] as [$client, $category]) {
            Product::create([
                'client_id' => $client->id,
                'category_id' => $category->id,
                'name' => 'Camiseta',
                'description' => 'Algodón',
                'price' => 10,
            ]);
        }

        $this->assertSame(2, Product::where('slug', 'camiseta')->count());
    }
}
