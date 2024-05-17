<?php

namespace App\Exports;

use App\Models\Registro;
use App\Models\Certificado;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultadosMotivosSheet implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->resultadosMotivos();
        return $data;
    }

    private function resultadosMotivos(){
        return Registro::select(
                DB::raw('DATE(registros.fecha_hora_extraccion) as dia'),
                DB::raw('SUM(CASE WHEN registros.motivo = "ACCIDENTE DE TRANSITO" THEN 1 ELSE 0 END) as AT'),
                DB::raw('SUM(CASE WHEN registros.motivo = "PRESUNCION DE EBRIEDAD" THEN 1 ELSE 0 END) as PE'),
                DB::raw('SUM(CASE WHEN registros.motivo != "PRESUNCION DE EBRIEDAD" AND registros.motivo != "ACCIDENTE DE TRANSITO" THEN 1 ELSE 0 END) as OTRO'),
                DB::raw('
                    SUM(CASE WHEN registros.motivo = "ACCIDENTE DE TRANSITO" THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN registros.motivo = "PRESUNCION DE EBRIEDAD" THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN registros.motivo != "PRESUNCION DE EBRIEDAD" AND registros.motivo != "ACCIDENTE DE TRANSITO" THEN 1 ELSE 0 END)
                as TOTAL')
            )
            ->groupBy(DB::raw('DATE(registros.fecha_hora_extraccion)'))
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
            ['USUARIOS SEGÚN MOTIVOS, DE LA UNIDAD DESCONCENTRADA DE DOSAJE ETILICO SEDE CHICLAYO, CORRESPONDIENTE AL MES DE '.$nombreMes.' '.$anio],
            ['N°', 'ACCIDENTE DE TRANSITO', 'PRESUNCION DE EBRIEDAD', 'OTRO', 'TOTAL']
        ];
    }
}
