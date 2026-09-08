<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSeeVolt('pages.auth.login');
    }

    public function test_owner_can_authenticate_using_login_screen(): void
    {
        $user = $this->createOwner();

        $component = Volt::test(
            'pages.auth.login'
        )
            ->set('form.email', $user->email)
            ->set('form.password', 'password')
            ->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.dashboard',
                    absolute: false
                )
            );

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_authenticate_with_invalid_password(): void
    {
        $user = $this->createOwner();

        Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set(
                'form.password',
                'wrong-password'
            )
            ->call('login')
            ->assertHasErrors('form.email')
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_owner_dashboard_can_be_rendered(): void
    {
        $user = $this->createOwner();

        $this->actingAs($user)
            ->get(
                route('owner.dashboard')
            )
            ->assertOk();
    }

    public function test_users_can_logout(): void
    {
        $user = $this->createOwner();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
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