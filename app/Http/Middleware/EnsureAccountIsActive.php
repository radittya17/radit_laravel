<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->is_active) {
            return $next($request);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Akun Anda sedang dinonaktifkan.'], 403);
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi admin.',
        ]);
    }
}
