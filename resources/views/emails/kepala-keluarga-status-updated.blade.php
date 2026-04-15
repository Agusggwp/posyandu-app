<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Akun Diperbarui</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f8fafc; margin:0; padding:0; color:#111827;">
    <div style="max-width:640px; margin:0 auto; padding:32px 16px;">
        <div style="background:#ffffff; border:1px solid #dbeafe; border-radius:24px; padding:32px; box-shadow:0 10px 25px rgba(0,0,0,.05);">
            <h1 style="margin:0 0 16px; font-size:28px; line-height:1.2; color:#1d4ed8;">Status Akun Diperbarui</h1>
            <p style="margin:0 0 16px; font-size:16px; line-height:1.7;">Halo {{ $keluarga->nama_lengkap }},</p>
            <p style="margin:0 0 16px; font-size:16px; line-height:1.7;">Admin telah mengubah status akun Anda menjadi <strong>{{ strtoupper($status) }}</strong>.</p>
            <p style="margin:0 0 24px; font-size:16px; line-height:1.7;">Silakan masuk kembali ke panel kepala keluarga melalui tautan berikut.</p>
            <p style="margin:32px 0; text-align:center;">
                <a href="{{ $loginUrl }}" style="display:inline-block; background:#2563eb; color:#ffffff; text-decoration:none; padding:14px 24px; border-radius:14px; font-weight:700;">Masuk ke Panel</a>
            </p>
            <p style="margin:0; font-size:14px; line-height:1.7; color:#4b5563;">Terima kasih.</p>
        </div>
    </div>
</body>
</html>
