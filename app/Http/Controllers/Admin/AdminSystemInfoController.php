<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminSystemInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show system info.
     */
    public function index()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => config('database.default'),
            'environment' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'timezone' => config('app.timezone'),
            'locale' => config('app.locale'),
        ];

        return view('admin.system-info', compact('info'));
    }
}
