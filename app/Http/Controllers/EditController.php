<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class EditController extends Controller
{
    public function cambiarPassword($id, Request $request){
        $user = User::find($id);
        
        if (!Hash::check($request->password_actual, $user->password)) {
            return response()->with('error', 'La contraseña actual es incorrecta');
        }

        $incomingFields = $request->validate([
            'newPassword' => ['required', 'min:8'],
            'nombre' => ['required'],
            'apellido_paterno' => ['required']
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->with('success', 'Contraseña cambiada con éxito');
    }
}
