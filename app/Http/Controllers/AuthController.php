<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Operator;
use Carbon\Carbon; // Tambahkan ini untuk mengelola waktu

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nama_pengguna' => 'required',
            'kata_sandi' => 'required',
        ]);

        $user = Operator::where('nama_pengguna', $request->nama_pengguna)->first();

        if ($user && Hash::check($request->kata_sandi, $user->kata_sandi)) {
            
            // LOGIKA BARU: Update kolom terakhir_login
            $user->update([
                'terakhir_login' => Carbon::now()
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Username atau Password salah!')->withInput();
    }
}