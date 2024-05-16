<?php

namespace App\Http\Controllers;

use App\Exports\CertificadoExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CertifiedController extends Controller
{
    public function exportCertified($dni){
        return Excel::download(new CertificadoExport($dni), 'FORMATO.xlsx');
    }
}
