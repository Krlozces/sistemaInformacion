<?php

namespace App\Exports;

use App\Models\Muestra;
use App\Models\Registro;
use App\Models\Certificado;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProduccionExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        $data = $this->resultados();
        return $data;
    }

    private function resultados(){
        return Muestra::join('registros', 'registros.muestra_id', '=', 'muestras.id')
            ->join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id')
            ->select(
                DB::raw('DATE(muestras.fecha_muestra) as dia'),
                DB::raw('SUM(CASE WHEN intervenidos.sexo = "M" AND muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) as positivos_masculinos'),
                DB::raw('SUM(CASE WHEN intervenidos.sexo = "M" AND muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) as negativos_masculinos'),
                DB::raw('SUM(CASE WHEN intervenidos.sexo = "M" AND (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "SIN MUESTRA") THEN 1 ELSE 0 END) as sin_muestra_masculinos'),
                DB::raw('SUM(CASE WHEN intervenidos.sexo = "F" AND muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) as positivos_femeninos'),
                DB::raw('SUM(CASE WHEN intervenidos.sexo = "F" AND muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) as negativos_femeninos'),
                DB::raw('SUM(CASE WHEN intervenidos.sexo = "F" AND (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "SIN MUESTRA") THEN 1 ELSE 0 END) as sin_muestra_femeninos'),
                DB::raw('
                    SUM(CASE WHEN intervenidos.sexo = "M" AND muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN intervenidos.sexo = "M" AND muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN intervenidos.sexo = "M" AND (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "SIN MUESTRA") THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN intervenidos.sexo = "F" AND muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN intervenidos.sexo = "F" AND muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN intervenidos.sexo = "F" AND (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "SIN MUESTRA") THEN 1 ELSE 0 END) 
                as total')
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
            ['USUARIOS SEGÚN SEXO, DE LA UNIDAD DESCONCENTRADA DE DOSAJE ETILICO SEDE CHICLAYO, CORRESPONDIENTE AL MES DE '.$nombreMes.' '.$anio],
            ['N°', 'MASCULINO', '', 'FEMENINO', '', 'TALONARIO SIN MUESTRA', '', 'TOTAL'],
            ['', 'POSITIVO', 'NEGATIVO', 'POSITIVO', 'NEGATIVO', 'MASCULINO', 'FEMENINO']
        ];
    }

    public function title(): string
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
        return $nombreMes . ' ' . $anio;
    }
}
