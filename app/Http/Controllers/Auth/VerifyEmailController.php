<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(
        EmailVerificationRequest $request
    ): RedirectResponse {
        $user = $request->user();

        abort_unless(
            $user instanceof User,
            403
        );

        if (! $user->hasVerifiedEmail()) {
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }
        }

        return redirect()->intended(
            $this->dashboardUrl($user)
                .'?verified=1'
        );
    }

    private function dashboardUrl(
        User $user
    ): string {
        return match (true) {
            $user->hasRole('owner') =>
                route(
                    'owner.dashboard',
                    absolute: false
                ),

            $user->hasRole('mandor') =>
                route(
                    'mandor.dashboard',
                    absolute: false
                ),

            $user->hasRole('pekerja') =>
                route(
                    'pekerja.dashboard',
                    absolute: false
                ),

            default => route(
                'login',
                absolute: false
            ),
        };
    }
}