<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\Grado;
use App\Models\Muestra;
use App\Models\Persona;
use App\Models\Personal;
use App\Models\Registro;
use App\Models\Comisaria;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade AS PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

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

    public function listUsers(){
        $elements = Persona::select('dni', 'nombre', 'apellido_paterno', 'apellido_materno', 'grado', 'telefono', 'grados.id', 'personal.usuario', 'area_perteneciente')
        ->join('personal', 'personas.id', '=', 'personal.persona_id')
        ->join('grados', 'personal.grado_id', '=', 'grados.id')
        ->get();

        $grado = Personal::select('grado')
                ->join('grados', 'grados.id', '=', 'personal.grado_id')
                ->where('usuario', Auth::user()->email)
                ->first();

        $grades = Grado::all();

        return view('gestionarUsuarios', compact('elements', 'grado', 'grades'));
    }   

    public function home(){
        $data = Muestra::join('registros', 'muestras.id', '=', 'registros.muestra_id')
        ->join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id' )
        ->where('muestras.resultado_cualitativo', 'positivo')
        ->whereDate('muestras.created_at', '>=', Carbon::now()->subDays(30))
        ->select('fecha_muestra')
        ->get()
        ->groupBy(function ($item) {
            // Agrupar por día
            return Carbon::parse($item->fecha_muestra)->format('Y-m-d');
        });

        $fecha = \Carbon\Carbon::now();
        $numeroMes = $fecha->format('m');
        $nombresMeses = [
            '01' => 'ENERO',
            '02' => 'FEBRERO',
            '03' => 'MARZO',
            '04' => 'ABRIL',
            '05' => 'MAYO',
            '06' => 'JUNIO',
            '07' => 'JULIO',
            '08' => 'AGOSTO',
            '09' => 'SEPTIEMBRE',
            '10' => 'OCTUBRE',
            '11' => 'NOVIEMBRE',
            '12' => 'DICIEMBRE',
        ];
        $nombreMes = $nombresMeses[$numeroMes];
        $anio = $fecha->format('Y');

        $labels = [];
        $values = [];

        foreach ($data as $date => $entries) {
            $labels[] = $date;
            $values[] = count($entries);
        }
        if (count($labels) === 1) {
            $labels[] = Carbon::parse($labels[0])->addDay()->format('Y-m-d');
            $values[] = 0;
        }

        $chartData = [
            'labels' => $labels,
            'values' => $values
        ];

        $chartDataJson = json_encode($chartData);

        $grado = Personal::select('grado')
                ->join('grados', 'grados.id', '=', 'personal.grado_id')
                ->where('usuario', Auth::user()->email)
                ->first();

        return view('home', compact('grado', 'chartDataJson', 'nombreMes', 'anio'));
    }

    public function segunEdad(){
        // polar area charts
        $data = Muestra::join('registros', 'muestras.id', '=', 'registros.muestra_id')
        ->join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id' )
        ->whereDate('muestras.created_at', '>=', Carbon::now()->subDays(30))
        ->select('intervenidos.edad')
        ->get()
        ->groupBy(function ($item) {
            // Agrupar por rangos de edad
            $edad = $item->edad;
            if ($edad <= 10) {
                return '0-10';
            } elseif ($edad <= 20) {
                return '11-20';
            } elseif ($edad <= 30) {
                return '21-30';
            } elseif ($edad <= 40) {
                return '31-40';
            } elseif ($edad <= 50) {
                return '41-50';
            } elseif ($edad <= 60) {
                return '51-60';
            } elseif ($edad <= 70) {
                return '61-70';
            } else {
                return '71+';
            }
        });

        $yearLabels = [];
        $yearValues = [];
        
        foreach ($data as $range => $entries) {
            $yearLabels[] = $range;
            $yearValues[] = count($entries);
        }

        return response()->json([
            'type' => 'polarArea',
            'yearLabels' => $yearLabels,
            'yearValues' => $yearValues
        ]);
    }

    public function segunResultados(){
        // gráfico circular
        $data = Muestra::join('registros', 'muestras.id', '=', 'registros.muestra_id')
        ->join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id' )
        ->whereDate('muestras.created_at', '>=', Carbon::now()->subDays(30))
        ->select('muestras.resultado_cualitativo')
        ->get()
        ->groupBy('resultado_cualitativo');

        $resultsLabels = [];
        $resultsValues = [];

        foreach ($data as $resultado => $entries) {
            $resultsLabels[] = $resultado;
            $resultsValues[] = count($entries);
        }     

        return response()->json([
            'type' => 'doughnut',
            'resultsLabels' => $resultsLabels,
            'resultsValues' => $resultsValues
        ]);
    }

    public function segunMotivos(){
        // gráfico lineal
        $data = Muestra::join('registros', 'muestras.id', '=', 'registros.muestra_id')
        ->join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id' )
        ->whereDate('muestras.created_at', '>=', Carbon::now()->subDays(30))
        ->select('registros.motivo')
        ->get()
        ->groupBy('motivo');
        $motivosLabels = [];
        $motivosValues = [];

        foreach ($data as $motivo => $entries) {
            $motivosLabels[] = $motivo;
            $motivosValues[] = count($entries);
        }
        
        return response()->json([
            'type' => 'line',
            'motivosLabels' => $motivosLabels,
            'motivosValues' => $motivosValues
        ]);
    }

    public function procesamiento($dni){
        // Realizar la consulta para obtener la persona con el DNI proporcionado
        $elementos = Persona::select('dni', 'nombre', 'apellido_paterno', 'apellido_materno', 'nacionalidad', 'edad', 'placa', 'vehiculo', 'clase', 'recepcion_doc_referencia', 'fecha_hora_infraccion', 'fecha', 'hora', 'fecha_hora_extraccion', 'motivo', 'procedencia', 'persona', 'muestras.observaciones', 'muestras.descripcion', 'licencia', 'categoria', 'resultado_cualitativo', 'resultado_cuantitativo', 'extractor', 'sexo', 'conclusiones', 'incurso', 'procesador')
        ->join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->join('licencias', 'intervenidos.id', '=', 'licencias.intervenido_id')
        ->join('clases', 'licencias.clase_id', '=', 'clases.id')
        ->join('registros', 'registros.intervenido_id', '=', 'intervenidos.id')
        ->join('comisarias', 'registros.comisaria_id', '=', 'comisarias.id')
        ->join('unidades', 'unidades.procedencia_id', '=', 'comisarias.id')
        ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        ->where('recepcion_doc_referencia', $dni)
        ->first(); // Obtener solo el primer resultado
        
        $personalProcesamiento = Personal::where('area_perteneciente', 'areapro')->get();

        $personalAreaExtra = Personal::where('area_perteneciente', 'areaextra')->get();

        $camposCompletados = 24;

        Session::put('campos_completados', $camposCompletados);

        $grado = Personal::select('grado')
                ->join('grados', 'grados.id', '=', 'personal.grado_id')
                ->where('usuario', Auth::user()->email)
                ->first();

        // Verificar si se encontraron resultados
        if ($elementos) {
            $elementos = $elementos ? [$elementos] : [];
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
        ->with('Grado')
        ->get();
        $grado = Personal::select('grado')
                ->join('grados', 'grados.id', '=', 'personal.grado_id')
                ->where('usuario', Auth::user()->email)
                ->first();
        $ultimoCodigo = Registro::max('numero_oficio');
        $nuevoCodigo = ($ultimoCodigo !== null) ? $ultimoCodigo + 1 : 629;
        return view('extraccion', compact('personalAreaExtra', 'grado', 'nuevoCodigo'));
    }

    public function tblCertificados(){
        $elementos = Persona::join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->join('registros', 'registros.intervenido_id', '=', 'intervenidos.id')
        ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        ->select('dni', 'nombre', 'apellido_paterno', 'apellido_materno', 'muestras.updated_at', 'registros.estado', 'registros.recepcion_doc_referencia')
        ->simplePaginate(10);
        $camposCompletados = Session::get('campos_completados', 0);
        $grado = Personal::select('grado')
                ->join('grados', 'grados.id', '=', 'personal.grado_id')
                ->where('usuario', Auth::user()->email)
                ->first();
        return view('tabla-certificados', compact('elementos', 'camposCompletados', 'grado'));
    }

    public function generarPdf($dni){
        $elementos = Persona::select('dni', 'nombre', 'apellido_paterno', 'apellido_materno', 'nacionalidad', 'edad', 'placa', 'vehiculo', 'clase', 'recepcion_doc_referencia', 'fecha_hora_infraccion', 'fecha', 'hora', 'fecha_hora_extraccion', 'motivo', 'procedencia', 'persona', 'muestras.observaciones', 'muestras.descripcion AS description', 'licencia', 'categoria', 'resultado_cualitativo', 'resultado_cuantitativo', 'extractor', 'procesador', 'metodos.descripcion', 'sexo', 'incurso', 'numero_oficio', 'conclusiones')
        ->join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->join('licencias', 'intervenidos.id', '=', 'licencias.intervenido_id')
        ->join('clases', 'licencias.clase_id', '=', 'clases.id')
        ->join('registros', 'registros.intervenido_id', '=', 'intervenidos.id')
        ->join('comisarias', 'registros.comisaria_id', '=', 'comisarias.id')
        ->join('unidades', 'unidades.procedencia_id', '=', 'comisarias.id')
        ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        ->join('metodos', 'muestras.metodo_id', '=', 'metodos.id')
        ->where('recepcion_doc_referencia', $dni)
        ->first();

        $personalProcesamiento = Personal::join('personas', 'personas.id', '=', 'personal.persona_id')
            ->where('personal.persona_id', $elementos->procesador)
            ->first();
        
        $procesamiento = $personalProcesamiento->apellido_paterno . ' ' . $personalProcesamiento->apellido_materno . ', ' . $personalProcesamiento->nombre;

        $personalAreaExtra = Personal::join('personas', 'personas.id', '=', 'personal.persona_id')
            ->where('personal.persona_id', $elementos->extractor)
            ->first();
        $extraccion = $personalAreaExtra->apellido_paterno . ' ' . $personalAreaExtra->apellido_materno . ', ' . $personalAreaExtra->nombre;

        $elementos->resultado_cuantitativo = number_format($elementos->resultado_cuantitativo, 2, '.', '');
        $resultadoCuantitativoLetras = $this->convertirResultadoALetras($elementos->resultado_cuantitativo);

        $contieneAlcohol = $elementos->resultado_cuantitativo > 0.00 ? "LA MUESTRA CONTIENE ALCOHOL ETILICO" : "LA MUESTRA NO CONTIENE ALCOHOL ETILICO";

        $pdf = FacadePdf::loadView('certificado', compact('elementos', 'personalProcesamiento', 'procesamiento', 'extraccion', 'resultadoCuantitativoLetras', 'contieneAlcohol'));
        $pdf->setPaper('a4');
        $pdf->setOption(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        return $pdf->stream();
    }

    private function convertirResultadoALetras($resultadoNumerico) {
        $parteEntera = floor($resultadoNumerico);
        $parteDecimal = round(($resultadoNumerico - $parteEntera) * 100);
    
        $parteEnteraEnPalabras = $this->convertirEnteroALetras($parteEntera);
        $parteDecimalEnPalabras = $this->convertirDecimalALetras($parteDecimal);
    
        return ucfirst($parteEnteraEnPalabras . " " . ($parteEntera == 1 ? "GRAMO" : "GRAMOS") . " " . $parteDecimalEnPalabras . " DE ALCOHOL POR LITRO DE SANGRE");
    }
    
    private function convertirEnteroALetras($num) {
        $unidades = ["CERO", "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE"];
        $decenas = ["DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISÉIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE"];
        $decenas2 = ["VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SETENTA", "OCHENTA", "NOVENTA"];
    
        if ($num < 10) {
            return $unidades[$num];
        } else if ($num < 20) {
            return $decenas[$num - 10];
        } else if ($num < 100) {
            $unidad = $num % 10;
            $decena = floor($num / 10);
            if ($unidad == 0) {
                return $decenas2[($decena - 2)];
            } else {
                return $decenas2[($decena - 2)] . ' Y ' . $unidades[$unidad];
            }
        } else {
            return (string) $num; // Para casos no contemplados en el rango
        }
    }
    
    private function convertirDecimalALetras($num) {
        if ($num == 0) {
            return 'CERO CERO CENTIGRAMOS';
        }
    
        $unidades = ['CERO', 'UNO', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
        $decenas = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISÉIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
        $decenas2 = ['VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
    
        if ($num < 10) {
            return 'CERO ' . $unidades[$num] . ' CENTIGRAMOS';
        } else if ($num < 20) {
            return $decenas[$num - 10] . ' CENTIGRAMOS';
        } else if ($num < 100) {
            $decena = floor($num / 10);
            $unidad = $num % 10;
            if ($unidad == 0) {
                return $decenas2[$decena - 2] . ' CENTIGRAMOS';
            } else {
                return $decenas2[$decena - 2] . ' Y ' . $unidades[$unidad] . ' CENTIGRAMOS';
            }
        } else {
            return (string) $num . ' CENTIGRAMOS'; // Para casos no contemplados en el rango
        }
    }

    public function obtenerComisarias(){
        $comisarias = Comisaria::select('procedencia')->get();
        return response()->json($comisarias);
    }
}
