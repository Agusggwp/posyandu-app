<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi Kepala Keluarga</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif; background: #f8f9fb; margin: 0; padding: 0; color: #1f2937; line-height: 1.5;">
    <!-- Main wrapper -->
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <!-- Container -->
        <div style="background: #ffffff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); overflow: hidden;">
            <!-- Header -->
            <div style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); padding: 32px 24px; text-align: center;">
                <div style="font-size: 32px; font-weight: 700; color: #ffffff; margin: 0; letter-spacing: -0.5px;">🏠</div>
                <h1 style="margin: 12px 0 0; font-size: 24px; font-weight: 700; color: #ffffff;">Reset Kata Sandi</h1>
            </div>

            <!-- Body -->
            <div style="padding: 32px 24px;">
                <p style="margin: 0 0 20px; font-size: 16px; color: #1f2937;">Halo {{ $kepalaKeluarga->nama_lengkap ?? 'Kepala Keluarga' }},</p>

                <p style="margin: 0 0 24px; font-size: 15px; color: #4b5563; line-height: 1.6;">
                    Kami menerima permintaan untuk mereset kata sandi akun Kepala Keluarga Anda di Sistem Posyandu. Klik tombol di bawah untuk membuat kata sandi baru.
                </p>

                <!-- CTA Button -->
                <div style="margin: 32px 0; text-align: center;">
                    <a href="{{ $resetUrl }}" style="display: inline-block; background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3); transition: transform 0.2s ease;">Reset Kata Sandi</a>
                </div>

                <!-- Info box -->
                <div style="background: #ecfdf5; border-left: 4px solid #059669; padding: 16px; border-radius: 4px; margin: 24px 0; font-size: 14px; color: #065f46;">
                    <strong>Keamanan:</strong> Link reset kata sandi berlaku selama 60 menit. Jangan bagikan link ini kepada siapa pun.
                </div>

                <!-- Fallback link -->
                <div style="margin: 24px 0; border-top: 1px solid #e5e7eb; padding-top: 24px;">
                    <p style="margin: 0 0 8px; font-size: 13px; color: #6b7280;">Jika tombol tidak berfungsi, salin dan tempel tautan berikut di browser Anda:</p>
                    <div style="background: #f3f4f6; padding: 12px; border-radius: 6px; word-break: break-all; font-family: 'Monaco', 'Courier New', monospace; font-size: 12px; color: #374151; overflow-x: auto;">{{ $resetUrl }}</div>
                </div>

                <!-- Family info -->
                <div style="margin: 24px 0 0; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <p style="margin: 0 0 8px; font-size: 14px; font-weight: 600; color: #1f2937;">Informasi Akun:</p>
                    <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: #4b5563; line-height: 1.8;">
                        <li style="margin: 6px 0;"><strong>Email:</strong> {{ $kepalaKeluarga->email }}</li>
                        @if($kepalaKeluarga->no_kk ?? false)
                        <li style="margin: 6px 0;"><strong>No. Kartu Keluarga:</strong> {{ $kepalaKeluarga->no_kk }}</li>
                        @endif
                        @if($kepalaKeluarga->no_identitas ?? false)
                        <li style="margin: 6px 0;"><strong>No. Identitas:</strong> {{ $kepalaKeluarga->no_identitas }}</li>
                        @endif
                    </ul>
                </div>

                <!-- FAQ Section -->
                <div style="margin: 24px 0 0; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                    <p style="margin: 0 0 12px; font-size: 14px; font-weight: 600; color: #1f2937;">Pertanyaan Umum:</p>
                    <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: #4b5563; line-height: 1.8;">
                        <li style="margin: 6px 0;">Saya tidak meminta reset kata sandi — abaikan email ini dan kata sandi Anda tetap aman.</li>
                        <li style="margin: 6px 0;">Akun Anda hanya aman jika Anda yang melakukan reset ini.</li>
                        <li style="margin: 6px 0;">Link akan kadaluarsa dalam 60 menit untuk keamanan Anda.</li>
                        <li style="margin: 6px 0;">Jika Anda tidak memiliki akses email ini, hubungi admin posyandu.</li>
                    </ul>
                </div>

                <!-- Support info -->
                <p style="margin: 24px 0 0; font-size: 13px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 24px;">
                    Butuh bantuan? Hubungi admin posyandu atau tim support kami di 
                    <a href="mailto:support@posyandu.local" style="color: #059669; text-decoration: none; font-weight: 500;">support@posyandu.local</a>
                </p>
            </div>

            <!-- Footer -->
            <div style="background: #f8f9fb; padding: 20px 24px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 12px; color: #6b7280;">
                <p style="margin: 0 0 8px;">© 2026 Sistem Posyandu. Semua hak dilindungi.</p>
                <p style="margin: 0;">
                    <a href="{{ url('/') }}" style="color: #059669; text-decoration: none;">Kembali ke Sistem</a>
                </p>
            </div>
        </div>

        <!-- Spacer -->
        <div style="height: 20px;"></div>
    </div>

    <!-- Security notice -->
    <div style="max-width: 600px; margin: 0 auto; padding: 0 20px;">
        <p style="margin: 0; font-size: 11px; color: #9ca3af; text-align: center;">
            Email ini dikirim karena ada permintaan reset kata sandi untuk akun Kepala Keluarga Anda di Sistem Posyandu. 
            <br />Jika Anda tidak melakukan ini, abaikan email ini.
        </p>
    </div>
</body>
</html>
