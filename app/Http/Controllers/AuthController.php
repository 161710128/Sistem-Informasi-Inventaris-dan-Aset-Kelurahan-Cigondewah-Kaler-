<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function loginForm()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,lurah',
        ]);

        // $credentials = $request->only('email', 'password');
        $role = $request->input('role');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role === $role) {
                // Autentikasi berhasil sesuai role
                if ($role === 'admin') {
                    return redirect('/admin/dashboard');
                } elseif ($role === 'lurah') {
                    return redirect('/lurah/dashboard');
                }
            } else {
                // Autentikasi berhasil, tapi role tidak sesuai
                Auth::logout();
                return redirect()->route('login.form')->withErrors('error', 'Role tidak sesuai dengan akun.');
            }
        } else {
            // Autentikasi gagal
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
