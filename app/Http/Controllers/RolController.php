<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Sicere\Http\Requests;
use Sicere\Models\Rol;
use Yajra\Datatables\Datatables;

class RolController extends Controller
{
    public function index(){
        return view('rol.index');
    }
    public function roles(){
        return Datatables::of(Rol::all())->make(true);
    }
    public function create(){
        $rol = new Rol();
        return view('rol.form',['rol'=>$rol]);
    }

    public function edit($rol_id){
        $rol = Rol::find($rol_id);
        return view('rol.form',['rol'=>$rol]);
    }

    public function store(Request $request,$rol_id = 0){
        $rol = new Rol();
        if($rol_id)
            $rol = Rol::find($rol_id);
        $this->validate($request,[
            'rol_nombre' => ['required',Rule::unique('rol')->ignore($rol_id,'rol_id')],
            'rol_codigo' => ['required',Rule::unique('rol')->ignore($rol_id,'rol_id')],
            'rol_seleccionable' => 'boolean'
        ],[
            'required' => 'Este campo es requerido.',
            'boolean' => 'Seleccione una opcion valida.',
            'unique'=> 'Este valor ya ha sido registrado'
        ]);

        $rol->fill($request->all())->save();

        $this->setApp($rol,$request->app_list);
        return response()->json($rol);
    }

    private function setApp($rol,$apps = []){
        if(!is_array($apps)){
            $apps = [];
        }
        $rol->aplicaciones()->sync($apps);
    }
}
