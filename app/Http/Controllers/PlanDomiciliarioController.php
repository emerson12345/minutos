<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use PDF;
use Sicere\Models\ReportTemplate;


class PlanDomiciliarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  function create($pac_id,$familiar_seg_id,$persona_ref_id,$areas_trabajo,$que,$como,$quien,$tiempo,$logros_fecha,$cua_id)
    {

        DB::table('plan_domiciliario')->insert(
            [
                "pac_id"=>$pac_id,
                "familiar_seg_id"=>$familiar_seg_id,
                "persona_ref_id"=>$persona_ref_id,
                "areas_trabajo"=>$areas_trabajo,
                "que"=>$que,
                "como"=>$como,
                "quien"=>$quien,
                "tiempo"=>$tiempo,
                "logros_fecha"=>$logros_fecha,
                "cua_id"=>$cua_id
            ]
        );
        $listPlanDomiciliario=DB::table('plan_domiciliario')
            ->where('pac_id','=',$pac_id)
            ->where("cua_id","=",$cua_id)
            ->select('*')
            ->get();
        return view('plan_domiciliario.index',['listPlanDomiciliario'=>$listPlanDomiciliario]);
    }
    public  function show($pac_id,$cua_id)
    {
        $listPlanDomiciliario=DB::table('plan_domiciliario')
            ->where('pac_id','=',$pac_id)
            ->where("cua_id","=",$cua_id)
            ->select('*')
            ->get();
        return view('plan_domiciliario.index',['listPlanDomiciliario'=>$listPlanDomiciliario]);
    }
    public  function pdf($pac_id,$cua_id)
    {

        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        PDF::SetFont('','B');
        ReportTemplate::printTitle('PLAN DOMICILIARIO - PLAN DE REHABILITACIÓN PARA LA CASA');
        PDF::SetFont('','');

        PDF::Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', '', '', true, 150, 'R', false, false, 0, false, false, false);
        PDF::SetTitle('PLAN DOMICILIARIO - PLAN DE REHABILITACIÓN PARA LA CASA');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 50, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //PDF::AddPage('P', 'Letter');
        $listPlanDomiciliario=DB::table('plan_domiciliario')
            ->join("paciente","paciente.pac_id","=","plan_domiciliario.pac_id")
            ->join("lib_cuadernos","lib_cuadernos.cua_id","=","plan_domiciliario.cua_id")
            ->where('paciente.pac_id','=',$pac_id)
            ->where("lib_cuadernos.cua_id","=",$cua_id)
            ->select('plan_domiciliario.*','paciente.pac_ap_prim','paciente.pac_ap_seg',"paciente.pac_nombre","lib_cuadernos.cua_nombre")
            ->get();

        PDF::writeHTML(view('plan_domiciliario.pdf',['listPlanDomiciliario'=>$listPlanDomiciliario])->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('recibo_recetario.pdf','D');
    }

    public  function pdf_plan($id)
    {

        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        PDF::SetFont('','B');
        ReportTemplate::printTitle('PLAN DOMICILIARIO - PLAN DE REHABILITACIÓN PARA LA CASA');
        PDF::SetFont('','');
        PDF::Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', '', '', true, 150, 'R', false, false, 0, false, false, false);
        PDF::SetTitle('PLAN DOMICILIARIO - PLAN DE REHABILITACIÓN PARA LA CASA');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 50, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //PDF::AddPage('P', 'Letter');
        $listPlanDomiciliario=DB::table('plan_domiciliario')
            ->join("paciente","paciente.pac_id","=","plan_domiciliario.pac_id")
            ->join("lib_cuadernos","lib_cuadernos.cua_id","=","plan_domiciliario.cua_id")
            ->where('plan_domiciliario.id','=',$id)
            ->select('plan_domiciliario.*','paciente.pac_ap_prim','paciente.pac_ap_seg',"paciente.pac_nombre","lib_cuadernos.cua_nombre")
            ->get();

        PDF::writeHTML(view('plan_domiciliario.pdf',['listPlanDomiciliario'=>$listPlanDomiciliario])->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('plan_domiciliario.pdf','D');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
