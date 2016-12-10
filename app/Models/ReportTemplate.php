<?php

namespace Sicere\Models;
use PDF;
class ReportTemplate
{
    public static function printHeaderFooter(){
        PDF::setHeaderCallback(function($pdf) {
            $base=base_path()."\\public\\template\\dist\\img";
            $pdf->Cell(0, 27, '', 'B', false, 'R', 0, '', 0, false, 'T', 'M');
            //$pdf->Image(asset('template/dist/img/bolivia.gif'), 15, 10, 0, 15, 'GIF', '', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->Image($base."\\bolivia.gif", 15, 10, 0, 15, 'GIF', '', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Text(33,22,'Sistema de centros de rehabilitación','R');
            $pdf->SetFont('helvetica', 'K', 10);
            $pdf->Image($base."\\minsalud-logo.jpg", 25, 12, 0, 12, 'JPG', '', '', true, 150, 'R', false, false, 0, false, false, false);
        });
        PDF::setFooterCallback(function($pdf) {
            $strCodSeguridad=session('institucion')->inst_codigo . '|' . session('institucion')->inst_nombre .'|' . \Auth::user()->user_id;
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 10, 'Pagina '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 'T', false, 'R', 0, '', 0, false, 'T', 'M');
            $y= $pdf->GetY()+1;
            $x = 25;
            $pdf->write2DBarcode($strCodSeguridad, 'PDF417', $x, $y, 100, 6, ['position'=>'L'], 'N',true);
        });
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 35, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM-10);
    }

    public static function printTitle($title = 'SIN ESPECIFICAR',$fec_ini =null,$fec_fin =null){
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $institucion = \Sicere\Models\Institucion::find($inst_id);
        if($institucion){
            PDF::SetY(28);
            PDF::SetFont('Helvetica','',8);
            if($institucion->departamento)
                PDF::Cell(40,5,'SEDES '.$institucion->departamento->dep_nombre,0,0,'L',false,null,1);
            else
                PDF::Cell(40,5,'SEDES',0,0,'L',false,null,1);
            if($institucion->area)
                PDF::Cell(40,5,'RED: '.$institucion->area->area_nombre,0,0,'L',false,null,1);
            else
                PDF::Cell(40,5,'RED: NE',0,0,'L',false,null,1);
            if($institucion->municipio)
                PDF::Cell(40,5,'MUNICIPIO: '.$institucion->municipio->mun_nombre,0,0,'L',false,null,1);
            else
                PDF::Cell(40,5,'MUNICIPIO: NE',0,0,'L',false,null,1);
            PDF::Cell(70,5,'ESTABLECIMIENTO: '.$institucion->inst_nombre,0,0,'L',false,null,1);
        }
        PDF::Ln();
        PDF::Ln();
        PDF::SetFont('Helvetica','B',11);
        PDF::Cell(0,5,$title,0,1,'C');
        if(!($fec_ini==null&&$fec_fin==null)){
            PDF::Cell(0,5,$fec_ini.' - '.$fec_fin,0,1,'C');
        }
        PDF::Ln();
    }
}