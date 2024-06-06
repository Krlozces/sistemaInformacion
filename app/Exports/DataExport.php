<?php

namespace App\Exports;

use App\Models\Persona;
use App\Models\Personal;
use App\Models\Registro;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataExport implements FromCollection, WithHeadings, WithStyles
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
            DB::raw('DATE_FORMAT(registros.fecha_hora_infraccion, "%d/%m/%Y") as fecha_infraccion'),
            DB::raw('DATE_FORMAT(registros.fecha_hora_infraccion, "%H:%i") as hora_infraccion'),
            DB::raw('DATE_FORMAT(registros.fecha_hora_extraccion, "%d/%m/%Y") as fecha_extraccion'),
            DB::raw('DATE_FORMAT(registros.fecha_hora_extraccion, "%H:%i") as hora_extraccion'),
            DB::raw('TIME_FORMAT(
                SEC_TO_TIME(
                    TIMESTAMPDIFF(MINUTE, registros.fecha_hora_infraccion, registros.fecha_hora_extraccion) * 60
                ),
                "%H:%i"
            ) as tiempo_transcurrido_minutos'),
            'personas.dni',
            DB::raw('CAST(muestras.resultado_cuantitativo AS DECIMAL(10,2)) AS resultado_cuantitativo'),
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
        ->distinct()
        ->get();

        // Iterar sobre los elementos y reemplazar los valores de motivo según la abreviatura
        foreach ($elementos as $elemento) {
            switch ($elemento->motivo) {
                case 'PELIGRO COMUN':
                    $elemento->motivo = 'PC';
                    break;
                case 'ACCIDENTE DE TRANSITO':
                    $elemento->motivo = 'AT';
                    break;
                default:
                    break;
            }
        }

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

    public function styles(Worksheet $sheet)
    {
        // Aplicar wrapText a la celda para que interprete el salto de línea
        $sheet->getStyle('A1:R1')->getAlignment()->setWrapText(true);

        // Establecer estilos de alineación centrada para la fila 1
        $sheet->getStyle('A1:R1')->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);


        // Obtener el rango de celdas en la columna C (desde C2 hasta el final de la hoja)
        $lastRow = $sheet->getHighestRow();
        $range = 'C2:C' . $lastRow;

        $lastRow = $sheet->getHighestRow();
        $range1 = 'L2:L' . $lastRow;

        $lastRow = $sheet->getHighestRow();
        $range2 = 'M2:M' . $lastRow;

        $lastRow = $sheet->getHighestRow();
        $range3 = 'Q2:Q' . $lastRow;

        $lastRow = $sheet->getHighestRow();
        $range4 = 'A2:A' . $lastRow;

        $lastRow = $sheet->getHighestRow();
        $range5 = 'B2:B' . $lastRow;

        $lastRow = $sheet->getHighestRow(); 
        $range6 = 'J2:J' . $lastRow;

        $lastRow = $sheet->getHighestRow(); 
        $range7 = 'H2:H' . $lastRow;

        $lastRow = $sheet->getHighestRow(); 
        $range8 = 'G2:G' . $lastRow;

        $lastRow = $sheet->getHighestRow(); 
        $range9 = 'I2:I' . $lastRow;

        $lastRow = $sheet->getHighestRow(); 
        $range10 = 'K2:K' . $lastRow;

        $lastRow = $sheet->getHighestRow(); 
        $range11 = 'D2:D' . $lastRow;

        $lastRow = $sheet->getHighestRow(); 
        $range12 = 'P2:P' . $lastRow;
        
        // Establecer estilos de alineación centrada para las celdas en el rango
        $sheet->getStyle($range)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle($range1)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        
        $sheet->getStyle($range2)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle($range3)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        
        $sheet->getStyle($range4)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Establecer estilos de alineación centrada para las celdas en el rango
        $sheet->getStyle($range5)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Establecer estilos de alineación centrada para las celdas en el rango
        $sheet->getStyle($range6)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Establecer estilos de alineación centrada para las celdas en el rango
        $sheet->getStyle($range7)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle($range8)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        // Establecer estilos de alineación centrada para las celdas en el rango
        $sheet->getStyle($range9)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        // Establecer estilos de alineación centrada para las celdas en el rango
        $sheet->getStyle($range10)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        // Establecer estilos de alineación centrada para las celdas en el rango
        $sheet->getStyle($range11)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle($range12)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Aplicar estilo para ajustar automáticamente el ancho de las celdas del encabezado
        $sheet->getStyle('C1')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('D1')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('M1')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('P1')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('Q1')->getAlignment()->setTextRotation(90);
        $sheet->getStyle('R1')->getAlignment()->setTextRotation(90);

        $sheet->setAutoFilter('A1:R1');

        $sheet->getRowDimension(1)->setRowHeight(58);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(11);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(24);
        $sheet->getColumnDimension('F')->setWidth(45);

        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(12);

        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(6);
        $sheet->getColumnDimension('N')->setWidth(32);
        $sheet->getColumnDimension('O')->setWidth(12);
        $sheet->getColumnDimension('P')->setWidth(7);
        $sheet->getColumnDimension('Q')->setWidth(5);
        $sheet->getColumnDimension('R')->setWidth(16);

        $sheet->getStyle('A1:R1' . $sheet->getHighestRow())->applyFromArray([

            'font' => [
                'name' => 'Arial', 
                'size' => 7, 
                'bold' => true,

            ],

            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 
                    'color' => ['argb' => '#2cc5ff'], 
                ],
            ],
        ]);

        return [
            
        ];
    }
}
