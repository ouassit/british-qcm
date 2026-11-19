<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    public function test_public_password_reset_pages_are_unavailable()
    {
        foreach (['/password/reset', '/password/reset/test-token', '/forgot-password', '/reset-password/test-token'] as $url) {
            $this->get($url)->assertNotFound();
        }
    }

    public function test_public_password_reset_requests_are_unavailable()
    {
        Notification::fake();

        foreach (['/password/email', '/password/reset', '/forgot-password', '/reset-password'] as $url) {
            $this->post($url, [
                'email' => 'test@example.com',
                'token' => 'test-token',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])->assertNotFound();
        }

        Notification::assertNothingSent();
    }

    public function test_password_reset_routes_are_not_registered()
    {
        foreach (['password.request', 'password.email', 'password.reset', 'password.update'] as $name) {
            $this->assertFalse(Route::has($name));
        }
    }

    public function test_login_has_no_password_reset_link()
    {
        $this->get('/login')->assertOk()->assertDontSee('Forgot password?');
    }
}
