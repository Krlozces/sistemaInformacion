<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class EditController extends Controller
{
    public function cambiarPassword($id, Request $request){
        $user = User::find($id);
        
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('home')->with('error', 'La contraseña actual es incorrecta');
        }

        $request->validate([
            'newPassword' => ['required', 'min:8'],
            'confirmedPassword' => ['required', 'same:newPassword']
        ]);

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return redirect()->route('home')->with('success', 'Contraseña cambiada con éxito');
    }
}
