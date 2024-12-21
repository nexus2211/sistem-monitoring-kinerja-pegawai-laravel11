<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerView() {

        return view('auth.register');
    }

    public function register(Request $request) {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'type' => $request->input('type')
        ];

        User::create($data);
        return redirect()->route('pegawai')->with('success','Data berhasil disimpan!');
    }

    public function loginView() {

        return view('auth.login');
    }

    public function loginSubmit(Request $request) {
        $data = $request->only('email','password');

        if(Auth::attempt($data)){
            $request->session()->regenerate();
            return redirect()->route('pegawai');
        }else {
            return redirect()->route('login')->with('gagal','Email atau Password salah');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
