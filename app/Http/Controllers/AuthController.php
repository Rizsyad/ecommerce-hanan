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
            return redirect('dashboard');
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
            return redirect('dashboard');
        }

        // jika login gagal
        Session::flash('error', 'Incorrect Email or Password');
        return redirect('auth/login');
    }

    public function register()
    {
        // jika user mempunyai session
        if (Auth::check()) {
            return redirect('dashboard');
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

        User::create($validate);
        Auth::Attempt($validate);

        return redirect('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
