<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = $this->broker()->sendResetLink(
            $request->only('email')
        );

        $user = User::where('email', $request->email)->first();

        try {
            ActivityLog::create([
                'user_id' => $user?->id,
                'action' => $status === Password::RESET_LINK_SENT ? 'reset_requested' : 'reset_failed',
                'model' => 'User',
                'model_id' => $user?->id,
                'description' => $status === Password::RESET_LINK_SENT
                    ? 'Permintaan reset password petugas untuk email: ' . $request->email
                    : 'Gagal meminta reset password petugas untuk email: ' . $request->email,
                'properties' => [
                    'guard' => 'web',
                    'status' => $status,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Keep forgot-password flow running even if logging fails.
        }

        return $status == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $status)
                    : $this->sendResetLinkFailedResponse($request, $status);
    }
}
