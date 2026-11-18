<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_home_page_redirects_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_login_and_password_reset_routes_are_available(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Lupa password?')
            ->assertSee('images/nok-wordmark.png');

        $this->get(route('password.request'))
            ->assertOk();
    }
}
