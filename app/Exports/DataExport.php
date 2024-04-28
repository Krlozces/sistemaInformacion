<?php

namespace App\Exports;

use App\Models\Persona;
use App\Models\Personal;
use App\Models\Registro;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DataExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $personalProcesamiento = Personal::where('area_perteneciente', 'areapro')
        ->with('Persona')
        ->get();

        $elementos = Persona::join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->select('dni', 'nombre', 'apellido_paterno', 'apellido_materno')
        ->get();

        $registro = Registro::select('registros.id', 'procedencia', 'registros.id', 'procedencia', 'procedencia', 
        DB::raw('DATE(fecha_hora_infraccion) as fecha_infraccion'), 
        DB::raw('TIME(fecha_hora_infraccion) as hora_infraccion'), 
        DB::raw('DATE(fecha_hora_extraccion) as fecha_extraccion'), 
        DB::raw('TIME(fecha_hora_extraccion) as hora_extraccion'),
        DB::raw('TIMESTAMPDIFF(MINUTE, fecha_hora_infraccion, fecha_hora_extraccion) as tiempo_transcurrido_minutos'),
        'resultado_cuantitativo', 'motivo', 'edad')
            ->join('comisarias', 'comisarias.id', '=', 'registros.comisaria_id')
            ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
            ->join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id')
            ->get();

        return $registro->merge($elementos);
    }

    public function headings(): array{
        return [
            'N°',
            'FECHA',
            'N° DE OFICIO',
            'COMISARIA',
            'APELLIDOS Y NOMBRES',
            'FECHA DE INFRACCION',
            'HORA DE INFRACCION',
            'FECHA DE EXTRACCION',
            'HORA DE EXTRACCION',
            'TIEMPO TRANSCURRIDO',
            'DNI',
            'RESULTADO (G/L)',
            'PROCESADOR',
            'COLEGIATURA PROCESADOR',
            'MOTIVO',
            'EDAD',
            'N° DE CERTIFICADO DD.EE'
        ];
    }
}
