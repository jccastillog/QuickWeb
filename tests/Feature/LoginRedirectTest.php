<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    private const PANEL = 'http://quickweb.com.co';

    public function test_login_page_loads_for_guests(): void
    {
        $this->get(self::PANEL . '/login')->assertOk();
    }

    public function test_admin_with_open_session_goes_from_login_to_store_list(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $this->actingAs($admin)->get(self::PANEL . '/login')->assertRedirect('/home');
        $this->actingAs($admin)->get(self::PANEL . '/home')->assertRedirect(route('clients.index'));
    }

    public function test_store_owner_goes_to_own_store(): void
    {
        $owner = User::factory()->create();
        $client = Client::factory()->create(['active' => true]);
        $client->forceFill(['user_id' => $owner->id])->save();

        $this->actingAs($owner)->get(self::PANEL . '/home')->assertRedirect(route('clients.show', $client));
    }

    public function test_login_form_redirects_admin_to_store_list(): void
    {
        $admin = User::factory()->create(['email' => 'admin@quickweb.test']);
        $admin->forceFill(['role' => 'admin'])->save();

        $this->post(self::PANEL . '/login', ['email' => 'admin@quickweb.test', 'password' => 'password'])
            ->assertRedirect(route('clients.index'));
    }

    public function test_guest_visiting_home_is_sent_to_login(): void
    {
        $this->get(self::PANEL . '/home')->assertRedirect('/login');
    }
}
