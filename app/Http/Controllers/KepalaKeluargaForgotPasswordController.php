<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class KepalaKeluargaForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('panel_kepalakeluarga.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        if (! Keluarga::where('email', $request->email)->exists()) {
            try {
                ActivityLog::create([
                    'user_id' => null,
                    'action' => 'reset_failed',
                    'model' => 'KepalaKeluarga',
                    'description' => 'Gagal meminta reset password Kepala Keluarga untuk email yang tidak terdaftar: ' . $request->email,
                    'properties' => [
                        'guard' => 'kepala_keluarga',
                        'status' => 'EMAIL_NOT_FOUND',
                    ],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            } catch (\Throwable $e) {
                // Keep forgot-password flow running even if logging fails.
            }

            throw ValidationException::withMessages([
                'email' => 'Email Kepala Keluarga tidak ditemukan.',
            ]);
        }

        $keluarga = Keluarga::where('email', $request->email)->first();

        $status = Password::broker('kepala_keluarga')->sendResetLink(
            $request->only('email')
        );

        try {
            ActivityLog::create([
                'user_id' => null,
                'action' => $status === Password::RESET_LINK_SENT ? 'reset_requested' : 'reset_failed',
                'model' => 'KepalaKeluarga',
                'model_id' => $keluarga?->id,
                'description' => $status === Password::RESET_LINK_SENT
                    ? 'Permintaan reset password Kepala Keluarga untuk email: ' . $request->email
                    : 'Gagal meminta reset password Kepala Keluarga untuk email: ' . $request->email,
                'properties' => [
                    'guard' => 'kepala_keluarga',
                    'status' => $status,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Keep forgot-password flow running even if logging fails.
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }
}
