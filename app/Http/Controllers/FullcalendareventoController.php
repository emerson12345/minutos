<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Fullcalendarevento;
use Sicere\Models\LibCuaderno;
use Sicere\Models\Agenda;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FullcalendareventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $listCuadernosSearch=LibCuaderno::all()
            ->pluck('cua_nombre','cua_id');
        return view('Agenda.index',array('listCuadernosSearch'=>$listCuadernosSearch));
    }
    public function index()
    {
        $user_id=Auth::user()->user_id;
        $data = array(); //declaramos un array principal que va contener los datos
        $id = Agenda::all()->where("user_id","=",$user_id)->pluck('agenda_id'); //listamos todos los id de los eventos

        $descripcion = Agenda::all()->where("user_id","=",$user_id)->pluck('agenda_descripcion'); //lo mismo para lugar y fecha

        $titulo = DB::table('v_paciente_nombres')
            ->join('agenda', 'agenda.pac_id', '=', 'v_paciente_nombres.pac_id')
            ->where('agenda.user_id', '=', $user_id)
            ->select('v_paciente_nombres.paciente_nombres')
            ->pluck('paciente_nombres');

        $fechaIni = Agenda::all()->where("user_id","=",$user_id)->pluck('agenda_fec_ini');
        $fechaFin = Agenda::all()->where("user_id","=",$user_id)->pluck('agenda_fec_fin');
        $allDay = Agenda::all()->where("user_id","=",$user_id)->pluck('agenda_todo_dia');
        $background = Agenda::all()->where("user_id","=",$user_id)->pluck('agenda_color');
        $count = count($id); //contamos los ids obtenidos para saber el numero exacto de eventos

        //hacemos un ciclo para anidar los valores obtenidos a nuestro array principal $data
        for($i=0;$i<$count;$i++){
            $data[$i] = array(
                "title"=>$titulo[$i].": ".$descripcion[$i], //obligatoriamente "title", "start" y "url" son campos requeridos
                "start"=>$fechaIni[$i], //por el plugin asi que asignamos a cada uno el valor correspondiente
                "end"=>$fechaFin[$i],
                "allDay"=>$allDay[$i],
                "backgroundColor"=>$background[$i],
                "id"=>$id[$i]
                //"url"=>"cargaEventos".$id[$i]
                //en el campo "url" concatenamos el el URL con el id del evento para luego
                //en el evento onclick de JS hacer referencia a este y usar el método show
                //para mostrar los datos completos de un evento
            );
        }
        json_encode($data); //convertimos el array principal $data a un objeto Json
        return $data; //para luego retornarlo y estar listo para consumirlo
    }
    public function create(){
        //Valores recibidos via ajax
        $title = $_POST['title'];
        $start = $_POST['start'];
        $back = $_POST['background'];

        //Insertando evento a base de datos
        $evento=new Agenda;
        $evento->agenda_fec_ini=$start;
        //$evento->fechaFin=$end;
        $evento->agenda_todo_dia=true;
        $evento->agenda_color=$back;
        $evento->agenda_descripcion=$title;
        $evento->pac_id=1;
        $evento->inst_id=1;
        $evento->rrhh_id=5;
        $evento->agenda_estado='A';


        //echo "\t \t \t".$evento;
        $evento->save();
    }
    public function update(){

        //Valores recibidos via ajax
        $id = $_POST['id'];
        $title = $_POST['title'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $allDay = $_POST['allday'];
        $back = $_POST['background'];

        $agenda_estado = DB::table('agenda')
            ->where('agenda.agenda_id', '=', $id)
            ->select('*')
            ->first();
        if($agenda_estado->agenda_estado=="A")
        {
            $evento=Agenda::find($id);
            if($end=='NULL'){
                $evento->agenda_fec_fin=NULL;
            }else{
                $evento->agenda_fec_fin=$end;
            }
            $evento->agenda_fec_ini=$start;
            $evento->agenda_todoeldia=$allDay;
            $evento->agenda_color=$back;
            //$evento->agenda_descripcion=$title;
            //$evento->fechaFin=$end;
            $evento->save();
        }
        else
        {
            $evento=Agenda::find($id);
            $evento->save();
        }
        //return $agenda_estado->agenda_estado;
        //dd($agenda_estado);
    }

    public function delete(){
        //Valor id recibidos via ajax
        $id = $_POST['id'];

        Agenda::destroy($id);
    }
    public function reporteSemanal($fecha_inicio)
    {
        //2016-10-10
        //echo $fecha_inicio;

        //echo "reporte7";
        //print_r(session('institucion'));


        $anio=
        $arrCalendario="";
        //$var =date('w'); Dia actual

        for($i=0;$i<7;$i++)
        {
            $time = strtotime($fecha_inicio);
            $var = date('w',$time);
            //$var =date('w');

            $valor=(($i+1)-$var);
            //$fecha = date('Y-m-j');

            $time = strtotime($fecha_inicio);
            $fecha = date('Y-m-j',$time);

            $nuevafecha = strtotime ($valor." day" , strtotime ( $fecha ) ) ;
            $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
            $anio=substr($nuevafecha, 0, 4);
            $mes=substr($nuevafecha, 5, 2);
            $dia=substr($nuevafecha, 8, 2);
            $listCalendario = DB::select("
                select \"agenda_fec_ini\",
                \"agenda_fec_fin\",agenda_descripcion,
                extract(HOUR from  \"agenda_fec_ini\") as hora_inicio,
                extract(HOUR from  \"agenda_fec_fin\") as hora_fin
                from agenda
                where extract(year from  \"agenda_fec_ini\")='".$anio."'
                and extract(DAY from  \"agenda_fec_ini\")='".$dia."'
                and extract(MONTH from  \"agenda_fec_ini\")='".$mes."'
                order by \"agenda_fec_ini\"
               ");
            $arrCalendario[$i]=$listCalendario;
        }
        PDF::setHeaderCallback(function($pdf) {
            $pdf->Cell(0, 27, '', 'B', false, 'R', 0, '', 0, false, 'T', 'M');
            //$pdf->Image(asset('template/dist/img/bolivia.gif'), 15, 10, 0, 15, 'GIF', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);

            $P=base_path()."\\public\\template\\dist\\img\\bolivia.gif";
            $pdf->Image($P, 15, 10, 0, 15, 'GIF', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Text(33,22,'Sistema de centros de rehabilitación','R');
            $pdf->SetFont('helvetica', 'K', 10);
            $pdf->Text(15,27,'Establecimiento: '.session('institucion')->inst_nombre);
            //$pdf->Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', 'http://www.tcpdf.org', '', true, 150, 'R', false, false, 0, false, false, false);
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
        PDF::SetMargins(15, 30, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage('P', 'Letter');

        PDF::writeHTML(view('Agenda.reporteSemanal',array('arrCalendario'=>$arrCalendario))->render(), true, false, true, false, '');

        PDF::lastPage();
        PDF::Output('usuario12.pdf','I');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


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
