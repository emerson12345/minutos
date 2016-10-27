<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Models\Rol;

class RolController extends Controller
{
    public function index(){
        $listRoles = Rol::paginate(2);
        return view('rol.index',['listRoles'=>$listRoles]);
    }

    public function create(){
        $rol = new Rol();
        return view('rol.form',['rol'=>$rol]);
    }

    public function edit($idRol){
        $rol = Rol::find($idRol);
        return view('rol.form',['rol'=>$rol]);
    }

    public function store(Request $request,$idRol = 0){
        $rol = new Rol();
        if($idRol)
            $rol = Rol::find($idRol);

        $this->validate($request,[
            'rol_nombre' => 'required',
            'rol_codigo' => 'required',
            'rol_seleccionable' => 'boolean'
        ],[
            'required' => 'Este campo es requerido.',
            'boolean' => 'Seleccione una opcion valida.'
        ]);
        //dd($request->all());
        $rol->fill($request->all())->save();

        return redirect()->route('rol.index');
    }
}
