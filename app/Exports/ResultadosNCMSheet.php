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

class ResultadosNCMSheet implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = $this->resultadosNCM();
        return $data;
    }

    private function resultadosNCM(){
        return Registro::join('intervenidos', 'intervenidos.id', '=', 'registros.intervenido_id')
        ->join('muestras', 'muestras.id', '=', 'registros.muestra_id')
        ->select(
            DB::raw('DATE(registros.fecha_hora_extraccion) as dia'),
            DB::raw('SUM(CASE WHEN intervenidos.edad < 18 THEN 1 ELSE 0 END) as MENORES'),
            DB::raw('SUM(CASE WHEN muestras.resultado_cualitativo = "NEGACIÓN" THEN 1 ELSE 0 END) as NEGATIVA'),
            DB::raw('SUM(CASE WHEN muestras.resultado_cualitativo = "CONSTATACIÓN" THEN 1 ELSE 0 END) as CONSTATACION'),
            DB::raw('SUM(CASE WHEN muestras.resultado_cualitativo = "SUPLANTACIÓN" THEN 1 ELSE 0 END) as SUPLANTACION'),
            DB::raw('
                SUM(
                    CASE 
                        WHEN intervenidos.edad < 18 THEN 1 
                        WHEN muestras.resultado_cualitativo = "NEGACIÓN" THEN 1 
                        WHEN muestras.resultado_cualitativo = "CONSTATACIÓN" THEN 1 
                        WHEN muestras.resultado_cualitativo = "SUPLANTACIÓN" THEN 1 
                        ELSE 0 
                    END
                ) as TOTAL'
            )
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
            ['USUARIOS SEGÚN MENORES DE EDAD, NEGATIVA A PASAR, CONSTATACION Y SUPLANTACION, DE LA UNIDAD DESCONCENTRADA DE DOSAJE ETILICO SEDE CHICLAYO, CORRESPONDIENTE AL MES DE '.$nombreMes.' '.$anio],
            ['N°', 'MENOR DE EDAD', 'NEGATIVA A PASAR', 'CONSTATACION', 'SUPLANTACION', 'TOTAL']
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(13);

        $sheet->getStyle('A1:F1')->getAlignment()->setWrapText(true);
        $sheet->getRowDimension(1)->setRowHeight(40);

        $sheet->mergeCells('A1:F1');


        $sheet->getStyle('A1:F1')->applyFromArray([
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
        $sheet->getStyle('A2:F2')->applyFromArray([
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
        $sheet->getStyle('A3:F' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

    }
}
