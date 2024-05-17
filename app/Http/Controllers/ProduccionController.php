<?php

namespace App\Http\Controllers;

use App\Exports\ProduccionExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProduccionController extends Controller
{
    public function exportProduccion(){
        return Excel::download(new ProduccionExport, 'Producción diaria.xlsx');
    }
}
