<?php

namespace App\Exports;

use App\Models\Registro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Registro::all();
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
