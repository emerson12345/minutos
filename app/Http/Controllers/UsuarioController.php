<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Sicere\Http\Requests;
use Sicere\User;
use Yajra\Datatables\Datatables;
use PDF;
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

    public function report(){
        PDF::setHeaderCallback(function($pdf) {
            $pdf->Cell(0, 27, '', 'B', false, 'R', 0, '', 0, false, 'T', 'M');
            $pdf->Image(asset('template/dist/img/bolivia.gif'), 25, 10, 0, 15, 'GIF', 'http://www.tcpdf.org', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'B', 18);
            $pdf->Text(60,14,'Ministerio de salud y deportes');
            $pdf->Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', 'http://www.tcpdf.org', '', true, 150, 'R', false, false, 0, false, false, false);
        });
        PDF::setFooterCallback(function($pdf) {
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 10, 'Pagina '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 'T', false, 'R', 0, '', 0, false, 'T', 'M');
            $pdf->write2DBarcode(bcrypt('Mi super codigo'), 'PDF417', 25, 275, 150, 6, null, 'N',true);
        });
        PDF::SetTitle('My Report');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(25, 30, 25);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage('P', 'Letter');
        PDF::writeHTML(view('usuario.report')->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('usuario.pdf');
    }
}
