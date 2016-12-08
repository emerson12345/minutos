<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Sicere\Http\Controllers\Controller;
use PDF;
use Sicere\Models\ExamenesTipo;
use Sicere\Models\ReportTemplate;

class PacienteHcComplementarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // echo "djfalksdfjñldkas";
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
    public function store($ec_indicador=0,$ec_resultado=0,$ec_solicitado=0)
    {
        $urlexamenComplementariodestroy = asset('examen_complementario/destroy/');


        $hc_id=DB::select('select max(hc_id) from paciente_hc')[0]->max;

        $countExaComplementario=DB::table('paciente_hc_complementario')
            ->where('paciente_hc_complementario.exc_tip_id','=',$ec_indicador)
            ->where('paciente_hc_complementario.hc_id','=',$hc_id)
            ->count();

        if($countExaComplementario==0){
            if(($ec_resultado==-1 || $ec_solicitado==-1)==false)
            {
                DB::table('paciente_hc_complementario')->insert(
                    [
                        'hc_com_solicitud'=>$ec_solicitado,
                        'exc_tip_id'=>$ec_indicador,
                        'user_id'=>Auth::user()->user_id,
                        'hc_id'=>$hc_id,
                        'hc_com_resultado'=>$ec_resultado
                    ]
                );
            }

        }
        $listPacienteExamenComplementario=DB::table('paciente_hc_complementario')
            ->join('examenes_tipo','paciente_hc_complementario.exc_tip_id','=','examenes_tipo.exc_tip_id')
            ->where('paciente_hc_complementario.hc_id','=',$hc_id)
            ->select('paciente_hc_complementario.hc_com_id','paciente_hc_complementario.hc_id','examenes_tipo.exc_tip_nombre',
                'paciente_hc_complementario.exc_tip_id','paciente_hc_complementario.hc_com_fecha','paciente_hc_complementario.hc_com_resultado',
                'paciente_hc_complementario.hc_com_solicitud')
            ->get();

        return view('examen_complementario.list_examen_complementario',['listPacienteExamenComplementario'=>$listPacienteExamenComplementario,'urlexamenComplementariodestroy'=>$urlexamenComplementariodestroy]);
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
    public function edit($hc_com_id)
    {
        //// Examenes complementarios    ///////////////////////////////////////////////////////////////////////////////
        $listExamenComplementario=DB::table("paciente_hc_complementario")
            ->join("examenes_tipo","examenes_tipo.exc_tip_id","=","paciente_hc_complementario.exc_tip_id")
            ->where("paciente_hc_complementario.hc_com_id","=",$hc_com_id)
            ->select("paciente_hc_complementario.hc_com_id as cod","paciente_hc_complementario.hc_com_fec_alta",
                "paciente_hc_complementario.hc_com_solicitud","paciente_hc_complementario.hc_com_resultado",
                "paciente_hc_complementario.exc_tip_id","examenes_tipo.exc_tip_nombre")
            ->first();
        $listExamenesTipo=ExamenesTipo::all()->pluck('exc_tip_nombre','exc_tip_id');
        $url_examen_complementario_update=asset("examen_complementario/update");

        return view('examen_complementario.edit',
        array(
            'listExamenComplementario'=>$listExamenComplementario,
            'listExamenesTipo'=>$listExamenesTipo
            )
        )->with(array('url_examen_complementario_update'=>$url_examen_complementario_update));

        //view('genericas.tabla',array('arr_tabla'=>$arr_tabla,'nombre_campos_form'=>$nombre_campos_form,'nombre_campos_tabla'=>$nombre_campos_tabla,'nombre_tabla'=>"examen_complementario"))->render()
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($hc_com_id,$hc_com_resultado)
    {
        DB::table('paciente_hc_complementario')
            ->where('hc_com_id',$hc_com_id)
            ->update(
                ['hc_com_resultado'=>$hc_com_resultado]
            );


        $listExamenComplementario=DB::table("paciente_hc_complementario")
            ->join("examenes_tipo","examenes_tipo.exc_tip_id","=","paciente_hc_complementario.exc_tip_id")
            ->where("paciente_hc_complementario.hc_com_id","=",$hc_com_id)
            ->select("paciente_hc_complementario.hc_com_id as cod","paciente_hc_complementario.hc_com_fec_alta",
                "paciente_hc_complementario.hc_com_solicitud","paciente_hc_complementario.hc_com_resultado",
                "paciente_hc_complementario.exc_tip_id","examenes_tipo.exc_tip_nombre")
            ->first();
        $listExamenesTipo=ExamenesTipo::all()->pluck('exc_tip_nombre','exc_tip_id');
        $url_examen_complementario_update=asset("examen_complementario/update");

        return view('examen_complementario.edit',
            array(
                'listExamenComplementario'=>$listExamenComplementario,
                'listExamenesTipo'=>$listExamenesTipo
            )
        )->with(array('url_examen_complementario_update'=>$url_examen_complementario_update));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $urlexamenComplementariodestroy = asset('examen_complementario/destroy/');

        DB::table('paciente_hc_complementario')->where('paciente_hc_complementario.hc_com_id', $id)->delete();

        $hc_id=DB::select('select max(hc_id) from paciente_hc')[0]->max;


        $listPacienteExamenComplementario=DB::table('paciente_hc_complementario')
            ->join('examenes_tipo','paciente_hc_complementario.exc_tip_id','=','examenes_tipo.exc_tip_id')
            ->where('paciente_hc_complementario.hc_id','=',$hc_id)
            ->select('paciente_hc_complementario.hc_com_id','paciente_hc_complementario.hc_id','examenes_tipo.exc_tip_nombre',
                'paciente_hc_complementario.exc_tip_id','paciente_hc_complementario.hc_com_fecha','paciente_hc_complementario.hc_com_resultado',
                'paciente_hc_complementario.hc_com_solicitud')
            ->get();

        return view('examen_complementario.list_examen_complementario',['listPacienteExamenComplementario'=>$listPacienteExamenComplementario,'urlexamenComplementariodestroy'=>$urlexamenComplementariodestroy]);
    }
    public function  report_general($hc_com_id)
    {

        $nombre_campos_form= array('Tipo de examen', 'Examen solicitado', 'Resultado','cod');
        $nombre_campos_tabla= array('exc_tip_nombre', 'hc_com_solicitud', 'hc_com_resultado','cod');

        $hc_id=DB::table('paciente_hc_complementario')
            ->join('paciente_hc','paciente_hc.hc_id','=','paciente_hc_complementario.hc_id')
            ->where('paciente_hc_complementario.hc_com_id','=',$hc_com_id)
            ->select('paciente_hc.hc_id')
            ->first()->hc_id;


        $arr_tabla=DB::table("paciente_hc_complementario")
            ->join("examenes_tipo","examenes_tipo.exc_tip_id","=","paciente_hc_complementario.exc_tip_id")
            ->select("paciente_hc_complementario.hc_com_id as cod","paciente_hc_complementario.hc_id","examenes_tipo.exc_tip_nombre"
                ,"paciente_hc_complementario.exc_tip_id","paciente_hc_complementario.hc_com_fecha","paciente_hc_complementario.hc_com_resultado"
                ,"paciente_hc_complementario.hc_com_solicitud"
            )
            ->where("paciente_hc_complementario.hc_id","=",$hc_id)
            ->get()
            ->toArray();


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

            $pdf->Text(80,31,'EXAMEN COMPLEMENTARIO');

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


        PDF::writeHTML(view('genericas.tabla',array('arr_tabla'=>$arr_tabla,'nombre_campos_form'=>$nombre_campos_form,'nombre_campos_tabla'=>$nombre_campos_tabla,'nombre_tabla'=>"examen_complementario"))->render(), true, false, true, false, '');

        PDF::lastPage();
        PDF::Output('recibo_recetario.pdf','D');
    }
    public function  report($rec_id)
    {
        $hc_id=DB::select('select max(hc_id) from paciente_hc')[0]->max;

        //$arr_tabla=DB::select("select * from paciente_hc_receta");

        $arr_tabla=DB::table("paciente_hc_complementario")
            ->join("examenes_tipo","examenes_tipo.exc_tip_id","=","paciente_hc_complementario.exc_tip_id")
            ->select("paciente_hc_complementario.hc_com_id as cod","paciente_hc_complementario.hc_id","examenes_tipo.exc_tip_nombre"
            ,"paciente_hc_complementario.exc_tip_id","paciente_hc_complementario.hc_com_fecha","paciente_hc_complementario.hc_com_resultado"
                ,"paciente_hc_complementario.hc_com_solicitud"
            )
            ->where("paciente_hc_complementario.hc_id","=",$hc_id)
            ->get()
            ->toArray();

        $nombre_campos_form= array('Tipo de examen', 'Examen solicitado', 'Resultado','cod');
        $nombre_campos_tabla= array('exc_tip_nombre', 'hc_com_solicitud', 'hc_com_resultado','cod');

        $listDatosPaciente=DB::table('paciente')
            ->join('paciente_hc','paciente_hc.pac_id','=','paciente.pac_id')
            ->join('paciente_hc_complementario','paciente_hc.hc_id','=','paciente_hc_complementario.hc_id')
            ->where('paciente_hc.hc_id','=',$hc_id)
            ->select('paciente_hc_complementario.hc_com_fec_alta','paciente.pac_sexo','paciente.pac_ap_prim','paciente.pac_ap_seg','paciente.pac_nombre','paciente_hc.hc_id',
                'paciente.pac_direccion')
            ->first();

        $y=50;
        $x=16;
        $sexo="Mujer";
        if($listDatosPaciente->pac_sexo=="M")
            $sexo="Hombre";
        $dia=substr($listDatosPaciente->hc_com_fec_alta, 8,2);
        $mes=substr($listDatosPaciente->hc_com_fec_alta, 5,2);
        $anio=substr($listDatosPaciente->hc_com_fec_alta,0,4);

        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        PDF::SetFont('','B');
        ReportTemplate::printTitle('EXAMEN COMPLEMENTARIO');
        PDF::SetFont('','');

        PDF::Text($x,$y,'Paciente: '.$listDatosPaciente->pac_ap_prim." ".$listDatosPaciente->pac_ap_seg." ".$listDatosPaciente->pac_nombre);
        $y=$y+5;
        PDF::Text($x,$y,'Domicilio: '.$listDatosPaciente->pac_direccion);
        $y=$y+5;
        PDF::Text($x,$y,'Sexo: '.$sexo);
        PDF::Text(120,49,'Historia Clinica: '.$listDatosPaciente->hc_id);
        //PDF::Text(120,54,'Medico Responsable: '.Auth::user()->user_nombre);
        PDF::Text(120,54,'Fecha de Consulta: '.$dia."/".$mes."/".$anio);
        PDF::Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', 'http://www.tcpdf.org', '', true, 150, 'R', false, false, 0, false, false, false);
        PDF::SetTitle('My Report');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 50, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //PDF::AddPage('P', 'Letter');

        PDF::writeHTML(view('examen_complementario.reporte',array('arr_tabla'=>$arr_tabla,'nombre_campos_form'=>$nombre_campos_form,'nombre_campos_tabla'=>$nombre_campos_tabla,'nombre_tabla'=>"recibo_recetario"))->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('recibo_recetario.pdf','D');
    }
}
