<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the login form with customizable admin settings
     */
    public function showLoginForm()
    {
        $loginSettings = [
            'title' => Setting::getSetting('admin_login_title', 'Admin Dashboard'),
            'subtitle' => Setting::getSetting('admin_login_subtitle', 'Kelola sistem informasi kesehatan keluarga'),
            'description' => Setting::getSetting('admin_login_description', 'Silakan masuk ke akun admin Anda untuk mengelola sistem Posyandu'),
        ];

        return view('auth.login', compact('loginSettings'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->has('remember');

        if (auth()->guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended($this->redirectPath());
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
}
