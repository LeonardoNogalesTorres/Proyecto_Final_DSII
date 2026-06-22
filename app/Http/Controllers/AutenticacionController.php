<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutenticacionController extends Controller
{
    public function mostrarLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            $rol = Auth::user()->role;

            if ($rol === 'director') return redirect('/director/dashboard');
            if ($rol === 'tutor') return redirect('/tutor/dashboard');
            return redirect('/estudiante/dashboard');
        }

        return back()->withErrors(['email' => 'Credenciales inválidas'])->withInput();
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}