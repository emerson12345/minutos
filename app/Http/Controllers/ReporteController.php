<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use PDF;
use DB;
use Sicere\Models\LibCuaderno;
use Sicere\Models\ReportTemplate;

class ReporteController extends Controller
{
    public function produccion(){
        return view('reporte.produccion');
    }

    public function produccionPDF(Request $request){
        ReportTemplate::printHeaderFooter();
        PDF::AddPage('L', 'Letter');
        ReportTemplate::printTitle('REPORTE DE PRODUCCION',$request->rep_fec_ini,$request->rep_fec_fin);
        PDF::writeHTML(view('reporte._produccion',['fec_ini' => $request->rep_fec_ini,'fec_fin'=>$request->rep_fec_fin,'cuadernos'=>$request->cuaderno,'rep_institucion'=>$request->rep_institucion])->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('produccion.pdf');
    }
}
