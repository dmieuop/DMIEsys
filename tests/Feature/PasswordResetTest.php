<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        if (!Features::enabled(Features::resetPasswords())) {
            $this->markTestSkipped('Password updates are not enabled.');

            return;
        }

        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_password_reset_screen_only_appear_for_unauthenticated_users()
    {
        if (!Features::enabled(Features::resetPasswords())) {
            $this->markTestSkipped('Password updates are not enabled.');

            return;
        }

        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->get('/forgot-password');

        $response->assertStatus(302);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        if (!Features::enabled(Features::resetPasswords())) {
            $this->markTestSkipped('Password updates are not enabled.');

            return;
        }

        Notification::fake();

        $user = $this->createUser();

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        if (!Features::enabled(Features::resetPasswords())) {
            $this->markTestSkipped('Password updates are not enabled.');

            return;
        }

        Notification::fake();

        $user = $this->createUser();

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class, function (object $notification) {
            $response = $this->get('/reset-password/' . $notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        if (!Features::enabled(Features::resetPasswords())) {
            $this->markTestSkipped('Password updates are not enabled.');

            return;
        }

        Notification::fake();

        $user = $this->createUser();

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class, function (object $notification) use ($user) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'NeWpa$$w0Rd777',
                'password_confirmation' => 'NeWpa$$w0Rd777',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
