<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Log;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
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

        if ($user->estado == 0) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada. No puedes iniciar sesión.');
        }

        $colombianTimezone = 'America/Bogota';

        $now = Carbon::now($colombianTimezone);

        $user->update([
            'last_login' => $now->format('Y-m-d H:i:s'),
        ]);

        $log = new Log([
            'user_id' => $user->id,
            'usuario_actualizador' => $user->id,
            'detalle' => 'El usuario ' . ($user->name ?? '') . ' ' .
                ($user->segundo_name ?? '') . ' ' .
                ($user->primer_apellido ?? '') . ' ' .
                ($user->segundo_apellido ?? '') . ' - ' .
                ($user->codigo_interno ?? '') . ' - ' . ($user->email ?? '') . ' ha iniciado sesión ',
            'empresa_id' => $user->empresas_ids[0],
        ]);
        $log->save();

        return redirect()->intended(RouteServiceProvider::HOME);
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
