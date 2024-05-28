<?php

namespace App\Exports;

use App\Models\Persona;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonalExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Persona::select('dni', 'nombre', 'apellido_paterno', 'apellido_materno', 'grado', 'telefono')
        ->join('personal', 'personas.id', '=', 'personal.persona_id')
        ->join('grados', 'personal.grado_id', '=', 'grados.id')
        ->get();
    }

    public function headings(): array{
        return [
            'DNI',
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Grado',
            'Teléfono',
        ];
    } 
}
