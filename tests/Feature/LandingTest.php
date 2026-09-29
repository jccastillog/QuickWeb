<?php

namespace Tests\Feature;

use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_shows_active_plans_from_the_panel(): void
    {
        Plan::where('slug', 'pro')->update(['active' => false]);
        Plan::where('slug', 'negocio')->update(['price' => 72000]);

        $this->get('http://quickweb.com.co/')
            ->assertOk()
            ->assertSee('$39.000')
            ->assertSee('$72.000')
            ->assertSee('Hasta 20 productos')
            ->assertSee('Más popular')
            ->assertSee('Quiero el plan Negocio')
            ->assertDontSee('Quiero el plan Pro');
    }
}
