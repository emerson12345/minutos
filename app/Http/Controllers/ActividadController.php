<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\InstitucionActividad;
use Yajra\Datatables\Datatables;

class ActividadController extends Controller
{
    public function actividades(){
        return Datatables::of(InstitucionActividad::all())->make(true);
    }

    public function index(){
        return view('actividad.index');
    }

    public function create(){
        $actividad = new InstitucionActividad();
        return view('actividad.form',['actividad'=>$actividad]);
    }
    
    public function store(Request $request){
        return view('hola mundo');
    }
}
