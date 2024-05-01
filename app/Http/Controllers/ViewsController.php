<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Personal;
use App\Models\Registro;
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
        $grado = Personal::select('grado')
                ->join('grados', 'grados.id', '=', 'personal.grado_id')
                ->where('usuario', Auth::user()->email)
                ->first();
        return view('principal', compact('grado'));
    }

    public function home(){
        $grado = Personal::select('grado')
                ->join('grados', 'grados.id', '=', 'personal.grado_id')
                ->where('usuario', Auth::user()->email)
                ->first();
        return view('home', compact('grado'));
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

        $grado = Personal::select('grado')
                ->where('usuario', Auth::user()->email)
                ->first();

        // Verificar si se encontraron resultados
        if ($elementos !== false) {
            // Se encontraron resultados, devolver la vista con los datos
            return view('procesamiento', compact('elementos', 'personalProcesamiento', 'personalAreaExtra', 'grado'));
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
        $ultimoContador = 1;
        $grado = Personal::select('grado')
                ->join('grados', 'grados.id', '=', 'personal.grado_id')
                ->where('usuario', Auth::user()->email)
                ->first();
        $codigo = Registro::select('numero_oficio')->first();
        $codigo++;

        return view('extraccion', compact('personalAreaExtra', 'ultimoContador', 'grado', 'codigo'));
    }

    public function tblCertificados(){
        $elementos = Persona::join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->select('dni', 'nombre', 'apellido_paterno', 'apellido_materno')
        ->get();
        $camposCompletados = Session::get('campos_completados', 0);
        $grado = Personal::select('grado')
                ->where('usuario', Auth::user()->email)
                ->first();
        return view('tabla-certificados', compact('elementos', 'camposCompletados', 'grado'));
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

        $resultadoCuantitativoLetras = $this->convertirResultadoALetras($elementos->resultado_cuantitativo);

        $contieneAlcohol = $resultadoCuantitativoLetras > 0.00 ? "LA MUESTRA CONTIENE ALCOHOL ETILICO" : "LA MUESTRA NO CONTIENE ALCOHOL ETILICO";

        $pdf = FacadePdf::loadView('certificado', compact('elementos', 'personalProcesamiento', 'procesamiento', 'extraccion', 'resultadoCuantitativoLetras', 'contieneAlcohol'));
        $pdf->setPaper('a4');
        $pdf->setOption(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        return $pdf->stream();
    }

    private function convertirResultadoALetras($resultadoNumerico){
        $unidades = ["CERO", "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE", "DIES",
                    "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "dieciséis", "DIECISIETE", "DIECIOCHO", "DIECINUEVE"];

        $decenas = ["", "", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SESENTA", "OCHENTA", "NOVENTA"];

        $centesimas = ["", "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE"];

        $parteEntera = floor($resultadoNumerico);
        $parteDecimal = round(($resultadoNumerico - $parteEntera) * 100);

        $parteEnteraEnPalabras = $unidades[$parteEntera];

        $parteDecimalEnPalabras = "";
        if ($parteDecimal > 0) {
            if ($parteDecimal < 20) {
                $parteDecimalEnPalabras = $unidades[$parteDecimal];
            } else {
                $decena = floor($parteDecimal / 10);
                $unidad = $parteDecimal % 10;
                $parteDecimalEnPalabras = $decenas[$decena];
                if ($unidad > 0) {
                    $parteDecimalEnPalabras .= " Y " . $centesimas[$unidad];
                }
            }
        }

        return ucfirst($parteEnteraEnPalabras . " GRAMOS " . $parteDecimalEnPalabras . " CENTIGRAMOS DE ALCOHOL POR LITRO DE SANGRE");
    }
}
