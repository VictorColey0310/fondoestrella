<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $logForgotPassword = new Log([
                    'user_id' => $user->id,
                    'usuario_actualizador' => $user->id,
                    'detalle' => 'Solicitud de restablecimiento de contraseña para ' . ($user->name ?? '') . ' ' .
                        ($user->segundo_name ?? '') . ' ' .
                        ($user->primer_apellido ?? '') . ' ' .
                        ($user->segundo_apellido ?? '') . ' - ' .
                        ($user->codigo_interno ?? '') . ' - ' . ($request->email ?? ''),
                    'empresa_id' => $user->empresas_ids[0],
                ]);
                $logForgotPassword->save();
            }
        }

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
