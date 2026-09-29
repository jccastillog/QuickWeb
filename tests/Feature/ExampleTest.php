<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_main_domain_home_returns_a_successful_response(): void
    {
        $this->get('http://quickweb.com.co/')->assertOk();
    }
}
