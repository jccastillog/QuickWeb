<?php

namespace Tests\Feature;

use App\Mail\AdminBillingDigestMail;
use App\Mail\BillingReminderMail;
use App\Models\Category;
use App\Models\Client;
use App\Models\Plan;
use App\Models\Product;
use App\Models\SiteSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BillingTest extends TestCase
{
    use RefreshDatabase;

    private const PANEL = 'http://quickweb.com.co';

    private function admin(): User
    {
        $admin = User::factory()->create(['email' => 'admin@quickweb.test']);
        $admin->forceFill(['role' => 'admin'])->save();

        return $admin;
    }

    private function plan(string $slug): Plan
    {
        return Plan::where('slug', $slug)->firstOrFail();
    }

    private function store(array $attributes = []): Client
    {
        $client = Client::factory()->create(array_merge(['domain' => 'demo', 'active' => true], $attributes));
        SiteSettings::factory()->create(['client_id' => $client->id]);

        return $client;
    }

    private function paymentData(array $overrides = []): array
    {
        return array_merge([
            'plan_id' => $this->plan('basico')->id,
            'months' => 1,
            'amount' => 39000,
            'method' => 'nequi',
            'paid_at' => today()->toDateString(),
        ], $overrides);
    }

    public function test_default_plans_are_seeded(): void
    {
        $this->assertSame(['basico', 'negocio', 'pro'], Plan::ordered()->pluck('slug')->all());
        $this->assertNull($this->plan('pro')->product_limit);
    }

    public function test_payment_on_active_store_extends_from_current_expiry(): void
    {
        $client = $this->store(['expires_at' => today()->addDays(10)]);

        $this->actingAs($this->admin())
            ->post(self::PANEL . "/clients/{$client->id}/payments", $this->paymentData(['months' => 3]))
            ->assertRedirect()
            ->assertSessionHasNoErrors();

        $client->refresh();
        $this->assertTrue($client->expires_at->isSameDay(today()->addDays(10)->addMonthsNoOverflow(3)));
        $this->assertSame($this->plan('basico')->id, $client->plan_id);
        $this->assertSame(1, $client->payments()->count());
    }

    public function test_payment_on_expired_store_extends_from_today(): void
    {
        $client = $this->store(['expires_at' => today()->subDays(20)]);

        $this->actingAs($this->admin())
            ->post(self::PANEL . "/clients/{$client->id}/payments", $this->paymentData())
            ->assertSessionHasNoErrors();

        $this->assertTrue($client->fresh()->expires_at->isSameDay(today()->addMonthNoOverflow()));
    }

    public function test_store_owner_cannot_register_payments_or_manage_plans(): void
    {
        $owner = User::factory()->create();
        $client = $this->store(['expires_at' => today()->subDays(20)]);
        $client->forceFill(['user_id' => $owner->id])->save();

        $this->actingAs($owner)
            ->post(self::PANEL . "/clients/{$client->id}/payments", $this->paymentData())
            ->assertForbidden();
        $this->actingAs($owner)->get(self::PANEL . '/plans')->assertForbidden();

        $this->assertSame(0, $client->payments()->count());
    }

    public function test_admin_can_edit_a_plan(): void
    {
        $plan = $this->plan('negocio');

        $this->actingAs($this->admin())
            ->put(self::PANEL . "/plans/{$plan->id}", [
                'name' => 'Negocio',
                'slug' => 'negocio',
                'price' => 75000,
                'product_limit' => '',
                'allows_custom_domain' => '1',
                'active' => '1',
            ])
            ->assertRedirect(route('plans.index'));

        $plan->refresh();
        $this->assertSame('75000.00', $plan->price);
        $this->assertNull($plan->product_limit);
    }

    public function test_billing_status_follows_expiry_and_grace_period(): void
    {
        $grace = config('quickweb.billing.grace_days');

        $this->assertSame('sin_vencimiento', (new Client(['expires_at' => null]))->billingStatus());
        $this->assertSame('al_dia', (new Client(['expires_at' => today()->addDays(30)]))->billingStatus());
        $this->assertSame('por_vencer', (new Client(['expires_at' => today()->addDays(3)]))->billingStatus());
        $this->assertSame('por_vencer', (new Client(['expires_at' => today()]))->billingStatus());
        $this->assertSame('en_gracia', (new Client(['expires_at' => today()->subDays($grace)]))->billingStatus());
        $this->assertSame('suspendida', (new Client(['expires_at' => today()->subDays($grace + 1)]))->billingStatus());
    }

    public function test_suspended_store_shows_unavailable_page(): void
    {
        $grace = config('quickweb.billing.grace_days');

        $this->store(['expires_at' => today()->subDays($grace)]);
        $this->get('http://demo.quickweb.com.co/demo')->assertOk();

        Client::where('domain', 'demo')->update(['expires_at' => today()->subDays($grace + 1)]);
        $this->get('http://demo.quickweb.com.co/demo')
            ->assertStatus(503)
            ->assertSee('no está disponible temporalmente');
    }

    public function test_plan_product_limit_blocks_new_products(): void
    {
        $owner = User::factory()->create();
        $plan = $this->plan('basico');
        $plan->update(['product_limit' => 1]);

        $client = $this->store(['plan_id' => $plan->id, 'expires_at' => today()->addMonth()]);
        $client->forceFill(['user_id' => $owner->id])->save();
        $category = Category::create(['client_id' => $client->id, 'name' => 'Ropa']);
        Product::create([
            'client_id' => $client->id,
            'category_id' => $category->id,
            'name' => 'Primero',
            'description' => 'x',
            'price' => 1000,
        ]);

        $this->actingAs($owner)
            ->get(self::PANEL . "/clients/{$client->id}/products/create")
            ->assertRedirect(route('clients.show', $client))
            ->assertSessionHas('error');

        $this->actingAs($owner)
            ->post(self::PANEL . "/clients/{$client->id}/products", [
                'category_id' => $category->id,
                'name' => 'Segundo',
                'description' => 'x',
                'price' => 1000,
                'stock' => 1,
                'featured' => 0,
                'active' => 1,
            ])
            ->assertSessionHas('error');

        $this->assertSame(1, $client->products()->count());
    }

    public function test_custom_domain_requires_a_plan_that_includes_it(): void
    {
        $client = $this->store();
        $admin = $this->admin();

        $this->actingAs($admin)
            ->put(self::PANEL . "/clients/{$client->id}", [
                'plan_id' => $this->plan('basico')->id,
                'custom_domain' => 'mitienda.com',
            ])
            ->assertSessionHasErrors('custom_domain');

        $this->actingAs($admin)
            ->put(self::PANEL . "/clients/{$client->id}", [
                'plan_id' => $this->plan('negocio')->id,
                'custom_domain' => 'https://www.MiTienda.com/',
            ])
            ->assertSessionHasNoErrors();

        $this->assertSame('mitienda.com', $client->fresh()->custom_domain);
    }

    public function test_reminders_are_sent_once_per_day_and_admin_gets_digest(): void
    {
        Mail::fake();
        $this->admin();

        $dueSoon = $this->store(['domain' => 'pronto', 'expires_at' => today()->addDays(7)]);
        $this->store(['domain' => 'tranquila', 'expires_at' => today()->addDays(40)]);

        $this->artisan('quickweb:billing-reminders')->assertSuccessful();
        $this->artisan('quickweb:billing-reminders')->assertSuccessful();

        Mail::assertSent(BillingReminderMail::class, 1);
        Mail::assertSent(BillingReminderMail::class, fn ($mail) => $mail->client->is($dueSoon) && $mail->daysLeft === 7);
        Mail::assertSent(AdminBillingDigestMail::class, fn ($mail) => $mail->clients->count() === 1
            && $mail->hasTo('admin@quickweb.test'));
    }

    public function test_admin_panel_pages_render(): void
    {
        $admin = $this->admin();
        $client = $this->store(['plan_id' => $this->plan('negocio')->id, 'expires_at' => today()->subDays(20)]);
        $this->actingAs($admin)->post(self::PANEL . "/clients/{$client->id}/payments", $this->paymentData());

        $this->actingAs($admin)->get(self::PANEL . '/plans')->assertOk()->assertSee('Negocio')->assertSee('$69.000');
        $this->actingAs($admin)->get(self::PANEL . '/plans/create')->assertOk();
        $this->actingAs($admin)->get(self::PANEL . '/clients')->assertOk()->assertSee('Al día');
        $this->actingAs($admin)->get(self::PANEL . "/clients/{$client->id}/edit")->assertOk()->assertSee('Dominio propio');
        $this->actingAs($admin)->get(self::PANEL . "/clients/{$client->id}")
            ->assertOk()
            ->assertSee('Plan y pagos')
            ->assertSee('Registrar pago')
            ->assertSee('Historial de pagos');
    }

    public function test_owner_sees_renewal_warning_but_no_payment_form(): void
    {
        config(['quickweb.support_whatsapp' => '573001112233']);
        $owner = User::factory()->create();
        $client = $this->store(['expires_at' => today()->addDays(2)]);
        $client->forceFill(['user_id' => $owner->id])->save();

        $this->actingAs($owner)->get(self::PANEL . "/clients/{$client->id}")
            ->assertOk()
            ->assertSee('Tu plan vence el')
            ->assertSee('https://wa.me/573001112233', false)
            ->assertDontSee('Valor recibido');
    }

    public function test_reminder_email_renders(): void
    {
        $client = $this->store(['plan_id' => $this->plan('pro')->id, 'expires_at' => today()->subDays(3)]);

        $html = (new BillingReminderMail($client, -3))->render();

        $this->assertStringContainsString('venció', $html);
        $this->assertStringContainsString('$119.000', $html);
    }
}
