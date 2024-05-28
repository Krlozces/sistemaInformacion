<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PersonalExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportPersonalController extends Controller
{
    public function exportPersonal(){
        return Excel::download(new PersonalExport, 'Personal.xlsx');
    }
}
