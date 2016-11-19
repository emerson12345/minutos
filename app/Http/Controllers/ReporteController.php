<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use PDF;
use DB;
use Sicere\Models\LibCuaderno;

class ReporteController extends Controller
{
    public function produccion(){
        return view('reporte.produccion');
    }

    public function produccionPDF(Request $request){
        PDF::setHeaderCallback(function($pdf) {
            $pdf->Cell(0, 27, '', 'B', false, 'R', 0, '', 0, false, 'T', 'M');
            $pdf->Image(asset('template/dist/img/bolivia.gif'), 25, 10, 0, 15, 'GIF', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'B', 18);
            $pdf->Text(60,14,'Ministerio de salud y deportes');
            $pdf->Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', 'http://www.tcpdf.org', '', true, 150, 'R', false, false, 0, false, false, false);
        });
        PDF::setFooterCallback(function($pdf) {
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 10, 'Pagina '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 'T', false, 'R', 0, '', 0, false, 'T', 'M');
        });


        PDF::SetTitle('My Report');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(25, 30, 25);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage('L', 'Letter');
        PDF::writeHTML(view('reporte._produccion',['fec_ini' => $request->rep_fec_ini,'fec_fin'=>$request->rep_fec_fin,'cuadernos'=>$request->cuaderno,'rep_institucion'=>$request->rep_institucion])->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('produccion.pdf');
    }
}
