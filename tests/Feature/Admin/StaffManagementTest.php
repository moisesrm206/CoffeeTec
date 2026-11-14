<?php

namespace Tests\Feature\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StaffManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrators_can_create_a_staff_account(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post('/admin/personal', [
                'name' => 'Cocina Turno Matutino',
                'email' => 'cocina@coffeetec.test',
                'role' => UserRole::Cocina->value,
                'password' => 'secret-password',
                'password_confirmation' => 'secret-password',
            ])
            ->assertRedirect(route('admin.staff.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'cocina@coffeetec.test',
            'role' => UserRole::Cocina->value,
        ]);
    }

    public function test_kitchen_staff_cannot_create_accounts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/admin/personal', [
                'name' => 'Intruso',
                'email' => 'intruso@coffeetec.test',
                'role' => UserRole::Admin->value,
                'password' => 'secret-password',
                'password_confirmation' => 'secret-password',
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('users', ['email' => 'intruso@coffeetec.test']);
    }

    public function test_administrators_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->delete("/admin/personal/{$admin->id}")
            ->assertSessionHas('error');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_administrators_cannot_change_their_own_role(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->patch("/admin/personal/{$admin->id}", [
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => UserRole::Cocina->value,
            ])
            ->assertSessionHas('error');

        $this->assertTrue($admin->refresh()->isAdmin());
    }

    public function test_administrators_can_delete_other_staff_accounts(): void
    {
        $admin = User::factory()->admin()->create();
        $cook = User::factory()->create();

        $this->actingAs($admin)
            ->delete("/admin/personal/{$cook->id}")
            ->assertRedirect(route('admin.staff.index'));

        $this->assertDatabaseMissing('users', ['id' => $cook->id]);
    }
}
