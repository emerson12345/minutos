<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Sicere\Http\Requests;
use Sicere\User;

class UsuarioController extends Controller
{
    public function index(){
        $listUsuarios = User::paginate(2);
        return view('usuario.index',[ 'listUsuarios' => $listUsuarios ]);
    }

    public function create(){
        $usuario = new User();
        return view('usuario.create',[ 'usuario' => $usuario ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'user_nombre' => 'required',
            'user_codigo' => 'required',
            'user_password' => 'required',
            'user_password2' => 'required| same:user_password',
            'user_email' => 'email',
            'user_seleccionable' => 'boolean'
        ],[
            'required' => 'Este campo es requerido.',
            'user_password2.same' => 'Las contraseñas no coinciden.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.'
        ]);

        $usuario = new User($request->all());
        $usuario->save();
        return redirect()->route('usuario.index');
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
            'user_codigo' => 'required',
            'user_email' => 'email',
            'user_seleccionable' => 'boolean'
        ],[
            'required' => 'Este campo es requerido.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.'
        ])->validate();
        $usuario->fill($listUsuarioData)->save();

        return redirect()->route('usuario.index');
    }
}
