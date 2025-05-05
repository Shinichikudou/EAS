<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
{
    // Validasi input
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Coba login
    if (Auth::attempt($credentials, $request->filled('remember'))) {
        // Regenerasi session untuk mencegah session fixation
        $request->session()->regenerate();

        // Periksa role dan redirect ke dashboard yang sesuai
        switch (Auth::user()->role) {
            case 'admin_sistem':
                return redirect()->route('admin.dashboard');  // Redirect ke admin dashboard
            case 'security':
                return redirect()->route('security.dashboard');  // Redirect ke security dashboard
            default:
                Auth::logout();  // Logout jika role tidak valid
                return back()->withErrors(['email' => 'Role tidak valid.']);
        }
    }

    // Jika gagal login, kembalikan dengan pesan error
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}
    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
