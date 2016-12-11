<?php

namespace Sicere\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use Sicere\Models\LibCuaderno;
use Sicere\Models\ReportTemplate;
use Sicere\Models\Setup;
use Sicere\User;

class ReporteAgendaController extends Controller
{
    public function inasistencia(){
        return view('reporte_agenda.agendaInasistencia');
    }

    public function postInasistencia(Request $request){

        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $user_id = $request->user_id?:0;
        $anio = $request->anio?:date('Y');
        $mes = $request->mes?:date('n');
        $fecha_temp = Carbon::create($anio,$mes,1);
        $fecha_ini = $fecha_temp->startOfMonth()->format('d/m/Y');
        $fecha_fin = $fecha_temp->endOfMonth()->format('d/m/Y');

        $cuadernos = $request->cuaderno?:[];
        $reportDataTotal=['atend'=>0,'no_atend'=>0,'total'=>0];
        $reportData = [];
        foreach ($cuadernos as $cua_id){
            $cuaderno = LibCuaderno::find($cua_id);
            $query = DB::table('agenda')->select(
                DB::raw('count(*) as total'),
                DB::raw("coalesce(sum(case when agenda_estado='T' then 1 else 0 end),0) as atendidos"))
                ->where('inst_id',$inst_id)
                ->whereBetween('agenda_fec_ini',[$fecha_ini,$fecha_fin])
                ->where('cua_id',$cuaderno->cua_id)
                ->where('user_id',$user_id==0?'<>':'=',$user_id)
                ->first();
            $total = $query->total;
            $tot_atendidos = $query->atendidos;
            $tot_noatendidos = $total - $tot_atendidos;
            $reportData[$cuaderno->cua_nombre] = ['atend'=>$tot_atendidos,'no_atend'=>$tot_noatendidos,'total'=>$total];
            $reportDataTotal['atend']+=$tot_atendidos;
            $reportDataTotal['no_atend']+=$tot_noatendidos;
            $reportDataTotal['total']+=$total;
        }

        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        PDF::SetFont('','B');
        ReportTemplate::printTitle('PORCENTAJE DE INASISTENCIA A CITAS',$fecha_ini,$fecha_fin);
        PDF::SetFillColor(200);
        $perc = $reportDataTotal['total']==0?:100/$reportDataTotal['total'];
        PDF::Cell(90,5,'SERVICIO','LTB',0,'C',true,null,1);
        PDF::Cell(15,5,'ATEND.','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'NO ATEND.','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'TOTAL','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'ATEND. (%)','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'NO ATEND. (%)','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'TOTAL (%)','TBR',0,'C',true,null,1);
        PDF::Ln();
        PDF::SetFont('');
        foreach ($reportData as $index=>$dataItem){
            PDF::Cell(90,5,$index,'LTB',0,'L',false,null,1);
            PDF::Cell(15,5,$dataItem['atend'],'TB',0,'R',false,null,1);
            PDF::Cell(15,5,$dataItem['no_atend'],'TB',0,'R',false,null,1);
            PDF::Cell(15,5,$dataItem['total'],'TB',0,'R',false,null,1);
            PDF::Cell(15,5,number_format($dataItem['atend']*$perc,2),'TB',0,'R',false,null,1);
            PDF::Cell(15,5,number_format($dataItem['no_atend']*$perc,2),'TB',0,'R',false,null,1);
            PDF::Cell(15,5,number_format($dataItem['total']*$perc,2),'TBR',0,'R',false,null,1);
            PDF::Ln();
        }
        PDF::SetFont('','B');

        PDF::Cell(90,5,'TOTALES','LTB',0,'L',true,null,1);
        PDF::Cell(15,5,$reportDataTotal['atend'],'TB',0,'R',true);
        PDF::Cell(15,5,$reportDataTotal['no_atend'],'TB',0,'R',true);
        PDF::Cell(15,5,$reportDataTotal['total'],'TB',0,'R',true);
        PDF::Cell(15,5,number_format($reportDataTotal['atend']*$perc,2),'TB',0,'R',true);
        PDF::Cell(15,5,number_format($reportDataTotal['no_atend']*$perc,2),'TB',0,'R',true);
        PDF::Cell(15,5,number_format($reportDataTotal['total']*$perc,2),'TBR',0,'R',true);
        PDF::Ln();PDF::Ln();

        PDF::SetX(55);
        PDF::SetFillColor(0,240,0);
        PDF::Cell(30,5,'Atendidos',0,0,'R');
        PDF::SetTextColor(255,255,255);
        PDF::Cell(15,5,number_format($reportDataTotal['atend']*$perc,2).' %',1,0,'R',true,null,1);
        PDF::SetTextColor(0,0,0);
        PDF::SetFillColor(240,0,0);
        PDF::Cell(30,5,'No atendidos',0,0,'R');
        PDF::SetTextColor(255,255,255);
        PDF::Cell(15,5,number_format($reportDataTotal['no_atend']*$perc,2).' %',1,0,'R',true,null,1);
        $xc=110;$yc=PDF::GetY()+40;$r=30;
        $middle = $reportDataTotal['total']==0?:($reportDataTotal['atend']*360)/$reportDataTotal['total'];
        PDF::SetFillColor(0,240,0);
        PDF::PieSector($xc, $yc, $r, 0, $middle, 'FD',false);
        PDF::SetFillColor(240,0,0);
        PDF::PieSector($xc, $yc, $r, $middle,360, 'FD',false);
        PDF::lastPage();
        PDF::Output('produccion.pdf');
    }

    public function abandonos(){
        return view('reporte_agenda.agendaAbandono');
    }

    public function postAbandonos(Request $request){
        $setup = Setup::find('set_nro_dias_abandono');
        $user_id = $request->user_id?:0;
        $anio = $request->anio?:date('Y');
        $mes = $request->mes?:date('n');
        $fecha_temp = Carbon::create($anio,$mes,1);
        $fecha_ini = $fecha_temp->startOfMonth()->format('d/m/Y');
        $fecha_fin = $fecha_temp->endOfMonth()->format('d/m/Y');
        $cuadernos = $request->cuaderno?:[];
        $data =$this->getTotalForCuadernos($fecha_ini,$fecha_fin,$user_id,$cuadernos,$setup->set_valor);
        $totales = array_pop($data);

        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        ReportTemplate::printTitle('PORCENTAJE DE TRATAMIENTOS ABANDONADOS',$fecha_ini,$fecha_fin);
        PDF::SetFillColor(200);
        PDF::SetFont('','B');
        PDF::Cell(90,5,'SERVICIO','LTB',0,'C',true,null,1);
        PDF::Cell(15,5,'ABAND.','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'NO ABAND.','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'TOTAL','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'ABAND. (%)','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'NO ABAND. (%)','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'TOTAL (%)','TBR',0,'C',true,null,1);
        PDF::Ln();

        PDF::SetFont('');
        $perc =$totales['total']==0?$totales['total']:100/$totales['total'];
        foreach ($data as $index=>$dataItem){
            PDF::Cell(90,5,$index,'LTB',0,'L',false,null,1);
            PDF::Cell(15,5,$dataItem['abandono'],'TB',0,'R',false,null,1);
            PDF::Cell(15,5,$dataItem['no_abandono'],'TB',0,'R',false,null,1);
            PDF::Cell(15,5,$dataItem['total'],'TB',0,'R',false,null,1);
            PDF::Cell(15,5,number_format($dataItem['abandono']*$perc,2),'TB',0,'R',false,null,1);
            PDF::Cell(15,5,number_format($dataItem['no_abandono']*$perc,2),'TB',0,'R',false,null,1);
            PDF::Cell(15,5,number_format($dataItem['total']*$perc,2),'TBR',0,'R',false,null,1);
            PDF::Ln();
        }

        PDF::SetFont('','B');

        PDF::Cell(90,5,'TOTALES','LTB',0,'L',true,null,1);
        PDF::Cell(15,5,$totales['abandono'],'TB',0,'R',true);
        PDF::Cell(15,5,$totales['no_abandono'],'TB',0,'R',true);
        PDF::Cell(15,5,$totales['total'],'TB',0,'R',true);
        PDF::Cell(15,5,number_format($totales['abandono']*$perc,2),'TB',0,'R',true);
        PDF::Cell(15,5,number_format($totales['no_abandono']*$perc,2),'TB',0,'R',true);
        PDF::Cell(15,5,number_format($totales['total']*$perc,2),'TBR',0,'R',true);
        PDF::Ln();PDF::Ln();

        PDF::SetX(55);
        PDF::SetFillColor(240,0,0);
        PDF::Cell(30,5,'T. abandonados',0,0,'R',false,null,1);
        PDF::SetTextColor(255,255,255);
        PDF::Cell(15,5,number_format($totales['abandono']*$perc,2).' %',1,0,'R',true,null,1);
        PDF::SetTextColor(0,0,0);
        PDF::SetFillColor(0,240,0);
        PDF::Cell(30,5,'T. no abandonados',0,0,'R',false,null,1);
        PDF::SetTextColor(255,255,255);
        PDF::Cell(15,5,number_format($totales['no_abandono']*$perc,2).' %',1,0,'R',true,null,1);
        $xc=110;$yc=PDF::GetY()+40;$r=30;
        $middle = $totales['total']==0?0:($totales['abandono']*360)/$totales['total'];
        PDF::SetFillColor(240,0,0);
        PDF::PieSector($xc, $yc, $r, 0, $middle, 'FD',false);
        PDF::SetFillColor(0,240,0);
        PDF::PieSector($xc, $yc, $r, $middle,360, 'FD',false);

        PDF::lastPage();
        PDF::Output('produccion.pdf');
    }

    public function tratamientosExitosos(){
        return view('reporte_agenda.agendaExitosos');
    }

    public function postTratamientosExitosos(Request $request){
        $user_id = $request->user_id?:0;
        $anio = $request->anio?:date('Y');
        $mes = $request->mes?:date('n');
        $fecha_temp = Carbon::create($anio,$mes,1);
        $fecha_ini = $fecha_temp->startOfMonth()->format('d/m/Y');
        $fecha_fin = $fecha_temp->endOfMonth()->format('d/m/Y');
        $cuadernos = $request->cuaderno?:[];
        $data =$this->getTotalForCuadernos($fecha_ini,$fecha_fin,$user_id,$cuadernos,1);
        $totales = array_pop($data);

        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        ReportTemplate::printTitle('PORCENTAJE DE TRATAMIENTOS CONCLUIDOS CON EXITO',$fecha_ini,$fecha_fin);
        PDF::SetFillColor(200);
        PDF::SetFont('','B');
        PDF::Cell(90,5,'SERVICIO','LTB',0,'C',true,null,1);
        PDF::Cell(15,5,'NO EXIT.','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'EXIT.','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'TOTAL','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'NO EXIT. (%)','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'EXIT. (%)','TB',0,'C',true,null,1);
        PDF::Cell(15,5,'TOTAL (%)','TBR',0,'C',true,null,1);
        PDF::Ln();

        PDF::SetFont('');
        $perc =$totales['total']==0?$totales['total']:100/$totales['total'];
        foreach ($data as $index=>$dataItem){
            PDF::Cell(90,5,$index,'LTB',0,'L',false,null,1);
            PDF::Cell(15,5,$dataItem['abandono'],'TB',0,'R',false,null,1);
            PDF::Cell(15,5,$dataItem['no_abandono'],'TB',0,'R',false,null,1);
            PDF::Cell(15,5,$dataItem['total'],'TB',0,'R',false,null,1);
            PDF::Cell(15,5,number_format($dataItem['abandono']*$perc,2),'TB',0,'R',false,null,1);
            PDF::Cell(15,5,number_format($dataItem['no_abandono']*$perc,2),'TB',0,'R',false,null,1);
            PDF::Cell(15,5,number_format($dataItem['total']*$perc,2),'TBR',0,'R',false,null,1);
            PDF::Ln();
        }

        PDF::SetFont('','B');

        PDF::Cell(90,5,'TOTALES','LTB',0,'L',true,null,1);
        PDF::Cell(15,5,$totales['abandono'],'TB',0,'R',true);
        PDF::Cell(15,5,$totales['no_abandono'],'TB',0,'R',true);
        PDF::Cell(15,5,$totales['total'],'TB',0,'R',true);
        PDF::Cell(15,5,number_format($totales['abandono']*$perc,2),'TB',0,'R',true);
        PDF::Cell(15,5,number_format($totales['no_abandono']*$perc,2),'TB',0,'R',true);
        PDF::Cell(15,5,number_format($totales['total']*$perc,2),'TBR',0,'R',true);
        PDF::Ln();PDF::Ln();

        PDF::SetX(55);
        PDF::SetFillColor(240,0,0);
        PDF::Cell(30,5,'T. no exitosos',0,0,'R',false,null,1);
        PDF::SetTextColor(255,255,255);
        PDF::Cell(15,5,number_format($totales['abandono']*$perc,2).' %',1,0,'R',true,null,1);
        PDF::SetTextColor(0,0,0);
        PDF::SetFillColor(0,240,0);
        PDF::Cell(30,5,'T. exitosos',0,0,'R',false,null,1);
        PDF::SetTextColor(255,255,255);
        PDF::Cell(15,5,number_format($totales['no_abandono']*$perc,2).' %',1,0,'R',true,null,1);
        $xc=110;$yc=PDF::GetY()+40;$r=30;
        $middle = $totales['total']==0?0:($totales['abandono']*360)/$totales['total'];
        PDF::SetFillColor(240,0,0);
        PDF::PieSector($xc, $yc, $r, 0, $middle, 'FD',false);
        PDF::SetFillColor(0,240,0);
        PDF::PieSector($xc, $yc, $r, $middle,360, 'FD',false);

        PDF::lastPage();
        PDF::Output('produccion.pdf');
    }

    public function grupoEtario(){
        return view('reporte_agenda.grupoEtario');
    }

    public function postGrupoEtario(Request $request){
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;

        $user_id = $request->user_id?:0;
        $anio = $request->anio?:date('Y');
        $mes = $request->mes?:date('n');
        $fecha_temp = Carbon::create($anio,$mes,1);
        $fecha_ini = $fecha_temp->startOfMonth()->format('d/m/Y');
        $fecha_fin = $fecha_temp->endOfMonth()->format('d/m/Y');
        $cuadernos = $request->cuaderno?:[];
        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        ReportTemplate::printTitle('CANTIDAD DE SESIONES POR GRUPO ETARIO',$fecha_ini,$fecha_fin);
        PDF::SetLineWidth(0.2);
        $header = ['De 0 a 4 años', 'De 5 a 9 años', 'De 10 a 20 años', 'De 21 a 59 años', '> 60 años'];
        PDF::Cell(75,5,'Servicio',1,0,'C',false,null,1);
        foreach ($header as $i=>$h){
            PDF::Cell(15,5,$h,1,0,'C',false,null,1);
        }
        PDF::Cell(15,5,'Total',1,0,'C',false,null,1);
        PDF::Cell(15,5,'Total (%)',1,0,'C',false,null,1);
        PDF::Ln();
        PDF::SetFont('');
        $etarios = [ [0,4],[5,9],[10,20],[21,59],[60,200] ];
        $totalEtarios = [0,0,0,0,0];
        $totalCuadernos = [];
        $totalGeneral = 0;
        foreach($cuadernos as $cua){
            $cuaderno = LibCuaderno::find($cua);
            $totalCuaderno = 0;
            PDF::Cell(75,5,$cuaderno->cua_nombre,'LTB',0,'L',false,null,1);
            foreach ($etarios as $i=>$etario){
                $total = $this->getCountEtario($fecha_ini,$fecha_fin,$user_id,$cuaderno->cua_id,$etario[0],$etario[1]);
                $totalEtarios[$i]+=$total;
                $totalCuaderno+=$total;
                PDF::Cell(15,5,$total,1,0,'C',false,null,1);
            }
            PDF::Cell(15,5,$totalCuaderno,1,0,'C',false,null,1);
            $totalCuadernos[] = $totalCuaderno;
            $totalGeneral+=$totalCuaderno;
            PDF::Ln();
        }
        $perc = $totalGeneral==0?0:100/$totalGeneral;
        PDF::SetXY(180,58);
        foreach ($totalCuadernos as $subTotal){
            PDF::Cell(15,5,number_format($subTotal*$perc,2),'TBR',2,'R',false,null,1);
        }
        PDF::SetX(15);
        PDF::SetFillColor(240);
        PDF::SetFont('','B');
        PDF::Cell(75,5,'Total','LTB',0,'R',true,null,1);
        foreach ($totalEtarios as $subTotal){
            PDF::Cell(15,5,$subTotal,'LTB',0,'C',true,null,1);
        }
        PDF::Cell(15,5,'0','LTBR',0,'C',true,null,1);
        PDF::Cell(15,5,'100.00','TBR',0,'R',true,null,1);
        PDF::lastPage();
        PDF::Output('produccion.pdf');
    }

    public function getCuadernos(Request $request){
        $user_id = $request->user_id?:0;
        $usuario = User::find($user_id);
        $cuadernos = LibCuaderno::where('cua_seleccionable',1)->get();
        if($usuario)
            $cuadernos = $usuario->cuadernos;
        return view('reporte_agenda._cuadernos',['cuadernos'=>$cuadernos]);
    }

    private function getTotalForCuadernos($fecha_ini, $fecha_fin, $user_id, $cua_list,$max_falta){
        $totales = [];
        $total = 0;$total_abandono = 0;
        foreach($cua_list as $cua){
            $cuaderno = LibCuaderno::find($cua);
            if($cuaderno){
                $tratamientos = $this->getTratamientos($fecha_ini,$fecha_fin,$user_id,$cuaderno->cua_id);
                $totalTrat=0;$totalAban=0;
                foreach($tratamientos as $tratamiento){
                    $totalTrat++;
                    $trat_list = DB::select("
                      select * from agenda 
                      where (agenda_id = {$tratamiento->agenda_id} or agenda_id_padre = {$tratamiento->agenda_id})
                      and agenda_fec_ini::DATE BETWEEN '{$fecha_ini}' and '{$fecha_fin}'
                      order by agenda_fec_ini asc
                    ");
                    $abandono = 0;
                    foreach ($trat_list as $trat_item){
                        if($trat_item->agenda_estado != 'T'){
                            $abandono++;
                        }else{
                            $abandono = 0;
                        }
                        if($abandono>=$max_falta){
                            $totalAban++;
                            break;
                        }
                    }
                }
                $totales[$cuaderno->cua_nombre] = ['total'=>$totalTrat, 'abandono'=>$totalAban,'no_abandono'=>$totalTrat-$totalAban];
                $total+= $totalTrat;
                $total_abandono+= $totalAban;
            }
        }
        $totales['total']= ['total'=>$total, 'abandono' => $total_abandono, 'no_abandono'=>$total-$total_abandono];
        return $totales;
    }

    private function getTratamientos($fecha_ini, $fecha_fin, $user_id,$cua_id){
        $compare = $user_id == 0?'<>':'=';
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $tratamientos = DB::select("
            select distinct agenda_id from agenda
            where agenda_id 
            in (select distinct agenda_id_padre 
                from agenda 
                where user_id {$compare} {$user_id}
                and inst_id = {$inst_id}
                and cua_id = {$cua_id}
                and agenda_fec_ini::DATE between '{$fecha_ini}' and '{$fecha_fin}')
            or (user_id {$compare} {$user_id}
            and inst_id = {$inst_id}
            and cua_id = {$cua_id}
            and agenda_fec_ini::DATE between '{$fecha_ini}' and '{$fecha_fin}' 
            and agenda_id_padre is null)
        ");
        return $tratamientos;
    }

    private function getCountEtario($fecha_ini,$fecha_fin,$user_id,$cua_id,$edad_ini, $edad_fin){
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $compare = $user_id==0?'<>':'=';
        $data = DB::select("
            select count(*) as total from
            (select distinct agenda_id, paciente_hc.pac_edad from agenda
            inner join paciente_hc
            on (agenda.pac_id = paciente_hc.pac_id and agenda.agenda_fec_ini::DATE = paciente_hc.hc_fecha)
            where agenda_fec_ini between '{$fecha_ini}' and '{$fecha_fin}'
            and agenda.inst_id {$compare} {$inst_id}
            and agenda.user_id = {$user_id}
            and agenda.cua_id = {$cua_id}
            and agenda.agenda_estado = 'T'
            ) as temp_table
            where temp_table.pac_edad BETWEEN {$edad_ini} and {$edad_fin}
        ");
        return $data[0]->total;
    }

}
