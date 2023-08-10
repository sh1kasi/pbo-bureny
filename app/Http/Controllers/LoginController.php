<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() {

        if (!empty(auth()->user()->id)) {
            $role = User::find(auth()->user()->id);
            if ($role->role === 'admin') {
                return redirect()->route('admin_dashboard_index');
            } else {
                dd('sek sabar');
            }
        }
        

        return view("login");
    }

    public function store(Request $request) {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required|min:6',
        ],[
            'name.required' => 'Kolom nama wajib diisi!',
            'password.required' => 'Kolom password wajib diisi!',
            'password.min' => 'Password minimal 6 karakter!',
        ]);

        if (Auth::attempt($credentials)) {
            $role = auth()->user()->role;
            if ($role === "admin") {
                return redirect()->route("admin_dashboard_index")->with("success", "Login Berhasil!");
            } else {
                dd("sabar!");
            }
        }

        return redirect()->route('login_index')->with("failed", "Username atau Password Salah!");

    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect()->route("login_index");
    }
}

