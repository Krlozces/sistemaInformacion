<?php

namespace App\Http\Controllers;

use App\Exports\CertificadoExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CertifiedController extends Controller
{
    public function exportCertified($dni){
        // necesito que en el nombre salgo algo así FORMATO MESAÑO
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
        $nombreArchivo = 'FORMATO ' . $nombreMes . $anio . '.xlsx';
        return Excel::download(new CertificadoExport($dni), $nombreArchivo);
    }
}
