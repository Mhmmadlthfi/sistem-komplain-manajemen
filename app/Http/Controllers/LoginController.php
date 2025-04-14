<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'no_staff' => 'required|digits:5',
                'password' => 'required'
            ],
            [
                'no_staff.digits' => 'No petugas harus berupa angka & berjumlah 5 karakter!',
            ]
        );

        $user = User::where('no_staff', $request->no_staff)->first();

        if ($user && !$user->status) {
            return back()->with('loginError', 'Akun Anda tidak aktif. Hubungi Manager Marketing untuk informasi lebih lanjut.');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // $request->session()->forget('url.intended');
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return back()->with('loginError', 'Terjadi kesalahan, periksa kembali!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
