<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_redirect_to_login_page_without_sign_in()
    {
        $response = $this->get('/dmiesys/dashboard');

        $response->assertLocation('/login');
    }

    public function test_login_page_redirect_to_dashboard_after_sign_in()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->get('/login');

        $response->assertLocation('/dmiesys/dashboard');
    }

    public function test_dashboard_load_after_sign_in()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->get('/dmiesys/dashboard');

        $response->assertOk();

        $response->assertSee('Changelog');
        $response->assertDontSee('This account is deactivated!');
    }

    public function test_deactivate_user_will_see_the_deactivate_message()
    {
        $user = $this->createUser();
        $user->active_status = 0;
        $user->save();

        $response = $this->actingAs($user)
            ->get('/dmiesys/dashboard');

        $response->assertSee('This account is deactivated!');
    }
}
