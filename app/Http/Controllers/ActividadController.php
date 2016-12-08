<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Sicere\Models\Institucion;
use Sicere\Models\InstitucionActividad;
use Sicere\Models\ReportTemplate;
use Yajra\Datatables\Datatables;

class ActividadController extends Controller
{
    public function actividades(){
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $institucion = Institucion::find($inst_id);
        return Datatables::of($institucion->actividades)->make(true);
    }

    public function index(){
        return view('actividad.index');
    }

    public function create(){
        $actividad = new InstitucionActividad();
        return view('actividad.form',['actividad'=>$actividad]);
    }

    public function update($act_id = 0){
        $actividad = InstitucionActividad::find($act_id);
        if(!$actividad)
            $actividad = new InstitucionActividad();
        return view('actividad.form',['actividad'=>$actividad]);
    }
    
    public function store(Request $request,$act_id = 0){
        $user_id = \Auth::check()?\Auth::user()->user_id:0;
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;

        $actividad = $act_id != 0? InstitucionActividad::find($act_id):new InstitucionActividad();

        $this->validate($request,[
            'act_fecha'=>'required|date_format:d/m/Y',
            'act_apellido_nombre'=>'max:120',
            'act_nro_educativas_familia'=>'integer',
            'act_seleccionable'=>'boolean'
        ],[
            'required'=>'Este campo es requerido',
            'max'=> 'El maximo de caracteres permitidos es :max',
            'integer'=>'El campo debe ser un numero '
        ]);
        $actividad->fill($request->all());
        $actividad->user_id = $user_id;
        $actividad->inst_id = $inst_id;
        if(!$actividad->exists)
            $actividad->act_nro = $actividad->max_nro_orden()+1;
        $actividad->save();
        return response()->json($actividad);
    }

    public function report(){
        $inst = session()->has('institucion')?session('institucion')->inst_id:0;
        $institucion = Institucion::find($inst);
        $actividades = $institucion->actividades;
        ReportTemplate::printHeaderFooter();
        PDF::AddPage('L', 'Letter');
        PDF::SetFont('','B');
        ReportTemplate::printTitle('ACTIVIDADES DEL SERVICIO DE REHABILITACION');
        $y = 105;
        PDF::SetFillColor(200);
        PDF::SetFont("","B",10);
        PDF::SetY($y);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::Cell(60,21,'Nº de orden',1,2,'C',true);
        PDF::StopTransform();
        PDF::SetY($y);PDF::SetX(36);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::Cell(60,21,'Fecha',1,2,'C',true);
        PDF::StopTransform();
        PDF::SetFont("","B",8);
        PDF::SetY($y);PDF::SetX(57);
        PDF::Cell(50,60,'Apellidos y nombres (profesional)',1,2,'C',true,null,1,false,'B');
        PDF::SetY($y);PDF::SetX(107);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::MultiCell(60, 21, 'Nº Actividades educativas de rehabilitacion enfocadas a la familia' , 1, 'C', true,1,null,null,true,0,false,false,21,'M');
        PDF::StopTransform();
        PDF::SetY($y);PDF::SetX(128);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::MultiCell(60, 21, 'Nº Actividades realizadas con participación de la comunidad' , 1, 'C', true,1,null,null,true,0,false,false,21,'M');
        PDF::StopTransform();
        PDF::SetY($y);PDF::SetX(149);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::MultiCell(60, 21, 'Nº CAI de Servicio de Rehabilitacion' , 1, 'C', true,1,null,null,true,0,false,false,21,'M');
        PDF::StopTransform();
        PDF::SetY($y);PDF::SetX(170);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::MultiCell(60, 21, 'Nº Comunidades y/o Organizaciones Sociales que participaron en el CAI del Servicio de Rehabilitacion' , 1, 'C', true,1,null,null,true,0,false,false,21,'M');
        PDF::StopTransform();
        PDF::SetY($y);PDF::SetX(191);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::MultiCell(60, 21, 'Nº Reuniones Comites Loc De Salud Mun Salud' , 1, 'C', true,1,null,null,true,0,false,false,21,'M');
        PDF::StopTransform();
        PDF::SetY($y);PDF::SetX(212);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::MultiCell(60, 21, 'Supervisiones al Servio de Rehabilitacion' , 1, 'C', true,1,null,null,true,0,false,false,21,'M');
        PDF::StopTransform();
        PDF::SetY($y);PDF::SetX(233);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::MultiCell(60, 21, 'Nº Auditorias internas en salud en aplicación de norma técnica' , 1, 'C', true,1,null,null,true,0,false,false,21,'M');
        PDF::StopTransform();
        PDF::SetY($y);PDF::SetX(254);
        PDF::StartTransform();
        PDF::Rotate(90);
        PDF::MultiCell(60, 21, 'Nº Actividades educativas en salud' , 1, 'C', true,1,null,null,true,0,false,false,21,'M');
        PDF::StopTransform();
        PDF::SetXY(15,105);
        PDF::SetFont('');

        for($i = 0;$i<30;$i++)
        foreach ($actividades as $actividad){
            PDF::Cell(21,7,$actividad->act_nro,1,0,'C');
            PDF::Cell(21,7,date('d/m/Y',strtotime($actividad->act_nro)),1,0,'C');
            PDF::Cell(50,7,$actividad->act_apellido_nombre,1);
            PDF::Cell(21,7,$actividad->act_nro_educativas_familia,1,0,'C');
            PDF::Cell(21,7,$actividad->act_nro_comunidad,1,0,'C');
            PDF::Cell(21,7,$actividad->act_nro_cai,1,0,'C');
            PDF::Cell(21,7,$actividad->act_nro_cai_os,1,0,'C');
            PDF::Cell(21,7,$actividad->act_nro_comite_salud,1,0,'C');
            PDF::Cell(21,7,$actividad->act_nro_supervision,1,0,'C');
            PDF::Cell(21,7,$actividad->act_nro_auditoria,1,0,'C');
            PDF::Cell(21,7,$actividad->act_nro_educativas_salud,1,0,'C');
            PDF::Ln();
        }
        PDF::lastPage();
        PDF::Output('produccion.pdf');
    }
}
