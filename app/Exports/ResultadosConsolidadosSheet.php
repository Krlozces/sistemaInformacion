<?php

namespace App\Exports;

use App\Models\Muestra;
use App\Models\Certificado;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultadosConsolidadosSheet implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->resultadosConsolidados();
        return $data;
    }

    private function resultadosConsolidados(){
        return Muestra::join('registros', 'registros.muestra_id', '=', 'muestras.id')
            ->join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id')
            ->select(
                DB::raw('DATE(muestras.fecha_muestra) as dia'),
                DB::raw('SUM(CASE WHEN muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) as POSITIVO'),
                DB::raw('SUM(CASE WHEN (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "SIN MUESTRA") THEN 1 ELSE 0 END) as TSM'),
                DB::raw('SUM(CASE WHEN muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) as NEGATIVO'),
                DB::raw('
                SUM(CASE WHEN muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) +
                SUM(CASE WHEN muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) +
                SUM(CASE WHEN (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "SIN MUESTRA") THEN 1 ELSE 0 END)
                as TOTAL')
            )
            ->groupBy(DB::raw('DATE(muestras.fecha_muestra)'))
            ->get();
    }

    public function headings(): array
    {
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
        return [
            ['USUARIOS SEGÚN RESULTADOS, DE LA UNIDAD DESCONCENTRADA DE DOSAJE ETILICO SEDE CHICLAYO, CORRESPONDIENTE AL MES DE '.$nombreMes.' '.$anio],
            ['N°', 'POSITIVO', 'NEGATIVO', 'TSM', 'TOTAL']
        ];
    }
}
