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

        $elementos = Persona::select(
            'registros.id',
            DB::raw('DATE_FORMAT(CURDATE(), "%d/%m/%Y") as fecha_actual'),
            'numero_oficio',
            'procedencia',
            DB::raw('CONCAT(apellido_paterno, " ", apellido_materno, " ", nombre) as nombre_completo'),
            DB::raw('DATE(fecha_hora_infraccion) as fecha_infraccion'), 
            DB::raw('TIME(fecha_hora_infraccion) as hora_infraccion'), 
            DB::raw('DATE(fecha_hora_extraccion) as fecha_extraccion'), 
            DB::raw('TIME(fecha_hora_extraccion) as hora_extraccion'),
            DB::raw('TIMESTAMPDIFF(MINUTE, fecha_hora_infraccion, fecha_hora_extraccion) as tiempo_transcurrido_minutos'),
            'dni',
            'resultado_cuantitativo',
            'motivo', 
            'intervenidos.edad',
            'persona', 'procesador')
        ->join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->join('licencias', 'intervenidos.id', '=', 'licencias.intervenido_id')
        ->join('clases', 'licencias.clase_id', '=', 'clases.id')
        ->join('registros', 'registros.intervenido_id', '=', 'intervenidos.id')
        ->join('comisarias', 'registros.comisaria_id', '=', 'comisarias.id')
        ->join('unidades', 'unidades.procedencia_id', '=', 'comisarias.id')
        ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        ->join('metodos', 'muestras.metodo_id', '=', 'metodos.id')
        ->get();
        // $registro = Registro::select(
        //     'registros.id', 
        //     DB::raw('DATE_FORMAT(CURDATE(), "%d/%m/%Y") as fecha_actual'),
        //     'procedencia', 
        //     'registros.id', 
        //     'procedencia', 
        //     'procedencia',  
        //     DB::raw('DATE(fecha_hora_infraccion) as fecha_infraccion'), 
        //     DB::raw('TIME(fecha_hora_infraccion) as hora_infraccion'), 
        //     DB::raw('DATE(fecha_hora_extraccion) as fecha_extraccion'), 
        //     DB::raw('TIME(fecha_hora_extraccion) as hora_extraccion'),
        //     DB::raw('TIMESTAMPDIFF(MINUTE, fecha_hora_infraccion, fecha_hora_extraccion) as tiempo_transcurrido_minutos'),
        //     'muestras.resultado_cuantitativo', 
        //     'motivo', 
        //     'interveidos.edad'
        // )
        //     ->join('comisarias', 'comisarias.id', '=', 'registros.comisaria_id')
        //     ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        //     ->join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id')
        //     ->get();

        return $elementos;
    }

    public function headings(): array{
        return [
            'N°', // ready
            'FECHA', // ready
            'N° DE OFICIO', //ready
            'COMISARIA', // ready
            'APELLIDOS Y NOMBRES', // ready
            'FECHA DE INFRACCION', // ready
            'HORA DE INFRACCION', // ready
            'FECHA DE EXTRACCION', // ready
            'HORA DE EXTRACCION', // ready
            'TIEMPO TRANSCURRIDO', // ready
            'DNI', // ready
            'RESULTADO (G/L)', // ready
            'PROCESADOR',
            'COLEGIATURA PROCESADOR',
            'MOTIVO', // ready
            'EDAD', // ready
            'N° DE CERTIFICADO DD.EE'
        ];
    }
}
