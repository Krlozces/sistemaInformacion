<?php

namespace App\Exports;

use App\Models\Certificado;
use App\Models\Persona;
use Maatwebsite\Excel\Concerns\FromCollection;

class CertificadoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $dni;

    public function __construct($dni){
        $this->dni = $dni;
    }
    public function collection()
    {
        $elementos = Persona::select('dni', 'nombre', 'apellido_paterno', 'apellido_materno', 'nacionalidad', 'edad', 'placa', 'vehiculo', 'clase', 'recepcion_doc_referencia', 'fecha_hora_infraccion', 'fecha', 'hora', 'fecha_hora_extraccion', 'motivo', 'procedencia', 'persona', 'muestras.observaciones', 'muestras.descripcion AS description', 'licencia', 'categoria', 'resultado_cualitativo', 'resultado_cuantitativo', 'extractor', 'procesador', 'metodos.descripcion', 'sexo', 'incurso', 'numero_oficio', 'conclusiones')
        ->join('intervenidos', 'intervenidos.persona_id', '=', 'personas.id')
        ->join('licencias', 'intervenidos.id', '=', 'licencias.intervenido_id')
        ->join('clases', 'licencias.clase_id', '=', 'clases.id')
        ->join('registros', 'registros.intervenido_id', '=', 'intervenidos.id')
        ->join('comisarias', 'registros.comisaria_id', '=', 'comisarias.id')
        ->join('unidades', 'unidades.procedencia_id', '=', 'comisarias.id')
        ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        ->join('metodos', 'muestras.metodo_id', '=', 'metodos.id')
        ->where('dni', $this->dni)
        ->first();

        return $elementos;
    }
}
