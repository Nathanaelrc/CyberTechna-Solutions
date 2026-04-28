<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_normal_user(): void
    {
        $this->withoutMiddleware(PreventRequestForgery::class);

        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Alumno Uno',
            'email' => 'alumno1@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'alumno1@example.com',
            'is_admin' => false,
        ]);
    }

    public function test_normal_user_cannot_access_admin_user_management(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertForbidden();
    }
}