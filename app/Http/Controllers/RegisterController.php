<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function index() {
        if (auth()->user()) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin_dashboard')->with('failed', 'Anda harus logout untuk melakukan register');
            } else {
                return redirect()->route('admin_dashboard')->with('failed', 'Anda harus logout untuk melakukan register');
            }
        }

        return view('register');
    }

    public function store(Request $request) {
        $this->validate($request, [
            "username" => "required|min:4",
            "password" => "required|min:6|confirmed:password_confirmation|same:password_confirmation",
            "password_confirmation" => "min:6",
        ],[
            "username.required" => "Kolom Username wajib diisi!",
            "username.required" => "Username minimal 4 karakter!",
            "password.required" => "Kolom Password wajib diisi!",
            "password.confirmed" => "Kolom Password dan Konfirmasi Password wajib diisi!",
            "password.same" => "Kolom Password dan Konfirmasi Password tidak sama!",
            "password.min" => "Password minimal 6 karakter!",
            "password_confirmation.min" => "Konfirmasi Password minimal 6 karakter!",
        ]);

        $user = new User;
        $user->name = $request->username;
        $user->password = bcrypt($request->password);
        $user->role = "user";
        $user->save();

        return redirect()->route('login_index')->with("success", "Berhasil membuat akun, silakan login dengan benar!");

    }
}
