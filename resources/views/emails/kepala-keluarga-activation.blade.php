<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f8fafc; margin:0; padding:0; color:#111827;">
    <div style="max-width:640px; margin:0 auto; padding:32px 16px;">
        <div style="background:#ffffff; border:1px solid #d1fae5; border-radius:24px; padding:32px; box-shadow:0 10px 25px rgba(0,0,0,.05);">
            <h1 style="margin:0 0 16px; font-size:28px; line-height:1.2; color:#065f46;">Aktivasi Akun Kepala Keluarga</h1>
            <p style="margin:0 0 16px; font-size:16px; line-height:1.7;">Halo {{ $keluarga->nama_lengkap }},</p>
            <p style="margin:0 0 16px; font-size:16px; line-height:1.7;">Akun Anda sudah terdaftar. Klik tombol di bawah untuk mengaktivasi akun dan melanjutkan proses persetujuan admin.</p>
            <p style="margin:32px 0; text-align:center;">
                <a href="{{ $activationUrl }}" style="display:inline-block; background:#059669; color:#ffffff; text-decoration:none; padding:14px 24px; border-radius:14px; font-weight:700;">Aktivasi Akun</a>
            </p>
            <p style="margin:0 0 8px; font-size:14px; line-height:1.7; color:#4b5563;">Jika tombol tidak bisa diklik, salin tautan berikut:</p>
            <p style="margin:0; font-size:13px; line-height:1.7; word-break:break-all; color:#0f766e;">{{ $activationUrl }}</p>
        </div>
    </div>
</body>
</html>
