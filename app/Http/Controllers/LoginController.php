<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $credentials = $request->validate([
            "email" => ["required","email"],
            "password" => ["required", "min:8"],
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }else{
            return redirect(route('index'))->with('error', 'Credenciales incorrectas. Por favor, inténtelo de nuevo.');
        }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('index'));
    }
}
