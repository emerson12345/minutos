<?php

namespace Sicere\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use PDF;
use Sicere\Http\Requests;
use Sicere\Models\Agenda;
use Sicere\Models\LibCuaderno;
use Sicere\Models\Paciente;
use Sicere\Models\ReportTemplate;
use Sicere\Models\Rrhh;

class AgendaController extends Controller
{
    public function index(){
        return view('agenda2.index');
    }

    public function create(){
        $agenda = new Agenda();
        $agenda->agenda_fec_ini = date('d/m/Y H:i');
        return view('agenda.create',['agenda'=>$agenda]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'pac_id' => 'required | integer |exists:paciente',
            'cua_id'=>'required',
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
            $agenda_padre = $agenda->agenda_id;
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
                $agenda->agenda_id_padre = $agenda_padre;
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
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $query = $request->input('query')?$request->input('query').'%':'';
        $lista = Rrhh::select('rrhh_id as id','rrhh_ci as nro_ci',DB::raw("ltrim(concat_ws(' ',rrhh_ap_prim,rrhh_ap_seg,rrhh_nombre)) as text"))
            ->where('inst_id',$inst_id)
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
        $cua_id = $request->cua_id?:0;
        $cuaderno = LibCuaderno::find($cua_id);
        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        ReportTemplate::printTitle('CITAS PROGRAMADAS');
        PDF::SetFont('');
        PDF::writeHTML("<b>Desde el </b> {$fec_ini} <b>hasta el</b> {$fec_fin}");
        PDF::writeHTML("<b>Servicio: </b> {$cuaderno->cua_nombre}");
        PDF::writeHTML("<b>A</b> Agendado, <b>T</b> Atendido, <b>N</b> No atendido, <b>C</b> Cancelado");
        $fecha_inicio = Carbon::createFromFormat('d/m/Y',$fec_ini);
        $fecha_fin = Carbon::createFromFormat('d/m/Y',$fec_fin);
        PDF::SetFillColor(200);
        PDF::SetFont('','B');
        $cabecera = [['title'=>'Fecha','width'=>20],
            ['title'=>'Usuario','width'=>30],
            ['title'=>'Est.','width'=>10],
            ['title'=>'Paciente','width'=>50],
            ['title'=>'Descripción','width'=>70]
        ];
        foreach ($cabecera as $item){
            PDF::Cell($item['width'],5,$item['title'],1,0,'',1);
        }
        PDF::Ln();
        PDF::SetFont('');
        while($fecha_inicio->lte($fecha_fin)){
            //PDF::Cell(30,5,$fecha_inicio->format('d/m/Y'),1,2);
            $eventos = Agenda::where(DB::raw('agenda_fec_ini::DATE'),$fecha_inicio->format('d/m/Y'))
                ->where('user_id',$user==0?'<>':'=',$user)
                ->where('cua_id',$cua_id)->get();
            $height = 0;
            if($eventos->count()){
                foreach ($eventos as $evento){
                    PDF::setX(35);
                    PDF::Cell(30,5,$evento->usuario->user_nombre,1,0,'',0,null,1);
                    PDF::Cell(10,5,$evento->agenda_estado,1,0,'',0,null,1);
                    PDF::Cell(50,5,$evento->paciente->nombreCompleto,1,0,'',0,null,1);
                    PDF::Cell(70,5,$evento->agenda_descripcion,1,2,'',0,null,1);
                    $height+=5;
                }
                PDF::SetX(15);
                PDF::SetY(PDF::GetY()-$height);
                PDF::Cell(20,$height,$fecha_inicio->format('d/m/Y'),1,1,'',0,null,1);
            }
            $fecha_inicio->addDay();
        }
        PDF::lastPage();
        PDF::Output('agenda.pdf','I');
    }

    public function getEvents(Request $request){
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $fec_ini = $request->fec_ini?:date('d/m/Y');
        $fec_fin = $request->fec_fin?:date('d/m/Y');
        $user_id = $request->user_id?:0;
        $cua_id = $request->cua_id?:0;
        $eventos = DB::table('agenda')
            ->join('paciente','paciente.pac_id','=','agenda.pac_id')
            ->select('agenda.agenda_fec_ini as start'
                ,'agenda.agenda_fec_fin as end'
                ,'agenda.agenda_color as backgroundColor'
                ,DB::raw("ltrim( concat_ws(' ',paciente.pac_ap_prim,paciente.pac_ap_seg,paciente.pac_nombre) ) as title"))
            ->whereBetween(DB::raw('agenda_fec_ini::DATE'),[$fec_ini,$fec_fin])
            ->where('agenda.user_id',$user_id==0?'<>':'=',$user_id)
            ->where('agenda.inst_id',$inst_id)
            ->where('agenda.cua_id',$cua_id)->get();
        return response()->json($eventos);
    }

    public function agenda(Request $request){
        return view('agenda.agenda');
    }
    
    public function getAgenda(Request $request){
        $user_id = \Auth::user()->user_id;
        $fec_ini = $request->fec_ini?:data('d/m/Y');
        $fec_fin = $request->fec_fin?:data('d/m/Y');
        $cua_id = $request->cua_id?:0;
        $eventos = Agenda::whereBetween(DB::raw('agenda_fec_ini::DATE'),[$fec_ini,$fec_fin])
            ->where('user_id',$user_id)
            ->where('cua_id',$cua_id)->orderBy('agenda_fec_ini','asc')->get();
        return view('agenda._tableAgenda',['eventos'=>$eventos]);
    }

    public function change(Request $request){
        $agenda_id = $request->agenda_id?:0;
        $agenda_estado = $request->agenda_estado?:'A';
        Agenda::where('agenda_id',$agenda_id)->update(['agenda_estado'=>$agenda_estado]);
        return response()->json(['success'=>true]);
    }
}
