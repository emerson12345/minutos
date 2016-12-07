<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sicere\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Sicere\Models\ExamenesTipo;
use Sicere\Models\Paciente;
use Sicere\Models\PacienteHc;
use Sicere\Models\PacienteHcReceta;
use PDF;

class ReciboRecetarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $hc_id=DB::select('select max(hc_id) from paciente_hc')[0]->max;
        $listExamenesTipo=ExamenesTipo::all()->pluck('exc_tip_nombre','exc_tip_id');

        $pact_id=DB::select('select pact_id from paciente_hc where paciente_hc.hc_id='.$hc_id)[0]->pact_id;

        $urlreciboRecetario = asset('recibo_recetario/store/');
        $urlexamencomplementario = asset('examen_complementario/store/');
        $urlRerporteExamenComplementario=asset("examen_complementario/report/1");


        $strIdModal="reciboRecetario";
        $strModalTitulo="Prestaciones e Insumos";
        $listFormularios = DB::table('v_prestacion_insumos')
            ->select("*")
            ->get();
        $view=View::make
        (
            'recibo_recetario.index',
            array(
                    'listFormularios'=>$listFormularios,
                    'pact_id'=>$pact_id,
                    'listExamenesTipo'=>$listExamenesTipo,
                    'urlRerporteExamenComplementario'=>$urlRerporteExamenComplementario
            )
        )->with(array('strIdModal'=>$strIdModal,'urlreciboRecetario'=>$urlreciboRecetario,'urlexamencomplementario'=>$urlexamencomplementario));
        return $view;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($ins_med_cod=0,$rec_indicaciones=0,$rec_cantidad=0,$rec_med_nombre=0)
    {
        $urlreciboRecetariodestroy = asset('recibo_recetario/destroy/');
        $hc_id=DB::select('select max(hc_id) from paciente_hc')[0]->max;

        $countPacienteHcReceta=DB::table('paciente_hc_receta')
            ->where('paciente_hc_receta.ins_med_cod','=',$ins_med_cod)
            ->where('paciente_hc_receta.ins_med_cod','!=','0')
            ->where('paciente_hc_receta.hc_id','=',$hc_id)
            ->count();

        if($countPacienteHcReceta==0){
            if(($ins_med_cod==-1 || $rec_indicaciones==-1 || $rec_cantidad==-1 || $rec_med_nombre==-1)==false)
            {
                DB::table('paciente_hc_receta')->insert(
                    [
                        'rec_med_nombre'=>$rec_med_nombre,
                        'user_id'=>Auth::user()->user_id,
                        'hc_id'=>$hc_id,
                        'ins_med_cod'=>$ins_med_cod,
                        'rec_indicaciones'=>$rec_indicaciones,
                        'rec_cantidad'=>$rec_cantidad
                    ]
                );
            }
        }
        else{

        }
        $listPacienteHcReceta=DB::table('paciente_hc_receta')
            ->where('paciente_hc_receta.hc_id','=',$hc_id)
            ->select('*')
            ->get();

        return view('recibo_recetario.list_recibo_recetario',['listPacienteHcReceta'=>$listPacienteHcReceta,'urlreciboRecetariodestroy'=>$urlreciboRecetariodestroy]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function destroy($rec_id)
    {
        $urlreciboRecetariodestroy = asset('recibo_recetario/destroy/');
        DB::table('paciente_hc_receta')->where('paciente_hc_receta.rec_id', $rec_id)->delete();
        $hc_id=DB::select('select max(hc_id) from paciente_hc')[0]->max;

        $listPacienteHcReceta=DB::table('paciente_hc_receta')
            ->where('paciente_hc_receta.hc_id','=',$hc_id)
            ->select('*')
            ->get();

        return view('recibo_recetario.list_recibo_recetario',['listPacienteHcReceta'=>$listPacienteHcReceta,'urlreciboRecetariodestroy'=>$urlreciboRecetariodestroy]);
    }
    public function  report($rec_id)
    {

        $hc_id=DB::select('select max(hc_id) from paciente_hc')[0]->max;

        //$arr_tabla=DB::select("select * from paciente_hc_receta");

        $arr_tabla=DB::table("paciente_hc_receta")
                        ->where('paciente_hc_receta.hc_id','=',$hc_id)
                        ->select(
                            'ins_med_cod', 'rec_med_nombre', 'rec_indicaciones', 'rec_cantidad','rec_id as cod'
                        )
                        ->get()
                        ->toArray();

        $nombre_campos_form= array('Código', 'Medicamentos e inzumos', 'Indicaciones para el paciente', 'Cantidad','cod');
        $nombre_campos_tabla= array('ins_med_cod', 'rec_med_nombre', 'rec_indicaciones', 'rec_cantidad','cod');



        /*
        PDF::setHeaderCallback(function($pdf) {
            $pdf->Cell(0, 27, '', 'B', false, 'R', 0, '', 0, false, 'T', 'M');
            $pdf->Image(asset('template/dist/img/bolivia.gif'), 15, 10, 0, 15, 'GIF', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Text(33,22,'Sistema de centros de rehabilitación','R');
            $pdf->SetFont('helvetica', 'K', 10);
            $pdf->Text(15,27,'Establecimiento: '.session('institucion')->inst_nombre);
            $pdf->Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', 'http://www.tcpdf.org', '', true, 150, 'R', false, false, 0, false, false, false);
        });*/


        $listDatosPaciente=DB::table('paciente')
            ->join('paciente_hc','paciente_hc.pac_id','=','paciente.pac_id')
            ->where('paciente_hc.hc_id','=',$hc_id)
            ->select('paciente.pac_ap_prim','paciente.pac_ap_seg','paciente.pac_nombre','paciente_hc.hc_id',
                'paciente.pac_direccion')
            ->first();

        $listLugar=DB::table('usuario_institucion')
            ->join('institucion','institucion.inst_id','=','usuario_institucion.inst_id')
            ->join('lugar_municipio','lugar_municipio.mun_id','=','institucion.mun_id')
            ->where('user_id','=',Auth::user()->user_id)
            ->where('inst_nombre','=',session('institucion')->inst_nombre)
            ->select('lugar_municipio.mun_nombre')
            ->first();

        //echo $listDatosPaciente->pac_direccion;


        PDF::setHeaderCallback(function($pdf) use($listDatosPaciente,$listLugar) {
            $pdf->Cell(0, 27, '', 'B', false, 'R', 0, '', 0, false, 'T', 'M');
            $pdf->Image(asset('template/dist/img/bolivia.gif'), 15, 10, 0, 15, 'GIF', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Text(33,22,'Sistema de centros de rehabilitación','R');
            $pdf->SetFont('helvetica', 'K', 10);

            $pdf->Text(80,31,'RECIBO RECETARIO');

            $pdf->Text(15,41,'Municipio:'.$listLugar->mun_nombre);
            $pdf->Text(15,46,'Establecimiento: '.session('institucion')->inst_nombre);
            $pdf->Text(15,51,'Nombres y Apellidos:'.$listDatosPaciente->pac_ap_prim." ".$listDatosPaciente->pac_ap_seg." ".$listDatosPaciente->pac_nombre);
            $pdf->Text(15,56,'Domicilio:'.$listDatosPaciente->pac_direccion);
            $pdf->Text(120,41,'Historia Clinica:'.$listDatosPaciente->hc_id);
            $pdf->Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', 'http://www.tcpdf.org', '', true, 150, 'R', false, false, 0, false, false, false);
        });




        PDF::setFooterCallback(function($pdf) {
            $strCodSeguridad=session('institucion')->inst_codigo . '|' . session('institucion')->inst_nombre .'|' . Auth::user()->user_id;
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 10, 'Pagina '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 'T', false, 'R', 0, '', 0, false, 'T', 'M');
            //$pdf->write2DBarcode(bcrypt('Mi super codigo'), 'PDF417', 25, 275, 150, 6, null, 'N',true);
            $pdf->write2DBarcode($strCodSeguridad, 'PDF417', 25, 275, 150, 6, null, 'N',true);
        });
        PDF::SetTitle('My Report');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 50, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage('P', 'Letter');

        PDF::writeHTML(view('genericas.tabla',array('arr_tabla'=>$arr_tabla,'nombre_campos_form'=>$nombre_campos_form,'nombre_campos_tabla'=>$nombre_campos_tabla,'nombre_tabla'=>"recibo_recetario"))->render(), true, false, true, false, '');

        PDF::lastPage();
        PDF::Output('recibo_recetario.pdf','D');
    }
}
