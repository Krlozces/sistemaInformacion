<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteController extends Controller
{
    public function deleteUser($dni)
    {
        $user = Persona::where('dni', $dni)->first();
        
        if (!$user) {
            return redirect()->route('listar-usuarios')->with('error', 'Usuario no encontrado.');
        }

        $personal = Personal::where('persona_id', $user->id)->first();

        if ($personal) {
            $usuario = User::where('email', $personal->email)->first();
            $personal->delete();
            if ($usuario) {
                $usuario->delete();
            }
        }

        $user->delete();

        return redirect()->route('listar-usuarios')->with('success', 'Usuario eliminado con éxito.');
    }

}
