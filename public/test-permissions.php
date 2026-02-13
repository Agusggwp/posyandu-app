<!DOCTYPE html>
<html>
<head>
    <title>Test Permission System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #667eea;
            text-align: center;
            margin-bottom: 40px;
        }
        .user-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        .user-card h2 {
            margin: 0 0 20px 0;
            font-size: 24px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .info-item {
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }
        .info-label {
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 18px;
            font-weight: bold;
        }
        .permissions {
            margin-top: 20px;
        }
        .permission-badge {
            display: inline-block;
            background: rgba(255,255,255,0.3);
            padding: 8px 16px;
            border-radius: 20px;
            margin: 5px;
            font-size: 14px;
            backdrop-filter: blur(10px);
        }
        .status {
            text-align: center;
            padding: 20px;
            background: #f0fdf4;
            border: 2px solid #86efac;
            border-radius: 10px;
            margin-top: 30px;
        }
        .status.success {
            background: #f0fdf4;
            border-color: #86efac;
            color: #166534;
        }
        .check {
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Sistem Permission - Test Dashboard</h1>

        <?php
        // Load Laravel
        require __DIR__.'/../vendor/autoload.php';
        $app = require_once __DIR__.'/../bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        use App\Models\User;
        use App\Models\Role;

        // Get all users with roles
        $users = User::with('role')->get();
        ?>

        <?php foreach($users as $user): ?>
            <div class="user-card">
                <h2>👤 <?= $user->name ?></h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value"><?= $user->email ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Role</div>
                        <div class="info-value"><?= $user->role->name ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Is Admin?</div>
                        <div class="info-value"><?= $user->isAdmin() ? '✅ YES' : '❌ NO' ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Total Permissions</div>
                        <div class="info-value"><?= count($user->role->permissions ?? []) ?></div>
                    </div>
                </div>

                <?php if(!empty($user->role->permissions)): ?>
                    <div class="permissions">
                        <div class="info-label">Permissions:</div>
                        <?php foreach($user->role->permissions as $permission): ?>
                            <span class="permission-badge"><?= $permission ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="status success">
            <div class="check">✅</div>
            <h2>Sistem Permission Berjalan dengan Baik!</h2>
            <p>Admin memiliki <?= count(Role::where('name', 'admin')->first()->permissions ?? []) ?> permissions (Full Power)</p>
            <p>Total Users: <?= $users->count() ?> | Total Roles: <?= Role::count() ?></p>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <a href="/login" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 40px; border-radius: 10px; text-decoration: none; font-weight: bold;">
                🔐 Login ke Sistem
            </a>
        </div>
    </div>
</body>
</html>
