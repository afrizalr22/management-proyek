<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = $this->createUnverifiedOwner();

        $this->actingAs($user)
            ->get('/verify-email')
            ->assertOk()
            ->assertSeeVolt(
                'pages.auth.verify-email'
            );
    }

    public function test_email_can_be_verified(): void
    {
        $user = $this->createUnverifiedOwner();

        Event::fake();

        $verificationUrl =
            URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                [
                    'id' => $user->id,
                    'hash' => sha1($user->email),
                ]
            );

        $response = $this
            ->actingAs($user)
            ->get($verificationUrl);

        Event::assertDispatched(
            Verified::class
        );

        $this->assertTrue(
            $user->fresh()->hasVerifiedEmail()
        );

        $response->assertRedirect(
            route(
                'owner.dashboard',
                absolute: false
            ).'?verified=1'
        );
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
        $user = $this->createUnverifiedOwner();

        $verificationUrl =
            URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                [
                    'id' => $user->id,
                    'hash' => sha1(
                        'wrong-email'
                    ),
                ]
            );

        $this->actingAs($user)
            ->get($verificationUrl);

        $this->assertFalse(
            $user->fresh()->hasVerifiedEmail()
        );
    }

    private function createUnverifiedOwner(): User
    {
        $role = Role::findOrCreate(
            'owner',
            'web'
        );

        $user = User::factory()
            ->unverified()
            ->create();

        $user->assignRole($role);

        return $user;
    }
}