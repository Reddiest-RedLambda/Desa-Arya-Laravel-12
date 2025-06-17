<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return back();
        }

        return view('pages.auth.login');
    }
    
    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            return back();
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Silahkan masukan Email anda',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userStatus = Auth::user()->status;

            if ($userStatus == 'submitted') {
                $this->_logout($request);
                return back()->withErrors([
                    'email' => 'Akun anda masih menunggu persetujuan',
                ]);
            } else if ($userStatus == 'rejected') {
                $this->_logout($request);
                return back()->withErrors([
                    'email' => 'Akun anda tidak disetujui',
                ]);
            }
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'Kredensial yang dimasukkan tidak tercatat di data kami!',
        ])->onlyInput('email');
    }

    public function registerView()
    {
        if (Auth::check()) {
            return back();
        }

        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return back();
        }

        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'name.required' => 'Nama Tidak Boleh Kosong',
            'email.required' => 'Email Tidak Boleh Kosong',
            'email.email' => 'Email Tidak Valid,',
            'password.required' => 'Password Tidak Boleh Kosong',
        ]);

        $user =  new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = 2;
        $user->saveOrFail();

        return redirect('/')->with('success', 'Akun berhasil didaftarkan, menunggu persetujuan');
    }

    public function _logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $this->_logout($request);
    
        return redirect('/');
    }
}
