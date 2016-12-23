<?php

namespace Sicere\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PDF;
use Sicere\Http\Requests;
use Sicere\Models\Institucion;
use Sicere\Models\LugarDepartamento;
use Sicere\Models\LugarMunicipio;
use Sicere\Models\ReportTemplate;
use Sicere\Models\Rrhh;
use Sicere\Models\Usuario;
use Sicere\User;
use Validator;
use Yajra\Datatables\Datatables;

class UsuarioController extends Controller
{
    public function index(){
        return view('usuario.index');
    }
    public function usuarios(){
        $institucion = Institucion::find(session('institucion')->inst_id);
        $usuarios = $institucion->usuarios;
       return Datatables::of($usuarios)->make(true);
        //$posts = User::select(array('user.user_codigo','user.user_nombre','user.user_email'));
        //return Datatables::of($posts)->make();
    }

    public function create(){
        $usuario = new User();
        return view('usuario.create',[ 'usuario' => $usuario ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'rrhh_id'=>'required| not_exists:usuario_rrhh',
            'user_nombre' => 'required',
            'user_codigo' => 'required|alpha_num| unique:usuario,user_codigo',
            'user_password' => 'required| min:6',
            'user_password2' => 'required| same:user_password| min:6',
            'user_email' => 'email| unique:usuario,user_email',
            'role_list' => 'required'
        ],[
            'rrhh_id.not_exists'=>'Esta persona ya tiene registrado un usuario',
            'required' => 'Este campo es requerido.',
            'user_password2.same' => 'Las contraseñas no coinciden.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.',
            'user_codigo.unique' => 'Este usuario ya esta registrado en la base de datos',
            'user_codigo.alpha_num' => 'El nombre de usuario solo permite numeros y letras.',
            'user_email.unique' => 'Este email ya esta registrado en la base de datos',
            'role_list.required' => 'Debe seleccionar al menos un rol'
        ]);
        $usuario = new User($request->all());
        DB::transaction(function() use ($usuario,$request){
            $usuario->user_seleccionable = 1;
            $usuario->save();
            $usuario->instituciones()->sync([session('institucion')->inst_id]);
            $usuario->rrhh()->attach($request->rrhh_id);
            $this->setRoles($usuario,$request->role_list);
        });
        return response()->json($usuario);
    }

    public function update($user_id){
        $usuario = User::find($user_id);
        return view('usuario.update',['usuario'=>$usuario]);
    }

    public function edit(Request $request,$user_id){
        $usuario = User::find($user_id);

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
        $listUsuarioData = ['user_codigo' => $request->user_codigo, 'user_email'=> $request->user_email, 'user_seleccionable'=>$request->user_seleccionable,'role_list'=>$request->role_list];
        Validator::make($listUsuarioData,[
            'user_codigo' => ['required','alpha_num',Rule::unique('usuario')->ignore($usuario->user_id,'user_id')],
            'user_email' => ['email',Rule::unique('usuario')->ignore($usuario->user_id,'user_id')],
            'user_seleccionable' => 'boolean',
            'role_list' => 'required'
        ],[
            'required' => 'Este campo es requerido.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.',
            'user_codigo.unique' => 'Este usuario ya esta registrado en la base de datos',
            'user_codigo.alpha_num' => 'El nombre de usuario solo permite numeros y letras.',
            'user_email.unique' => 'Este email ya esta registrado en la base de datos',
            'role_list.required' => 'Debe seleccionar al menos un rol'
        ])->validate();
        $usuario->fill($listUsuarioData)->save();
        $this->setRoles($usuario,$request->role_list);
        return response()->json($usuario);
    }

    private function setRoles(User $user, $listRoles = []){
        if(!is_array($listRoles))
            $listRoles=[];
        $user->roles()->sync($listRoles);
    }

