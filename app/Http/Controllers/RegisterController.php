<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Clase;
use App\Models\Grado;
use App\Models\Metodo;
use App\Models\Unidad;
use App\Models\Muestra;
use App\Models\Persona;
use App\Models\Licencia;
use App\Models\Personal;
use App\Models\Registro;
use App\Models\Comisaria;
use App\Models\Extraccion;
use App\Models\Intervenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request){
        $incomingFields = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required', 'min:8']
        ]);
        User::create($incomingFields);
        return view('index')->with('success', '¡Registro exitoso!');
    }

    public function registerPersonal(Request  $request){
        $incomingFields = $request->validate([
            'dni' => ['required'],
            'nombre' => ['required'],
            'apellido_paterno' => ['required'],
            'apellido_materno' => ['required'],
            'genero' => ['required'],
            'grado' => ['required'],
            'unidad_perteneciente' => ['required'],
            'area_perteneciente' => ['required'],
            'direccion' => ['required'],
            'telefono' => ['required'],
            'usuario' => ['required'],
            'password' => ['required'],
            'imagen' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            $imagenNombre = $request->file('imagen')->store('imagenes_perfil', 'public');
    
            $incomingFields['imagen_perfil'] = $imagenNombre;
        }

        // Crear una nueva persona
        $persona = Persona::create($request->only(['dni', 'nombre', 'apellido_paterno', 'apellido_materno']));

        // Crear un nuevo personal asociado a la persona
        $personal = new Personal([
            'genero' => $request->genero,
            'grado' => $request->grado,
            'unidad_perteneciente' => $request->unidad_perteneciente,
            'area_perteneciente' => $request->area_perteneciente,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'usuario' => $request->usuario,
            'password'=> $request->password
        ]);

        // Asignar el ID de la persona al personal
        $personal->persona_id = $persona->id;

        // Guardar el personal
        $personal->save();

        // Crear un nuevo usuario
        $usuario = User::create([
            'name' => $request->nombre,
            'email' => $request->usuario,
            'password' => bcrypt($request->password),
            'imagen_perfil' => $incomingFields['imagen_perfil']
        ]);

        return redirect()->back();
    }

    public function registerExtraccion(Request $request){
        // Registrar al intervenido
        $registro = Persona::create($request->only(['dni', 'nombre', 'apellido_paterno', 'apellido_materno']));

        $extraccionData['persona_id'] = $registro->id;
        $extraccion = Extraccion::create($extraccionData);

        // Registrar intervenido
        $intervenidoData['persona_id'] = $registro->id;
        $intervenido = Intervenido::create(array_merge($request->only(['nacionalidad', 'edad', 'sexo']), $intervenidoData));

        // Registrar comisaria
        $comisaria = Comisaria::firstOrCreate(['procedencia' => $request->procedencia]);

        $unidadData['persona'] = $request->input('nombre_policial');
        $unidadData['procedencia_id'] = $comisaria->id;
        $unidad = Unidad::create($unidadData);

        // Registrar la clase
        $clase = Clase::create($request->only(['clase']));

        // Crear la licencia asociada con ese Intervenido
        $licencia = Licencia::create([
            'placa' => $request->placa,
            'vehiculo' => $request->vehiculo,
            'intervenido_id' => $intervenido->id, 
            'clase_id' => $clase->id,
            'licencia' => $request->licencia,
            'categoria' => $request->categoria,
        ]);
        
        $metodo = Metodo::create([
            'descripcion' => $request->descripcion
        ]);
        
        $muestraData['metodo_id'] = $metodo->id;
        
        // Obtener el valor de 'fecha_infraccion' desde la solicitud
        $fechaInfraccion = $request->input('fecha_infraccion');
        $horaInfraccion = $request->input('hora_infraccion');
        $tipoMuestra = $request->input('tipo_muestra');
        
        // Crear un nuevo arreglo de datos para la muestra con 'fecha_muestra' igual a 'fecha_infraccion'
        $muestraData = array_merge($request->only(['observaciones', 'resultado_cualitativo', 'resultado_cuantitativo']), ['fecha_muestra' => $fechaInfraccion], ['hora_muestra' => $horaInfraccion], ['descripcion' => $tipoMuestra], $muestraData);

        // Crear el modelo Muestra con los datos actualizados
        $muestra = Muestra::create($muestraData);

        $extractorId = $request->extractor;
        $extractor = Persona::findOrFail($extractorId);

        $infraccionData = $request->fecha_infraccion. ' ' . $request->hora_infraccion;
        $timeExtraccion = $request->fecha_extraccion . ' ' . $request->hora_extraccion;
        $user = Auth::user();
        $extraccionId['extraccion_id'] = $extraccion->id;
        $muestraData['usuario_id'] = $user->id;
        $comisariaData['comisaria_id'] = $comisaria->id;
        $muestraId['muestra_id'] = $muestra->id;
        $intervenidoId['intervenido_id'] = $intervenido->id ;
        $registroCert = Registro::create(array_merge(
            $request->only(['recepcion_doc_referencia', 'motivo', 'extractor', 'fecha', 'hora']),
            $muestraData,
            $muestraId,
            $intervenidoId,
            $comisariaData,
            $extraccionId,
            ['fecha_hora_infraccion' => $infraccionData],
            ['fecha_hora_extraccion' => $timeExtraccion]
        ));
        
        $elementos = [
            'registro' => $registro,
            'extraccion' => $extraccion,
            'intervenido' => $intervenido,
            'comisaria' => $comisaria,
            'unidad' => $unidad,
            'clase' => $clase,
            'licencia' => $licencia,
            'metodo' => $metodo,
            'muestra' => $muestra,
            'infraccionData' => $infraccionData,
            'timeExtraccion' => $timeExtraccion,
            'extraccionId' => $extraccionId,
            'comisariaData' => $comisariaData,
            'registroCert' => $registroCert,
            'extractor' => $extractor
        ];
        
        return view('tabla-certificados', ['elementos' => $elementos]);
    }

    public function registerProcesamiento(Request $request){
        $dataProcesamiento = $request->validate([
            'procesador' => ['required'],
            'resultado_cuantitativo' => ['required']
        ]);

        $dataExtraccion = $request->only([
            'recepcion_doc_referencia',
            'procedencia',
            'fecha',
            'hora',
            'motivo',
            'fecha_hora_extraccion',
            'fecha_hora_infraccion',
            'dni',
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'edad',
            'nacionalidad',
            'licencia',
            'clase',
            'categoria',
            'vehiculo',
            'placa',
            'tipo_muestra',
            'resultado_cualitativo',
            'observaciones',
            'conclusiones'
        ]);
        
        $registro = Registro::where('recepcion_doc_referencia', $dataExtraccion['recepcion_doc_referencia'])->first();
        if ($registro) {
            $registro->update([
                'procesador' => $dataProcesamiento['procesador']
            ]);
            $muestra = $registro->muestra;

            if ($muestra) {
                $muestra->update([
                    'resultado_cuantitativo' => $dataProcesamiento['resultado_cuantitativo'],
                    'observaciones' => $dataExtraccion['observaciones'],
                    'resultado_cualitativo' => $dataExtraccion['resultado_cualitativo']
                ]);
            }
        }
        
        $registroToUpdate = Registro::where('intervenido_id', $dataExtraccion['dni'])->first();
        if ($registroToUpdate) {
            $registroToUpdate->update([
                'recepcion_doc_referencia' => $dataExtraccion['recepcion_doc_referencia'],
                'fecha' => $dataExtraccion['fecha'],
                'hora' => $dataExtraccion['hora'],
                'motivo' => $dataExtraccion['motivo'],
                'conclusiones' => $dataExtraccion['conclusiones'],
                'fecha_hora_extraccion' => $dataExtraccion['fecha_hora_extraccion'],
                'fecha_hora_infraccion' => $dataExtraccion['fecha_hora_infraccion']
            ]);
        }

        $procedencia = Comisaria::where('procedencia', $dataExtraccion['procedencia'])->first();
        if($procedencia){
            $procedencia->update([
                'procedencia' => $dataExtraccion['procedencia']
            ]);
        }

        $persona = Persona::where('dni', $dataExtraccion['dni'])->first();
        if ($persona) {
            $persona->update([
                'nombre' => $dataExtraccion['nombre'],  
                'apellido_paterno' => $dataExtraccion['apellido_paterno'],  
                'apellido_materno' => $dataExtraccion['apellido_materno'], 
            ]);
        } 

        $intervenido = Intervenido::where('persona_id', $dataExtraccion['dni'])->first();
        if($intervenido){
            $intervenido->update([
                'edad'=>$dataExtraccion['edad'],
                'nacionalidad'=>$dataExtraccion['nacionalidad']
            ]);
        }

        $licencia = Licencia::where('intervenido_id', $dataExtraccion['dni'])->first();
        if($licencia){
            $licencia->update([
                'licencia' => $dataExtraccion['licencia'],
                'categoria' => $dataExtraccion['categoria'],
                'vehiculo' => $dataExtraccion['vehiculo'],
                'placa' => $dataExtraccion['placa'],
            ]);
        }

        $clase = Clase::where('clase', $dataExtraccion['clase'])->first();
        if($clase){
            $clase->update([
                'clase' => $dataExtraccion['clase'],
            ]);
        }

        return redirect()->route('tbl-certificados')->with('success', "Registro completado");
    }
}
