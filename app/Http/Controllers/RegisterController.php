<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
use App\Models\Certificado;
use App\Models\Intervenido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    public function register(Request $request){
        $incomingFields = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required', 'min:8']
        ]);
        $user = User::create($incomingFields);
        Role::create(['name' => 'admin']);
        $user->assignRole('admin');
        event(new Registered($user));
        return view('index')->with('success', '¡Registro exitoso!');
    }

    public function registerPersonal(Request $request){
        // Validación de campos entrantes
        $validatedData = $request->validate([
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
            'usuario' => ['required', 'email', 'unique:users,email'],
            'password' => ['required'],
            'imagen' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        DB::beginTransaction(); // Iniciar la transacción

        try {
            // Manejo de imagen
            if ($request->hasFile('imagen')) {
                $imagenNombre = $request->file('imagen')->store('imagenes_perfil', 'public');
                $validatedData['imagen_perfil'] = $imagenNombre;
            } else {
                $validatedData['imagen_perfil'] = null;
            }

            // Crear o encontrar certificado
            $certificado = Certificado::firstOrCreate(['certificado' => $request->certificado]);

            // Crear persona
            $persona = Persona::create($validatedData);

            // Crear o encontrar grado
            $grado = Grado::firstOrCreate(['grado' => $request->grado]);

            // Crear personal asociado a la persona
            $personal = new Personal([
                'genero' => $request->genero,
                'unidad_perteneciente' => $request->unidad_perteneciente,
                'area_perteneciente' => $request->area_perteneciente,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'usuario' => $request->usuario,
                'password' => bcrypt($request->password),
                'persona_id' => $persona->id,
                'grado_id' => $grado->id,
                'certificado_id' => $certificado->id,
            ]);

            // Guardar el personal
            $personal->save();

            // Crear usuario
            $usuario = User::create([
                'name' => $request->nombre,
                'email' => $request->usuario,
                'password' => bcrypt($request->password),
                'imagen_perfil' => $validatedData['imagen_perfil'],
            ]);

            // Asignar rol al usuario
            if ($request->area_perteneciente == 'areaextra') {
                Role::firstOrCreate(['name' => 'extractor']);
                $usuario->assignRole('extractor');
            } else {
                Role::firstOrCreate(['name' => 'procesador']);
                $usuario->assignRole('procesador');
            }

            DB::commit();

            return redirect()->back()->with('success', 'Registro exitoso!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Manejo de errores
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al registrar: ' . $e->getMessage()]);
        }
    }

    public function registerExtraccion(Request $request) {
        DB::beginTransaction();
    
        try {
            // Registrar al intervenido
            $registro = Persona::firstOrCreate($request->only(['dni', 'nombre', 'apellido_paterno', 'apellido_materno']));
    
            $extraccionData['persona_id'] = $registro->id;
            $extraccion = Extraccion::create($extraccionData);
    
            // Registrar intervenido
            $intervenidoData['persona_id'] = $registro->id;
            $intervenido = Intervenido::firstOrCreate(array_merge($request->only(['nacionalidad', 'edad', 'sexo']), $intervenidoData));
    
            // Registrar comisaria
            $comisaria = Comisaria::firstOrCreate(['procedencia' => $request->procedencia]);
    
            $unidadData['persona'] = $request->input('nombre_policial');
            $unidadData['procedencia_id'] = $comisaria->id;
            $unidad = Unidad::firstOrCreate($unidadData);
    
            // Registrar la clase
            $clase = Clase::firstOrCreate($request->only(['clase']));
    
            // Crear la licencia asociada con ese Intervenido
            $licencia = Licencia::firstOrCreate([
                'placa' => $request->placa,
                'vehiculo' => $request->vehiculo,
                'intervenido_id' => $intervenido->id, 
                'clase_id' => $clase->id,
                'licencia' => $request->licencia,
                'categoria' => $request->categoria,
            ]);
            
            $metodo = Metodo::firstOrCreate([
                'descripcion' => $request->descripcion
            ]);
            
            $muestraData['metodo_id'] = $metodo->id;
            
            // Obtener el valor de 'fecha_infraccion' desde la solicitud
            $fechaInfraccion = $request->input('fecha_infraccion');
            $horaInfraccion = $request->input('hora_infraccion');
            $tipoMuestra = $request->input('tipo_muestra');
            $otroTipoMuestra = $request->input('otro_tipo_muestra');
            if($tipoMuestra == 'otros'){
                $tipoMuestra = $otroTipoMuestra;
            }
            
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
                $request->only(['recepcion_doc_referencia', 'motivo', 'extractor', 'fecha', 'hora', 'numero_oficio']),
                $muestraData,
                $muestraId,
                $intervenidoId,
                $comisariaData,
                $extraccionId,
                ['fecha_hora_infraccion' => $infraccionData],
                ['fecha_hora_extraccion' => $timeExtraccion]
            ));
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Registro realizado con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Hubo un problema al registrar los datos: ' . $e->getMessage()]);
        }
    }

    public function registerProcesamiento(Request $request) {
        // Validación de campos de procesamiento
        $dataProcesamiento = $request->validate([
            'procesador' => ['required'],
            'resultado_cuantitativo' => ['required'],
            'incurso' => ['nullable', 'string']
        ]);
    
        // Extracción de datos adicionales
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
            'descripcion',
            'tipo_muestra',
            'resultado_cualitativo',
            'observaciones',
            'conclusiones',
            'otro_tipo_muestra'
        ]);
    
        DB::beginTransaction();
    
        try {

            $otroTipo = $dataExtraccion['otro_tipo_muestra'];
            // Actualización de registro existente
            $registro = Registro::where('recepcion_doc_referencia', $dataExtraccion['recepcion_doc_referencia'])->first();
            if ($registro) {
                $registro->update([
                    'procesador' => $dataProcesamiento['procesador'],
                    'incurso' => $dataProcesamiento['incurso'] ?? $registro->incurso,
                    'estado' => '1'
                ]);
    
                $muestra = $registro->muestra;
                if ($muestra) {
                    if(!empty($otroTipo)){
                        $dataExtraccion['descripcion'] = $otroTipo;
                    }
                    $muestra->update([
                        'resultado_cuantitativo' => $dataProcesamiento['resultado_cuantitativo'],
                        'descripcion' => $dataExtraccion['descripcion'],
                        'observaciones' => $dataExtraccion['observaciones'],
                        'resultado_cualitativo' => $dataExtraccion['resultado_cualitativo']
                    ]);
                }
            }
    
            // Actualización de comisaría
            $procedencia = Comisaria::where('procedencia', $dataExtraccion['procedencia'])->first();
            if ($procedencia) {
                $procedencia->update(['procedencia' => $dataExtraccion['procedencia']]);
            }
    
            // Actualización de persona
            $persona = Persona::where('dni', $dataExtraccion['dni'])
                    ->join('intervenidos', 'personas.id', '=', 'intervenidos.persona_id')
                    ->join('registros', 'registros.intervenido_id', '=', 'intervenidos.id')
                    ->where('recepcion_doc_referencia', $dataExtraccion['recepcion_doc_referencia'])
                    ->first();
            if ($persona) {
                $persona->update([
                    'nombre' => $dataExtraccion['nombre'],
                    'apellido_paterno' => $dataExtraccion['apellido_paterno'],
                    'apellido_materno' => $dataExtraccion['apellido_materno']
                ]);
    
                // Buscar intervenido usando el id de la persona
                $intervenido = $persona->intervenido;
                if ($intervenido) {
                    // Actualización de intervenido
                    $intervenido->update([
                        'edad' => $dataExtraccion['edad'],
                        'nacionalidad' => $dataExtraccion['nacionalidad']
                    ]);
    
                    // Actualización de otro registro por intervenido_id
                    $registroToUpdate = Registro::where('recepcion_doc_referencia', $dataExtraccion['recepcion_doc_referencia'])->first();
                    if ($registroToUpdate) {
                        $registroToUpdate->update([
                            // tal vez podría comentarlo ya que este valor es único
                            'recepcion_doc_referencia' => $dataExtraccion['recepcion_doc_referencia'],
                            'fecha' => $dataExtraccion['fecha'],
                            'hora' => $dataExtraccion['hora'],
                            'motivo' => $dataExtraccion['motivo'],
                            'conclusiones' => $dataExtraccion['conclusiones'],
                            'fecha_hora_extraccion' => $dataExtraccion['fecha_hora_extraccion'],
                            'fecha_hora_infraccion' => $dataExtraccion['fecha_hora_infraccion'],
                        ]);
                    }
    
                    // Actualización de licencia
                    $licencia = Licencia::where('intervenido_id', $intervenido->id)->first();
                    if ($licencia) {
                        $licencia->update([
                            'licencia' => $dataExtraccion['licencia'],
                            'categoria' => $dataExtraccion['categoria'],
                            'vehiculo' => $dataExtraccion['vehiculo'],
                            'placa' => $dataExtraccion['placa']
                        ]);
                    }
                }
            }
    
            // Actualización de clase
            $clase = Clase::where('clase', $dataExtraccion['clase'])->first();
            if ($clase) {
                $clase->update(['clase' => $dataExtraccion['clase']]);
            }

            DB::commit();
            
            return redirect()->route('tbl-certificados')->with('success', "Registro completado");
        } catch (\Exception $e) {
            DB::rollBack();
    
            return redirect()->back()->with(['error' => 'Ocurrió un error al registrar: ' . $e->getMessage()]);
        }
    }

    public function changeImage($id, Request $request){
        //validar que el archivo sea una imagen y no exceder los 2MB
        $incomingFields = $request->validate([
            'imagen' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            $imagenNombre = $request->file('imagen')->store('imagenes_perfil', 'public');
    
            $incomingFields['imagen_perfil'] = $imagenNombre;
        }

        $user = User::findOrFail($id);

        // Guardar la imagen
        // $imagePath = $request->file('imagen')->store('imagenes_perfil', 'public');

        $user->imagen_perfil = $incomingFields['imagen_perfil'];
        $user->save();

        return redirect()->back()->with('success', 'La foto de perfil se ha actualizado correctamente.');
    }
}
