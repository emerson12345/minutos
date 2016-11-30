<?php

namespace Sicere\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\Agenda;
use Sicere\Models\Paciente;
use Sicere\Models\Rrhh;
use PDF;
class AgendaController extends Controller
{
    public function index(){
        return view('agenda2.index');
    }

    public function create(){
        $agenda = new Agenda();
        $agenda->agenda_fec_ini = date('d/m/Y H:i');
        return view('agenda2.create',['agenda'=>$agenda]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'pac_id' => 'required | integer |exists:paciente',
            'agenda_fec_ini' => 'required | date_format:d/m/Y H:i',
            'duracion' => 'required | integer |min:15',
            'sesiones'=>'required | integer | min:1',
            'agenda_actividad'=>'max:50',
            'dia'=>'required_unless:sesiones,1'
        ],[
            'required' => 'Este campo es requerido',
            'exists' => 'Este campo no esta registrado en la base de datos',
            'date_format' => 'El formato de fecha y hora no es valido',
            'integer' => 'El campo debe ser entero',
            'min' => 'Valor fuera de rango',
            'agenda_actividad.max'=> 'El tamaño maximo es de 50 caracteres',
            'dia.required_unless' => 'Debe seleccionar al menos un dia para mas de una sesion'
        ]);


        DB::transaction(function() use ($request){
            $institucion = session('institucion');
            $date = Carbon::createFromFormat('d/m/Y H:i',$request->agenda_fec_ini);
            $hour = $date->hour; $minutes = $date->minute;
            $dows = [1];
            if($request->dia)
                $dows=$request->dia;
            $agenda = new Agenda($request->all());
            $agenda->agenda_fec_ini = $date->format('d/m/Y H:i');
            $agenda->agenda_fec_fin = $date->addMinutes($request->duracion)->format('d/m/Y H:i');
            $agenda->inst_id = $institucion->inst_id;
            $agenda->user_id = \Auth::user()->user_id;
            $color = $agenda->randomColor();
            $agenda->agenda_color = $color;
            $agenda->save();
            $i=1;
            while($i<$request->sesiones){
                do{
                    $date->addDays(1);
                }while (!in_array($date->dayOfWeek,$dows));
                $date->hour= $hour;
                $date->minute = $minutes;
                $agenda = new Agenda($request->all());
                $agenda->agenda_fec_ini = $date->format('d/m/Y H:i');
                $agenda->agenda_fec_fin = $date->addMinutes($request->duracion)->format('d/m/Y H:i');
                $agenda->inst_id = $institucion->inst_id;
                $agenda->user_id = \Auth::user()->user_id;
                $agenda->agenda_color = $color;
                $agenda->save();
                $i++;
            }
        });
        return response()->json(['success'=>true]);
    }

    public function pacientes(Request $request){
        $query = $request->input('query')?$request->input('query').'%':'';

        $lista = Paciente::select('pac_id as id','pac_nro_hc as nro_hc','pac_edad_anio as edad','pac_nro_ci as nro_ci',DB::raw("ltrim(concat_ws(' ',pac_ap_prim,pac_ap_seg,pac_nombre)) as text"))
            ->whereRaw('upper(ltrim(concat_ws(\' \',pac_ap_prim,pac_ap_seg,pac_nombre))) like upper(?)',$query)
            ->orWhere('pac_nro_ci','like',$query)->get();
        return response()->json($lista);
    }

    public function medicos(Request $request){
        $query = $request->input('query')?$request->input('query').'%':'';
        $lista = Rrhh::select('rrhh_id as id','rrhh_ci as nro_ci',DB::raw("ltrim(concat_ws(' ',rrhh_ap_prim,rrhh_ap_seg,rrhh_nombre)) as text"))
            ->whereRaw("upper(ltrim(concat_ws(' ',rrhh_ap_prim,rrhh_ap_seg,rrhh_nombre))) like upper(?)",$query)
            ->orWhere('rrhh_ci','like',$query)->get();
        return response()->json($lista);
    }

    public function view(){
        return view('agenda.view');
    }

    public function viewReport(Request $request){
        $user = $request->user_id?:0;
        $fec_ini = $request->fec_ini?:date('d/m/Y');
        $fec_fin = $request->fec_fin?:date('d/m/Y');

        PDF::setHeaderCallback(function($pdf) {
            $pdf->Cell(0, 27, '', 'B', false, 'R', 0, '', 0, false, 'T', 'M');
            $pdf->Image(asset('template/dist/img/bolivia.gif'), 15, 10, 0, 15, 'GIF', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Text(33,22,'Sistema de centros de rehabilitación','R');
            $pdf->SetFont('helvetica', 'K', 10);
            $pdf->Text(15,27,'Establecimiento: '.session('institucion')->inst_nombre);
            $pdf->Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', 'http://www.tcpdf.org', '', true, 150, 'R', false, false, 0, false, false, false);
        });
        PDF::setFooterCallback(function($pdf) {
            $strCodSeguridad=session('institucion')->inst_codigo . '|' . session('institucion')->inst_nombre .'|' . \Auth::user()->user_id;
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 10, 'Pagina '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 'T', false, 'R', 0, '', 0, false, 'T', 'M');
            //$pdf->write2DBarcode(bcrypt('Mi super codigo'), 'PDF417', 25, 275, 150, 6, null, 'N',true);
            $pdf->write2DBarcode($strCodSeguridad, 'PDF417', 25, 275, 150, 6, null, 'N',true);
        });
        PDF::SetTitle('Agenda');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 30, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage('P', 'Letter');
        /*
        $eventos = DB::table('agenda')
            ->join('paciente','paciente.pac_id','=','agenda.pac_id')
            ->select('agenda.agenda_fec_ini'
                ,'agenda.agenda_descripcion'
                ,DB::raw("ltrim( concat_ws(' ',paciente.pac_ap_prim,paciente.pac_ap_seg,paciente.pac_nombre) ) as nombre_paciente"))
            ->whereBetween(DB::raw('agenda_fec_ini::DATE'),[$fec_ini,$fec_fin])
            ->where('agenda.user_id',$user)->get();
        */
        $fecha_inicio = Carbon::createFromFormat('d/m/Y',$fec_ini);
        $fecha_fin = Carbon::createFromFormat('d/m/Y',$fec_fin);
        while($fecha_inicio->lte($fecha_fin)){
            PDF::Cell(0,0,$fecha_inicio->format('d/m/Y'),1,2);
            $fecha_inicio->addDay();
        }
        PDF::lastPage();
        PDF::Output('agenda.pdf','I');
    }

    public function getEvents(Request $request){
        $fec_ini = $request->fec_ini?:date('d/m/Y');
        $fec_fin = $request->fec_fin?:date('d/m/Y');
        $user_id = $request->user_id?:0;
        $eventos = DB::table('agenda')
            ->join('paciente','paciente.pac_id','=','agenda.pac_id')
            ->select('agenda.agenda_fec_ini as start'
                ,'agenda.agenda_fec_fin as end'
                ,'agenda.agenda_color as backgroundColor'
                ,DB::raw("ltrim( concat_ws(' ',paciente.pac_ap_prim,paciente.pac_ap_seg,paciente.pac_nombre) ) as title"))
            ->whereBetween(DB::raw('agenda_fec_ini::DATE'),[$fec_ini,$fec_fin])
            ->where('agenda.user_id',$user_id)->get();

        return response()->json($eventos);
    }
}
