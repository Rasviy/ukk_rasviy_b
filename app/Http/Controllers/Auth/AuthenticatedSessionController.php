<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\LogActivity;

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

        // ✅ LOG LOGIN
        LogActivity::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'login',
            'detail' => 'User login ke sistem',
            'waktu' => now()
        ]);

        return redirect('/redirect');
    }

    /**
     * Destroy an authenticated session.
     */

    public function destroy(Request $request)
    {
        LogActivity::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'logout',
            'detail' => 'User logout dari sistem',
            'waktu' => now()
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
