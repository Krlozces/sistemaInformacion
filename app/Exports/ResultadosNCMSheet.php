<?php

namespace App\Exports;

use App\Models\Registro;
use App\Models\Certificado;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultadosNCMSheet implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->resultadosNCM();
        return $data;
    }

    private function resultadosNCM(){
        return Registro::join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id')
        ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        ->select(
            DB::raw('DATE(registros.fecha_hora_extraccion) as dia'),
            DB::raw('SUM(CASE WHEN intervenidos.edad < 18 THEN 1 ELSE 0 END) as MENORES'),
            DB::raw('SUM(CASE WHEN muestras.resultado_cualitativo = "NEGACIÓN" THEN 1 ELSE 0 END) as NEGATIVA'),
            DB::raw('SUM(CASE WHEN muestras.resultado_cualitativo = "CONSTATACIÓN" THEN 1 ELSE 0 END) as CONSTATACION'),
            DB::raw('SUM(CASE WHEN muestras.resultado_cualitativo = "SUPLANTACIÓN" THEN 1 ELSE 0 END) as CONSTATACION'),
            DB::raw('
                SUM(CASE WHEN intervenidos.edad < 18 THEN 1 ELSE 0 END) +
                SUM(CASE WHEN muestras.resultado_cualitativo = "NEGACIÓN" THEN 1 ELSE 0 END) +
                SUM(CASE WHEN muestras.resultado_cualitativo = "CONSTATACIÓN" THEN 1 ELSE 0 END) +
                SUM(CASE WHEN muestras.resultado_cualitativo = "SUPLANTACIÓN" THEN 1 ELSE 0 END)
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
            ['USUARIOS SEGÚN NCM, DE LA UNIDAD DESCONCENTRADA DE DOSAJE ETILICO SEDE CHICLAYO, CORRESPONDIENTE AL MES DE '.$nombreMes.' '.$anio],
            ['N°', 'MENOR DE EDAD', 'NEGATIVA A PASAR', 'CONSTATACION', 'SUPLANTACION', 'TOTAL']
        ];
    }
}
