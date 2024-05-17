<?php

namespace App\Exports;

use App\Models\Muestra;
use App\Models\Registro;
use App\Models\Certificado;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProduccionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private function resultados(){
        $resultados = Muestra::join('registros', 'registros.muestra_id', '=', 'muestras.id')
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

        return $resultados;
    }

    private function resultadosConsolidados(){
        $resultadosConsolidados = Muestra::join('registros', 'registros.muestra_id', '=', 'muestras.id')
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

        return $resultadosConsolidados;
    }

    private function resultadosMotivos(){
        $resultadosMotivos = Registro::select(
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

        return $resultadosMotivos;
    }

    public function collection()
    {
        $elements = Muestra::select()->get();
        return Certificado::all();
    }
}
