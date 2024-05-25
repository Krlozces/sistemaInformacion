<?php

namespace App\Exports;

use App\Models\Certificado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ResultadosExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array{
        $sheets = [];
        $sheets[] = new DataExport();
        $sheets[] = new ProduccionExport();
        $sheets[] = new ResultadosConsolidadosSheet();
        $sheets[] = new ResultadosMotivosSheet();
        $sheets[] = new ResultadosERSheet();
        $sheets[] = new ResultadosNCMSheet();

        return $sheets;
    }
}
