<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KepalaKeluargaResetPasswordNotification extends Notification
{
    use Queueable;

    public function __construct(protected string $token)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $resetUrl = route('kepala-keluarga.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ]);

        return (new MailMessage)
            ->subject('Reset Password Kepala Keluarga')
            ->greeting('Halo ' . ($notifiable->nama_lengkap ?? 'Kepala Keluarga'))
            ->line('Kami menerima permintaan reset password untuk akun Kepala Keluarga Anda.')
            ->action('Reset Password', $resetUrl)
            ->line('Jika Anda tidak meminta reset password, abaikan email ini.');
    }
}
