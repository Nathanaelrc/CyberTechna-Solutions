<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_change_own_password_from_panel(): void
    {
        $this->withoutMiddleware(PreventRequestForgery::class);

        $admin = User::factory()->create([
            'is_admin' => true,
            'password' => 'current-secret-123',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.password.update'), [
            'current_password' => 'current-secret-123',
            'password' => 'updated-secret-123',
            'password_confirmation' => 'updated-secret-123',
        ]);

        $response->assertRedirect(route('admin.password.edit'));

        $this->assertCredentials([
            'email' => $admin->email,
            'password' => 'updated-secret-123',
        ]);
    }

    public function test_admin_password_change_requires_valid_current_password(): void
    {
        $this->withoutMiddleware(PreventRequestForgery::class);

        $admin = User::factory()->create([
            'is_admin' => true,
            'password' => 'current-secret-123',
        ]);

        $response = $this->from(route('admin.password.edit'))
            ->actingAs($admin)
            ->put(route('admin.password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'updated-secret-123',
                'password_confirmation' => 'updated-secret-123',
            ]);

        $response->assertRedirect(route('admin.password.edit'));
        $response->assertSessionHasErrors('current_password');
    }

    public function test_non_admin_cannot_access_admin_password_page(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get(route('admin.password.edit'));

        $response->assertForbidden();
    }
}
