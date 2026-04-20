<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Keluarga;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class KepalaKeluargaResetPasswordController extends Controller
{
    public function showResetForm(Request $request, string $token)
    {
        return view('panel_kepalakeluarga.auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $resetUser = null;

        $status = Password::broker('kepala_keluarga')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Keluarga $user, string $password) use (&$resetUser) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                $resetUser = $user;
            }
        );

        $targetUser = $resetUser ?: Keluarga::where('email', $request->email)->first();

        try {
            ActivityLog::create([
                'user_id' => null,
                'action' => $status === Password::PASSWORD_RESET ? 'reset_completed' : 'reset_failed',
                'model' => 'KepalaKeluarga',
                'model_id' => $targetUser?->id,
                'description' => $status === Password::PASSWORD_RESET
                    ? 'Reset password Kepala Keluarga berhasil untuk email: ' . $request->email
                    : 'Reset password Kepala Keluarga gagal untuk email: ' . $request->email,
                'properties' => [
                    'guard' => 'kepala_keluarga',
                    'status' => $status,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Keep reset flow running even if logging fails.
        }

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('kepala-keluarga.login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
