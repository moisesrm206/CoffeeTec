<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_public_menu_does_not_require_authentication(): void
    {
        $this->get('/menu')->assertOk();
    }

    public function test_guests_are_redirected_to_login_from_the_kitchen(): void
    {
        $this->get('/cocina')->assertRedirect('/login');
    }

    public function test_kitchen_staff_can_open_the_kitchen_panel(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/cocina')->assertOk();
    }

    public function test_kitchen_staff_cannot_open_the_staff_administration(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/personal')->assertForbidden();
    }

    public function test_administrators_can_open_the_staff_administration(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->get('/admin/personal')->assertOk();
    }
}
