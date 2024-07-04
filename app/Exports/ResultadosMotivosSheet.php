<?php

namespace App\Exports;

use App\Models\Registro;
use App\Models\Certificado;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ResultadosMotivosSheet implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->resultadosMotivos();
        return $data;
    }

    private function resultadosMotivos(){
        return Registro::select(
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
            ->whereDate(DB::raw('DATE(registros.fecha_hora_extraccion)'), DB::raw('CURDATE()'))
            ->groupBy(DB::raw('DATE(registros.fecha_hora_extraccion)'))
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
            ['USUARIOS SEGÚN MOTIVOS, DE LA UNIDAD DESCONCENTRADA DE DOSAJE ETILICO SEDE CHICLAYO, CORRESPONDIENTE AL MES DE '.$nombreMes.' '.$anio],
            ['N°', 'ACCIDENTE DE TRANSITO', 'PRESUNCION DE EBRIEDAD', 'OTRO', 'TOTAL']
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);

        $sheet->getStyle('A1:H1')->getAlignment()->setWrapText(true);
        $sheet->getRowDimension(1)->setRowHeight(40);

        $sheet->mergeCells('A1:E1');


        $sheet->getStyle('A1:E1')->applyFromArray([
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

        // Aplicar estilos a A2:E2 (centrado y bordes)
        $sheet->getStyle('A2:E2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'inside' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Aplicar bordes a todas las celdas desde A4 hacia abajo
        $highestRow = $sheet->getHighestRow(); // Obtener la fila más alta que contiene datos
        $sheet->getStyle('A3:E' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

    }
}
