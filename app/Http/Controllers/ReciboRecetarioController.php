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
use Sicere\Models\ReportTemplate;

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
            ->where('paciente_hc_receta.rec_med_nombre','=',$rec_med_nombre)
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

        $arr_tabla=DB::table("paciente_hc_receta")
                        ->where('paciente_hc_receta.hc_id','=',$hc_id)
                        ->select(
                            'ins_med_cod', 'rec_med_nombre', 'rec_indicaciones', 'rec_cantidad','rec_id as cod'
                        )
                        ->get()
                        ->toArray();

        $nombre_campos_form= array('Producto', 'Indicación', 'Cantidad');
        $nombre_campos_tabla= array('rec_med_nombre', 'rec_indicaciones', 'rec_cantidad');

        $listDatosPaciente=DB::table('paciente')
            ->join('paciente_hc','paciente_hc.pac_id','=','paciente.pac_id')
            ->join('paciente_hc_receta','paciente_hc_receta.hc_id','=','paciente_hc.hc_id')
            ->where('paciente_hc.hc_id','=',$hc_id)
            ->select('paciente_hc_receta.rec_fec_alta','paciente.pac_ap_prim','paciente.pac_sexo','paciente.pac_ap_seg','paciente.pac_nombre','paciente_hc.hc_id',
                'paciente.pac_direccion')
            ->first();
        $y=50;
        $x=16;

        $sexo="Mujer";
        if($listDatosPaciente->pac_sexo=="M")
            $sexo="Hombre";
        $dia=substr($listDatosPaciente->rec_fec_alta, 8,2);
        $mes=substr($listDatosPaciente->rec_fec_alta, 5,2);
        $anio=substr($listDatosPaciente->rec_fec_alta,0,4);

        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        PDF::SetFont('','B');
        ReportTemplate::printTitle('RECIBO RECETARIO');
        PDF::SetFont('','');

        PDF::Text($x,$y,'Paciente: '.$listDatosPaciente->pac_ap_prim." ".$listDatosPaciente->pac_ap_seg." ".$listDatosPaciente->pac_nombre);
        $y=$y+5;
        PDF::Text($x,$y,'Domicilio: '.$listDatosPaciente->pac_direccion);
        $y=$y+5;
        PDF::Text($x,$y,'Sexo: '.$sexo);
        PDF::Text(120,49,'Historia Clinica: '.$listDatosPaciente->hc_id);
        //PDF::Text(120,54,'Medico Responsable: '.Auth::user()->user_nombre);
        PDF::Text(120,54,'Fecha de Consulta: '.$dia."/".$mes."/".$anio);
        $y=$y+5;
        $strDiagnostico=DB::select("
      SELECT lib_registro.red_descripcion
      FROM lib_registro
         INNER JOIN lib_formulario ON (lib_registro.for_id = lib_formulario.for_id)
         INNER JOIN paciente_hc ON (lib_registro.pac_id = paciente_hc.pac_id)  AND (lib_registro.hc_id = paciente_hc.hc_id)
       WHERE
         (lib_formulario.col_id = 10 OR
         lib_formulario.col_id = 521) and paciente_hc.hc_id=".$hc_id." limit 1");/**/
        if(empty($strDiagnostico))
            $strNomDiagnostico= '';
        else{
            $strNomDiagnostico=DB::select("
      SELECT lib_registro.red_descripcion
      FROM lib_registro
         INNER JOIN lib_formulario ON (lib_registro.for_id = lib_formulario.for_id)
         INNER JOIN paciente_hc ON (lib_registro.pac_id = paciente_hc.pac_id)  AND (lib_registro.hc_id = paciente_hc.hc_id)
       WHERE
         (lib_formulario.col_id = 10 OR
         lib_formulario.col_id = 521) and paciente_hc.hc_id=".$hc_id." limit 1")[0]->red_descripcion;
        }
        
        PDF::Text($x,$y,'Diagnóstico: '.$strNomDiagnostico);

        PDF::Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', '', '', true, 150, 'R', false, false, 0, false, false, false);
        PDF::SetTitle('My Report');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 50, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //PDF::AddPage('P', 'Letter');

        PDF::writeHTML(view('recibo_recetario.reporte',array('arr_tabla'=>$arr_tabla,'nombre_campos_form'=>$nombre_campos_form,'nombre_campos_tabla'=>$nombre_campos_tabla,'nombre_tabla'=>"recibo_recetario"))->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('recibo_recetario.pdf','D');
    }
}
