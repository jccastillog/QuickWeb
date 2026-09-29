<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    private function storeUrl(Client $client): string
    {
        // En entornos no productivos el storefront se sirve como /{domain}
        return "http://{$client->domain}.quickweb.com.co/{$client->domain}/newsletter";
    }

    private function activeStore(): Client
    {
        $client = Client::factory()->create(['domain' => 'demo', 'active' => true]);
        SiteSettings::factory()->create(['client_id' => $client->id]);

        return $client;
    }

    public function test_newsletter_is_rate_limited_per_ip(): void
    {
        Mail::fake();
        $client = $this->activeStore();

        for ($i = 1; $i <= 3; $i++) {
            $this->postJson($this->storeUrl($client), ['email' => "persona{$i}@example.com"])->assertOk();
        }

        $this->postJson($this->storeUrl($client), ['email' => 'persona4@example.com'])->assertStatus(429);
    }

    public function test_inactive_store_is_not_served(): void
    {
        Mail::fake();
        $client = $this->activeStore();
        $client->update(['active' => false]);

        $this->postJson($this->storeUrl($client), ['email' => 'persona@example.com'])->assertNotFound();

        Mail::assertNothingSent();
    }
}
