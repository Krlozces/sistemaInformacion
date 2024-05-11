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
        $elementos = Registro::select(
            'registros.id',
            DB::raw('DATE_FORMAT(CURDATE(), "%d/%m/%Y") as fecha_actual'),
            'recepcion_doc_referencia',
            'numero_oficio',
            'procedencia',
            DB::raw('CONCAT(personas.apellido_paterno, " ", personas.apellido_materno, " ", personas.nombre) as nombre_completo'),
            DB::raw('DATE(registros.fecha_hora_infraccion) as fecha_infraccion'),
            DB::raw('TIME(registros.fecha_hora_infraccion) as hora_infraccion'),
            DB::raw('DATE(registros.fecha_hora_extraccion) as fecha_extraccion'),
            DB::raw('TIME(registros.fecha_hora_extraccion) as hora_extraccion'),
            DB::raw('TIMESTAMPDIFF(MINUTE, registros.fecha_hora_infraccion, registros.fecha_hora_extraccion) as tiempo_transcurrido_minutos'),
            'personas.dni',
            DB::raw('CAST(muestras.resultado_cuantitativo AS DECIMAL(10,2)) AS resultado_cuantitativo'),
            // CAST(muestras.resultado_cuantitativo AS DECIMAL(10,2)) AS resultado_cuantitativo
            // 'muestras.resultado_cuantitativo',
            DB::raw('CONCAT(pro.apellido_paterno, " ", pro.apellido_materno, " ", pro.nombre) as nombre_procesador'),
            'certificados.certificado',
            'registros.motivo',
            'intervenidos.edad',
            DB::raw('CONCAT(numero_oficio, "-", recepcion_doc_referencia) as certificado_ddee'),
        )
        ->join('intervenidos', 'registros.intervenido_id', '=', 'intervenidos.id')
        ->join('personas', 'intervenidos.persona_id', '=', 'personas.id')
        ->join('licencias', 'intervenidos.id', '=', 'licencias.intervenido_id')
        ->join('clases', 'licencias.clase_id', '=', 'clases.id')
        ->join('comisarias', 'registros.comisaria_id', '=', 'comisarias.id')
        ->join('unidades', 'unidades.procedencia_id', '=', 'comisarias.id')
        ->join('muestras', 'registros.muestra_id', '=', 'muestras.id')
        ->join('metodos', 'muestras.metodo_id', '=', 'metodos.id')
        ->join('personal', 'personal.id', '=', 'registros.procesador')
        ->join('certificados', 'certificados.id', '=', 'personal.certificado_id')
        ->join('personas as pro', 'personal.persona_id', '=', 'pro.id')
        ->where('personal.area_perteneciente', 'areapro')
        ->get();

        return $elementos;
    }

    public function headings(): array{
        return [
            'N°',
            'FECHA',
            'REGISTRO',
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
