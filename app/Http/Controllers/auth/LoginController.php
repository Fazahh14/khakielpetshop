<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input dari form
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Proses autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'buyer'  => redirect()->route('pembeli.produk.index')->with('success', 'Login berhasil!'),
                'seller' => redirect()->route('akun.index')->with('success', 'Login admin berhasil!'),
                default  => abort(403),
            };
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Ups! Email atau password yang anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ Arahkan ke halaman index produk setelah logout
        return redirect()->route('pembeli.produk.index')->with('status', 'Berhasil logout!');
    }
}
