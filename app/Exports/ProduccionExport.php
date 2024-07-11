<?php

namespace App\Exports;

use App\Models\Muestra;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ProduccionExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->resultados();
    }

    private function resultados()
    {
        return Muestra::join('registros', 'registros.muestra_id', '=', 'muestras.id')
        ->join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id')
        ->select(
            DB::raw('DATE(muestras.fecha_muestra) as dia'),
            DB::raw('SUM(CASE WHEN intervenidos.sexo = "M" AND muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) as positivos_masculinos'),
            DB::raw('SUM(CASE WHEN intervenidos.sexo = "M" AND muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) as negativos_masculinos'),
            DB::raw('SUM(CASE WHEN intervenidos.sexo = "F" AND muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) as positivos_femeninos'),
            DB::raw('SUM(CASE WHEN intervenidos.sexo = "F" AND muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) as negativos_femeninos'),
            DB::raw('SUM(CASE WHEN intervenidos.sexo = "M" AND (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "CONSTATACIÓN") THEN 1 ELSE 0 END) as sin_muestra_masculinos'),
            DB::raw('SUM(CASE WHEN intervenidos.sexo = "F" AND (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "CONSTATACIÓN") THEN 1 ELSE 0 END) as sin_muestra_femeninos'),
            DB::raw('
                SUM(CASE WHEN intervenidos.sexo = "M" AND muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) +
                SUM(CASE WHEN intervenidos.sexo = "M" AND muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) +
                SUM(CASE WHEN intervenidos.sexo = "M" AND (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "CONSTATACIÓN") THEN 1 ELSE 0 END) +
                SUM(CASE WHEN intervenidos.sexo = "F" AND muestras.resultado_cualitativo = "positivo" THEN 1 ELSE 0 END) +
                SUM(CASE WHEN intervenidos.sexo = "F" AND muestras.resultado_cualitativo = "negativo" THEN 1 ELSE 0 END) +
                SUM(CASE WHEN intervenidos.sexo = "F" AND (muestras.resultado_cualitativo = "NEGACIÓN" OR muestras.resultado_cualitativo = "CONSTATACIÓN") THEN 1 ELSE 0 END) 
            as total')
        )
        ->groupBy(DB::raw('DATE(muestras.fecha_muestra)'))
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
            ['USUARIOS SEGÚN SEXO, DE LA UNIDAD DESCONCENTRADA DE DOSAJE ETILICO SEDE CHICLAYO, CORRESPONDIENTE AL MES DE ' . $nombreMes . ' ' . $anio],
            ['N°', 'MASCULINO', '', 'FEMENINO', '', 'TALONARIO SIN MUESTRA', '', 'TOTAL'],
            ['', 'POSITIVO', 'NEGATIVO', 'POSITIVO', 'NEGATIVO', 'MASCULINO', 'FEMENINO']
        ];
    }

    public function title(): string
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
        return $nombreMes . ' ' . $anio;
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->getColumnDimension('A')->setWidth(13);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(10);

        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:A3');
        $sheet->mergeCells('B2:C2');
        $sheet->mergeCells('D2:E2');
        $sheet->mergeCells('F2:G2');
        $sheet->mergeCells('H2:H3');

        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Arial',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A2:H3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 10,
                'name' => 'Arial',
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $sheet->getStyle('A1:H1')->getAlignment()->setWrapText(true);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Aplicar bordes a todas las celdas desde A4 hacia abajo
        $highestRow = $sheet->getHighestRow(); // Obtener la fila más alta que contiene datos
        $sheet->getStyle('A4:H' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Estilos adicionales para celdas fusionadas específicas
        $sheet->getStyle('A2:A3')->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $sheet->getStyle('B2:C2')->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $sheet->getStyle('D2:E2')->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $sheet->getStyle('F2:G2')->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
        $sheet->getStyle('H2:H3')->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }
}
