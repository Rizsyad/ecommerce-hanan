<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
         // jika user mempunyai session
         if (Auth::check()) {
            // jika admin redirect ke dashboard
            if (auth()->user()->getRoleNames()->first() === 'admin') {
                return redirect('dashboard');
            }

            // jika user redirect ke index lagi
            return redirect('/');
        }

        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        // validasi inputan
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // jika login berhasil
        if (Auth::Attempt($validate)) {
            $request->session()->regenerate();

            if(auth()->user()->getRoleNames()->first() === "admin") return redirect('dashboard');
            return redirect('/');
        }

        // jika login gagal
        return back()->withErrors(['msg' => 'Incorrect Email or Password']);
    }

    public function register()
    {
        // Cek jika pengguna sudah login
        if (Auth::check()) {
            // Jika admin, redirect ke dashboard
            if (auth()->user()->hasRole('admin')) {
                return redirect()->route('dashboard');
            }
    
            // Jika pengguna biasa, redirect ke halaman utama
            return redirect()->route('home');
        }

        
        return view('auth.register');
    }
    

    public function registerProcess(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $validate['password'] = bcrypt($validate['password']);

        $user = User::create($validate);
        $user->assignRole('user');

        Auth::Attempt($validate);

        return redirect(route('login'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
