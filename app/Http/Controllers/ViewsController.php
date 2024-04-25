<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Personal;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade AS PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class ViewsController extends Controller
{
    public function confirmarPassword(){
        return view('comfirmarcontra');
    }

    public function ingresoDatos(){
        return view('ingresodedatos');
    }

    public function principal(){
        return view('principal');
    }

    public function home(){
        return view('home');
    }

    public function procesamiento($dni){
        // Realizar la consulta para obtener la persona con el DNI proporcionado
        $elementos = Persona::select('dni', 'nombre', 'apellido_paterno', 'apellido_materno', 'nacionalidad', 'edad', 'placa', 'vehiculo', 'clase', 'recepcion_doc_referencia', 'fecha_hora_infraccion', 'fecha', 'hora', 'fecha_hora_extraccion', 'motivo', 'procedencia', 'persona', 'muestras.observaciones', 'muestras.descripcion', 'licencia', 'categoria', 'resultado_cualitativo', 'resultado_cuantitativo', 'extractor', 'sexo', 'conclusiones')
        ->join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->join('licencias', 'intervenidos.id', '=', 'licencias.intervenido_id')
        ->join('clases', 'licencias.clase_id', '=', 'clases.id')
        ->join('registros', 'registros.intervenido_id', '=', 'intervenidos.id')
        ->join('comisarias', 'registros.comisaria_id', '=', 'comisarias.id')
        ->join('unidades', 'unidades.procedencia_id', '=', 'comisarias.id')
        ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        ->where('dni', $dni)
        ->get(); // Obtener solo el primer resultado
        
        $personalProcesamiento = Personal::where('area_perteneciente', 'areapro')
        ->with('Persona')
        ->get();

        $personalAreaExtra = Personal::where('area_perteneciente', 'areaextra')
        ->with('Persona')
        ->get();

        $camposCompletados = 24;

        Session::put('campos_completados', $camposCompletados);

        // Verificar si se encontraron resultados
        if ($elementos !== false) {
            // Se encontraron resultados, devolver la vista con los datos
            return view('procesamiento', compact('elementos', 'personalProcesamiento', 'personalAreaExtra'));
        } else {
            return redirect()->back()->with('error', 'No se encontró ninguna persona con el DNI proporcionado.');
        }
    }

    public function registrarte(){
        return view('registrarte');
    }

    public function extraccion(){
        $personalAreaExtra = Personal::where('area_perteneciente', 'areaextra')
        ->with('Persona')
        ->get();
        return view('extraccion', compact('personalAreaExtra'));
    }

    public function tblCertificados(){
        $elementos = Persona::join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->select('dni', 'nombre', 'apellido_paterno', 'apellido_materno')
        ->get();
        $camposCompletados = Session::get('campos_completados', 0);
        return view('tabla-certificados', compact('elementos', 'camposCompletados'));
    }

    public function generarPdf($dni){
        $elementos = Persona::select('dni', 'nombre', 'apellido_paterno', 'apellido_materno', 'nacionalidad', 'edad', 'placa', 'vehiculo', 'clase', 'recepcion_doc_referencia', 'fecha_hora_infraccion', 'fecha', 'hora', 'fecha_hora_extraccion', 'motivo', 'procedencia', 'persona', 'muestras.observaciones', 'muestras.descripcion AS description', 'licencia', 'categoria', 'resultado_cualitativo', 'resultado_cuantitativo', 'extractor', 'procesador', 'metodos.descripcion', 'sexo')
        ->join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->join('licencias', 'intervenidos.id', '=', 'licencias.intervenido_id')
        ->join('clases', 'licencias.clase_id', '=', 'clases.id')
        ->join('registros', 'registros.intervenido_id', '=', 'intervenidos.id')
        ->join('comisarias', 'registros.comisaria_id', '=', 'comisarias.id')
        ->join('unidades', 'unidades.procedencia_id', '=', 'comisarias.id')
        ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        ->join('metodos', 'muestras.metodo_id', '=', 'metodos.id')
        ->where('dni', $dni)
        ->first();

        $personalProcesamiento = Personal::join('personas', 'personas.id', '=', 'personal.persona_id')
            ->where('personal.persona_id', $elementos->procesador)
            ->first();
        
        $procesamiento = $personalProcesamiento->apellido_paterno . ' ' . $personalProcesamiento->apellido_materno . ', ' . $personalProcesamiento->nombre;

        $personalAreaExtra = Personal::join('personas', 'personas.id', '=', 'personal.persona_id')
            ->where('personal.persona_id', $elementos->extractor)
            ->first();
        $extraccion = $personalAreaExtra->apellido_paterno . ' ' . $personalAreaExtra->apellido_materno . ', ' . $personalAreaExtra->nombre;
        

        $pdf = FacadePdf::loadView('certificado', compact('elementos', 'personalProcesamiento', 'procesamiento', 'extraccion'));
        $pdf->setPaper('a4');
        $pdf->setOption(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        return $pdf->stream();
    }
}
