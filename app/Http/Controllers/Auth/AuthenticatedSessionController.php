<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'siswa') {
            $intendedUrl = $request->session()->pull('url.intended');
            $intendedPath = is_string($intendedUrl)
                ? parse_url($intendedUrl, PHP_URL_PATH)
                : null;

            if (in_array($intendedPath, [
                route('peminjaman.store', absolute: false),
                route('buku.index', absolute: false),
            ], true)) {
                return redirect()->route('buku.index');
            }

            return redirect()->route('siswa.dashboard');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        abort(403, 'Role akun tidak dikenali.');
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
