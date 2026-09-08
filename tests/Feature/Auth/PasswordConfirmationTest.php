<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = $this->createOwner();

        $this->actingAs($user)
            ->get('/confirm-password')
            ->assertOk()
            ->assertSeeVolt(
                'pages.auth.confirm-password'
            );
    }

    public function test_password_can_be_confirmed(): void
    {
        $user = $this->createOwner();

        $this->actingAs($user);

        Volt::test(
            'pages.auth.confirm-password'
        )
            ->set('password', 'password')
            ->call('confirmPassword')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.dashboard',
                    absolute: false
                )
            );
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $user = $this->createOwner();

        $this->actingAs($user);

        Volt::test(
            'pages.auth.confirm-password'
        )
            ->set(
                'password',
                'wrong-password'
            )
            ->call('confirmPassword')
            ->assertHasErrors('password')
            ->assertNoRedirect();
    }

    private function createOwner(): User
    {
        $role = Role::findOrCreate(
            'owner',
            'web'
        );

        $user = User::factory()->create();

        $user->assignRole($role);

        return $user;
    }
}