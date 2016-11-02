<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Sicere\Http\Requests;
use Sicere\User;
use Yajra\Datatables\Datatables;

class UsuarioController extends Controller
{
    public function index(){
        return view('usuario.index');
    }

    public function users(){
        return Datatables::of(User::all())->make(true);
    }

    public function create(){
        $usuario = new User();
        return view('usuario.create',[ 'usuario' => $usuario ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'user_nombre' => 'required',
            'user_codigo' => 'required| unique:usuario,user_codigo',
            'user_password' => 'required',
            'user_password2' => 'required| same:user_password',
            'user_email' => 'email| unique:usuario,user_email',
            'user_seleccionable' => 'boolean'
        ],[
            'required' => 'Este campo es requerido.',
            'user_password2.same' => 'Las contraseñas no coinciden.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.',
            'unique' => 'Este valor ya ha sido registrado'
        ]);

        $usuario = User::create($request->all());
        $this->setRoles($usuario,$request->role_list);
        return response()->json($usuario);
        //return redirect()->route('usuario.index');
    }

    public function edit($idUser){
        $usuario = User::find($idUser);

        return view('usuario.update',['usuario'=>$usuario]);
    }

    public function update(Request $request,$idUser){
        $usuario = User::find($idUser);

        //para cambiar solo la contraseña
        if($request->user_password || $request->user_password2){
            $listUsuarioData = ['user_password'=>$request->user_password,'user_password2'=>$request->user_password2];
            Validator::make($listUsuarioData,[
                'user_password2' => 'required| same:user_password'
            ],[
                'user_password2.same' => 'Ambas contraseñas deben coincidir si desea cambiarlas.',
            ])->validate();
            $usuario->fill($listUsuarioData)->save();
        }

        //para cambiar el resto
        $listUsuarioData = ['user_nombre'=> $request->user_nombre, 'user_codigo' => $request->user_codigo, 'user_email'=> $request->user_email, 'user_seleccionable'=>$request->user_seleccionable];
        Validator::make($listUsuarioData,[
            'user_nombre' => 'required',
            'user_codigo' => ['required',Rule::unique('usuario')->ignore($usuario->user_id,'user_id')],
            'user_email' => ['email',Rule::unique('usuario')->ignore($usuario->user_id,'user_id')],
            'user_seleccionable' => 'boolean'
        ],[
            'required' => 'Este campo es requerido.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.',
            'unique' => 'Este valor ya ha sido registrado'
        ])->validate();
        $usuario->fill($listUsuarioData)->save();
        $this->setRoles($usuario,$request->role_list);
        return response()->json($usuario);
        //return redirect()->route('usuario.index');
    }

    private function setRoles(User $user, $listRoles = []){
        if(!is_array($listRoles))
            $listRoles=[];
        $user->roles()->sync($listRoles);
    }
}
