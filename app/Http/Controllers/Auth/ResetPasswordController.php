<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = \Illuminate\Support\Facades\Hash::make($password);

        $user->setRememberToken(\Illuminate\Support\Str::random(60));

        $user->save();

        event(new \Illuminate\Auth\Events\PasswordReset($user));
    }

    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $resetUser = null;

        $status = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) use (&$resetUser) {
                $this->resetPassword($user, $password);
                $resetUser = $user;
            }
        );

        $targetUser = $resetUser ?: User::where('email', $request->email)->first();

        try {
            ActivityLog::create([
                'user_id' => $targetUser?->id,
                'action' => $status === Password::PASSWORD_RESET ? 'reset_completed' : 'reset_failed',
                'model' => 'User',
                'model_id' => $targetUser?->id,
                'description' => $status === Password::PASSWORD_RESET
                    ? 'Reset password petugas berhasil untuk email: ' . $request->email
                    : 'Reset password petugas gagal untuk email: ' . $request->email,
                'properties' => [
                    'guard' => 'web',
                    'status' => $status,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Keep reset flow running even if logging fails.
        }

        return $status == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $status)
                    : $this->sendResetFailedResponse($request, $status);
    }
}
