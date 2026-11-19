<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_screen_is_unavailable()
    {
        $this->get('/register')->assertNotFound();
    }

    public function test_public_registration_is_unavailable()
    {
        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertNotFound();

        $this->assertGuest();
    }

    public function test_home_redirects_to_login()
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_login_remains_available()
    {
        $this->get('/login')->assertOk();
    }
}