    public function report(){
        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P', 'Letter');
        ReportTemplate::printTitle('USUARIOS REGISTRADOS EN EL SISTEMA');
        PDF::writeHTML(view('usuario.report')->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('usuario.pdf');
    }

    public function rrhh(Request $request){
        $query = $request->input('query')?$request->input('query').'%':'';
        $lista = Rrhh::select('rrhh_id as id','rrhh_ci as nro_ci',DB::raw("ltrim(concat_ws(' ',rrhh_ap_prim,rrhh_ap_seg,rrhh_nombre)) as text"))
            ->whereRaw("upper(ltrim(concat_ws(' ',rrhh_ap_prim,rrhh_ap_seg,rrhh_nombre))) like upper(?)",$query)
            ->orWhere('rrhh_ci','like',$query)->get();
        return response()->json($lista);
    }

    public function password(){
        $usuario = User::find(Auth::user()->user_id);
        return view('usuario.password',['usuario'=>$usuario]);
    }

    public function update_password(Request $request){
        $rules = [
            'user_password_actual' => 'required',
            'user_password' => 'required|min:5|max:150',
            'user_password2' => 'required| same:user_password'
        ];

        $messages = [
            'user_password_actual.required' => 'El campo es requerido',
            'user_password.required' => 'El campo es requerido',
            'user_password2.same' => 'Los passwords no coinciden',
            'user_password.min' => 'El mínimo permitido son 5 caracteres',
            'user_password.max' => 'El máximo permitido son 150 caracteres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            return redirect('usuario/password')->withErrors($validator);
        }
        else{
            if (Hash::check($request->user_password_actual, Auth::user()->user_password)){
                $usuario = User::find(Auth::user()->user_id);
                $listUsuarioData = ['user_password'=>$request->user_password];
                $usuario->fill($listUsuarioData)->save();
                return redirect('usuario/password')->with('status', 'Contraseña modificada con éxito');
            }
            else
            {
                return redirect('usuario/password')->with('message', 'Contraseña actual incorrecta, por favor verifique sus datos');
            }
        }
    }

    public function permiso_cuaderno($user_id){
        $usuario = User::find($user_id);
        return view('usuario.usercuaderno',['usuario'=>$usuario]);
    }
    public function set_cuaderno(Request $request,$user_id){
        $usuario = User::find($user_id);
        //para cambiar el resto
        $listUsuarioData = ['cuaderno_list'=>$request->cuaderno_list];
        Validator::make($listUsuarioData,[
            'cuaderno_list' => 'required'
        ],[
            'required' => 'Este campo es requerido.',
            'cuaderno_list.required' => 'Debe seleccionar al menos un cuaderno'
        ])->validate();
        //$usuario->fill($listUsuarioData)->save();
        $this->setCuadernos($usuario,$request->cuaderno_list);
        return response()->json($usuario);
    }

    private function setCuadernos(User $user, $listCuadernos = []){
        if(!is_array($listCuadernos))
            $listCuadernos=[];
        $user->cuadernos()->sync($listCuadernos);
    }

    public function all_users(){
        return Datatables::of(Usuario::all())->make(true);
    }
    public function all_permisos(){
        return view('usuario.lista');
    }

    public function permiso_establecimiento($user_id){
        $usuario = User::find($user_id);
        return view('usuario.userestablecimiento',['usuario'=>$usuario]);
    }

    public function  set_establecimiento(Request $request,$user_id){
        $usuario = User::find($user_id);
        $listUsuarioData = ['institucion_list'=>$request->institucion_list];
        Validator::make($listUsuarioData,[
            'institucion_list' => 'required'
        ],[
            'required' => 'Este campo es requerido.',
            'institucion_list.required' => 'Debe seleccionar al menos un establecimiento'
        ])->validate();
        $this->setEstablecimientos($usuario,$request->institucion_list);
        return response()->json($usuario);
    }

    private function setEstablecimientos(User $user, $listInstitucion = []){
        if(!is_array($listInstitucion))
            $listInstitucion=[];
        $user->instituciones()->sync($listInstitucion);
    }

    public function getMunicipios(Request $request){
        $dep_id = $request->dep_id?:0;
        $departamento = LugarDepartamento::find($dep_id);
        $municipios = [];
        if($departamento)
            $municipios = $departamento->municipios;
        return response()->json($municipios);
    }

    public function getAreas(Request $request){
        $mun_id = $request->mun_id?:0;
        $municipio = LugarMunicipio::find($mun_id);
        $areas = [];
        if($municipio)
            $areas = $municipio->areas;
        return response()->json($areas);
    }

    public function getEstablecimientos(Request $request){
        $dep_id = $request->dep_id?:0;
        $mun_id = $request->mun_id?:0;
        $area_id = $request->area_id?:0;
        $establecimientos = Institucion::where('dep_id',$dep_id==0?'<>':'=',$dep_id)
        ->where('mun_id',$mun_id==0?'<>':'=',$mun_id)
        ->where('area_id',$area_id==0?'<>':'=',$area_id)->get();
        return response()->json($establecimientos);
    }
}
