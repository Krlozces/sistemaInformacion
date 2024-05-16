<?php

namespace App\Exports;

use stdClass;
use App\Models\Persona;
use App\Models\Personal;
use App\Models\Certificado;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CertificadoExport implements FromCollection, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $dni;

    public function __construct($dni){
        $this->dni = $dni;
    }

    private function convertirResultadoALetras($resultadoNumerico){
        $unidades = ["CERO", "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE", "DIES",
                    "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "dieciséis", "DIECISIETE", "DIECIOCHO", "DIECINUEVE"];

        $decenas = ["", "", "VEINTE", "TREINTA", "CUARENTA", "CINCUENTA", "SESENTA", "SESENTA", "OCHENTA", "NOVENTA"];

        $centesimas = ["", "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE"];

        $parteEntera = floor($resultadoNumerico);
        $parteDecimal = round(($resultadoNumerico - $parteEntera) * 100);

        $parteEnteraEnPalabras = $unidades[$parteEntera];

        $parteDecimalEnPalabras = "";
        if ($parteDecimal > 0) {
            if ($parteDecimal < 20) {
                $parteDecimalEnPalabras = $unidades[$parteDecimal];
            } else {
                $decena = floor($parteDecimal / 10);
                $unidad = $parteDecimal % 10;
                $parteDecimalEnPalabras = $decenas[$decena];
                if ($unidad > 0) {
                    $parteDecimalEnPalabras .= " Y " . $centesimas[$unidad];
                }
            }
        }

        return ucfirst($parteEnteraEnPalabras . " GRAMOS " . $parteDecimalEnPalabras . " CENTIGRAMOS DE ALCOHOL POR LITRO DE SANGRE");
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

        $personalProcesamiento = Personal::join('personas', 'personas.id', '=', 'personal.persona_id')
            ->where('personal.persona_id', $elementos->procesador)
            ->first();
        
        $procesamiento = $personalProcesamiento->apellido_paterno . ' ' . $personalProcesamiento->apellido_materno . ', ' . $personalProcesamiento->nombre;

        $personalAreaExtra = Personal::join('personas', 'personas.id', '=', 'personal.persona_id')
            ->where('personal.persona_id', $elementos->extractor)
            ->first();
        $extraccion = $personalAreaExtra->apellido_paterno . ' ' . $personalAreaExtra->apellido_materno . ', ' . $personalAreaExtra->nombre;

        $resultadoCuantitativoLetras = $this->convertirResultadoALetras($elementos->resultado_cuantitativo);

        $contieneAlcohol = $resultadoCuantitativoLetras > 0.00 ? "LA MUESTRA CONTIENE ALCOHOL ETILICO" : "LA MUESTRA NO CONTIENE ALCOHOL ETILICO";

        $data = collect([
            ['Numero de Oficio' => $elementos->numero_oficio . ' - ' . date('Y', strtotime($elementos->fecha_hora_infraccion))],
            ['Apellido Paterno' => $elementos->apellido_paterno . ' ' . $elementos->apellido_materno . ' ' . $elementos->nombre],
            ['Edad' => $elementos->edad],
            ['Sexo' => $elementos->sexo],
            ['DNI' => $elementos->dni],
            ['Licencia' => $elementos->licencia],
            ['Clase' => $elementos->clase],
            ['Vehiculo' => $elementos->vehiculo],
            ['Placa' => $elementos->placa],
            ['Procedencia' => $elementos->procedencia],
            ['Recepcion Doc Referencia' => $elementos->recepcion_doc_referencia],
            ['Fecha Hora Infraccion' => date('H:i', strtotime($elementos->fecha_hora_infraccion)) . ' HRS ' . date('d/m/Y', strtotime($elementos->fecha_hora_infraccion))],
            ['Motivo' => $elementos->motivo],
            ['Persona' => $elementos->persona],
            ['Fecha Hora Extraccion' => date('H:i', strtotime($elementos->fecha_hora_extraccion)) . ' HRS ' . date('d/m/Y', strtotime($elementos->fecha_hora_extraccion))],
            ['Extraccion' => $extraccion],
            ['Description' => $elementos->description],
            ['Descripcion' => $elementos->descripcion],
            ['Procesamiento' => $procesamiento],
            ['Grado' => isset($personalProcesamiento->grado->grado) ? $personalProcesamiento->grado->grado : ''],
            ['DNI Procesamiento' => isset($personalProcesamiento->persona->dni) ? $personalProcesamiento->persona->dni : ''],
            ['Observaciones' => $elementos->observaciones],
            ['Resultado Cuantitativo' => $elementos->resultado_cuantitativo . ' g/L'],
            ['Resultado Cuantitativo Letras' => $resultadoCuantitativoLetras],
            ['Contiene Alcohol' => $contieneAlcohol],
            ['Conclusiones' => $elementos->conclusiones], 
        ]);

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        // Ajustar el espaciado y el estilo
        $sheet->getDefaultColumnDimension()->setWidth(30);
        $sheet->getDefaultRowDimension()->setRowHeight(20);

        // Estilo para la primera fila (encabezados)
        $sheet->getStyle('A1:B1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
        ]);

        return [
            'B' => ['font' => ['bold' => true]],
        ];
    }

}
