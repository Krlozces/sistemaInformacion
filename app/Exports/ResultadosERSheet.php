<?php

namespace App\Exports;

use App\Models\Registro;
use App\Models\Certificado;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultadosERSheet implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->resultadosER();
        return $data;
    }

    private function resultadosER(){
        return Registro::select(
            DB::raw('DATE(registros.fecha_hora_extraccion) as dia'),
            DB::raw('SUM(CASE WHEN registros.recepcion_doc_referencia NOT LIKE "C%" THEN 1 ELSE 0 END) as EXTRAIDAS'),
            DB::raw('SUM(CASE WHEN registros.recepcion_doc_referencia LIKE "C%" THEN 1 ELSE 0 END) as REMITIDAS'),
            DB::raw('
                SUM(CASE WHEN registros.recepcion_doc_referencia NOT LIKE "C%" THEN 1 ELSE 0 END) +
                SUM(CASE WHEN registros.recepcion_doc_referencia LIKE "C%" THEN 1 ELSE 0 END)
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
            ['USUARIOS SEGÚN ESTADO, DE LA UNIDAD DESCONCENTRADA DE DOSAJE ETILICO SEDE CHICLAYO, CORRESPONDIENTE AL MES DE '.$nombreMes.' '.$anio],
            ['N°', 'EXTRAIDAS', 'REMITIDAS', 'TOTAL']
        ];
    }
}
