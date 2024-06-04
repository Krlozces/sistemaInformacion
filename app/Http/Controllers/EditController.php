<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Persona;
use App\Models\Personal;
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

    public function editUser(Request $request, $dni)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'apellido_paterno' => ['required', 'string'],
            'apellido_materno' => ['required', 'string'],
            'grado' => ['required'],
            'dni' => ['required', 'string', 'min:8'],
            'telefono' => ['required', 'string'],
        ]);

        $user = Persona::where('dni', $dni)->first();

        if (!$user) {
            return redirect()->route('listar-usuarios')->with('error', 'Usuario no encontrado.');
        }

        $user->nombre = $data['nombre'];
        $user->dni = $data['dni'];
        $user->apellido_paterno = $data['apellido_paterno'];
        $user->apellido_materno = $data['apellido_materno'];
        $user->save();

        $personal = Personal::where('persona_id', $user->id)->first();

        if ($personal) {
            $grado = Grado::where('id', $data['grado'])->first();
            $personal->telefono = $data['telefono'];
            if ($grado) {
                $personal->grado_id = $grado->id;
                $personal->save();
            } else {
                return redirect()->route('listar-usuarios')->with('error', 'Grado no encontrado.');
            }
        } else {
            return redirect()->route('listar-usuarios')->with('error', 'Registro de personal no encontrado.');
        }

        return redirect()->route('listar-usuarios')->with('success', 'Registro editado con éxito.');
    }

    // todavía no implementado
    public function changePermission(Request $request, $email) {
        // Buscar el usuario por email
        $usuario = User::where('email', $email)->first();
    
        if (!$usuario) {
            return redirect()->route('listar-usuarios')->with('error', 'Usuario no encontrado.');
        }
    
        // Quitar roles anteriores (opcional, dependiendo de tu lógica)
        $usuario->syncRoles([]);
    
        if ($request->area_perteneciente == 'areaextra') {
            $usuario->assignRole('procesador');
        } else {
            $usuario->assignRole('extractor');
        }
    
        return redirect()->route('listar-usuarios')->with('success', 'Permisos actualizados correctamente.');
    }
}
