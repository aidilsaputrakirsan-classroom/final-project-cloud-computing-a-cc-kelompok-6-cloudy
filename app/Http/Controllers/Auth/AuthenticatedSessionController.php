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

        // Activity Log
        \DB::table('activity_logs')->insert([
            'user_id'    => $request->user()->id,
            'name'       => $request->user()->name,
            'role'       => $request->user()->role,
            'ip'         => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'activity'   => 'Login',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $request->user()->role === 'admin'
            ? redirect()->route('dashboard')
            : redirect()->route('user.catalog');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Activity Log Logout
        \DB::table('activity_logs')->insert([
            'user_id'    => auth()->id(),
            'name'       => auth()->user()->name,
            'role'       => auth()->user()->role,
            'ip'         => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'activity'   => 'Logout',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
