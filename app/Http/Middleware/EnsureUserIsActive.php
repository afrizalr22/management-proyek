<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Memastikan pengguna yang sedang login
     * masih mempunyai status aktif.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = Auth::user();

        if (
            $user instanceof User
            && $user->status !== 'active'
        ) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'status',
                    'Akun Anda telah dinonaktifkan. Hubungi Owner untuk memperoleh akses kembali.'
                );
        }

        return $next($request);
    }
}