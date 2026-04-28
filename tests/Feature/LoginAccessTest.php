<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_is_redirected_to_admin_dashboard_after_login(): void
    {
        $this->withoutMiddleware(PreventRequestForgery::class);

        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'secret123',
            'is_admin' => true,
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_normal_user_can_log_in_and_is_redirected_to_course_portal(): void
    {
        $this->withoutMiddleware(PreventRequestForgery::class);

        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'secret123',
            'is_admin' => false,
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('portal.courses.index'));
        $this->assertAuthenticatedAs($user);
    }
}