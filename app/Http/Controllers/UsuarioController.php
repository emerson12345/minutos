<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Sicere\Models\Rrhh;
use Validator;
use Sicere\Http\Requests;
use Sicere\User;
use Yajra\Datatables\Datatables;
use PDF;
use DB;
class UsuarioController extends Controller
{
    public function index(){
        return view('usuario.index');
    }

    public function usuarios(){
        return Datatables::of(User::all())->make(true);
    }

    public function create(){
        $usuario = new User();
        return view('usuario.create',[ 'usuario' => $usuario ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'rrhh_id'=>'required',
            'user_nombre' => 'required',
            'user_codigo' => 'required| unique:usuario,user_codigo',
            'user_password' => 'required',
            'user_password2' => 'required| same:user_password',
            'user_email' => 'email| unique:usuario,user_email',
            'role_list' => 'required'
        ],[
            'required' => 'Este campo es requerido.',
            'user_password2.same' => 'Las contraseñas no coinciden.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.',
            'user_codigo.unique' => 'Este usuario ya esta registrado en la base de datos',
            'user_email.unique' => 'Este email ya esta registrado en la base de datos',
            'role_list.required' => 'Debe seleccionar al menos un rol'
        ]);

        $usuario = new User($request->all());
        $usuario->user_seleccionable = 1;
        $usuario->save();
        $usuario->rrhh()->attach($request->rrhh_id);
        $this->setRoles($usuario,$request->role_list);
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
        $listUsuarioData = ['user_nombre'=> $request->user_nombre, 'user_codigo' => $request->user_codigo, 'user_email'=> $request->user_email, 'user_seleccionable'=>$request->user_seleccionable];
        Validator::make($listUsuarioData,[
            'user_nombre' => 'required',
            'user_codigo' => ['required',Rule::unique('usuario')->ignore($usuario->user_id,'user_id')],
            'user_email' => ['email',Rule::unique('usuario')->ignore($usuario->user_id,'user_id')],
            'user_seleccionable' => 'boolean',
            'role_list' => 'required'
        ],[
            'required' => 'Este campo es requerido.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.',
            'user_codigo.unique' => 'Este usuario ya esta registrado en la base de datos',
            'user_email.unique' => 'Este email ya esta registrado en la base de datos',
            'role_list.required' => 'Debe seleccionar al menos un rol'
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

    public function report(){
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
            $strCodSeguridad=session('institucion')->inst_codigo . '|' . session('institucion')->inst_nombre .'|' . Auth::user()->user_id;
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 10, 'Pagina '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 'T', false, 'R', 0, '', 0, false, 'T', 'M');
            //$pdf->write2DBarcode(bcrypt('Mi super codigo'), 'PDF417', 25, 275, 150, 6, null, 'N',true);
            $pdf->write2DBarcode($strCodSeguridad, 'PDF417', 15, 283, 100, 6, null, 'N',true);
            //$pdf->writeQR($strCodSeguridad, 'PDF417', 25, 275, 150, 6, null, 'N',true);
        });
        PDF::SetTitle('Usuarios');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 30, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage('P', 'Letter');
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
}
