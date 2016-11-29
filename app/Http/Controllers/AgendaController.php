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
            'rrhh_id' => 'required | integer |exists:rrhh',
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
}
