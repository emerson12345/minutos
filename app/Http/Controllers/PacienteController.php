<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\LugarDepartamento;
use Sicere\Models\Paciente;
use Sicere\Models\PacienteGrupoFamilium;
use Yajra\Datatables\Datatables;
use PDF;

class PacienteController extends Controller
{
    public function index(){
        return view('paciente.index');
    }

    public function pacientes(){
        return Datatables::of(Paciente::all())->make(true);
    }

    public function create(){
        $paciente = new Paciente();
        return view('paciente.form',['paciente'=>$paciente]);
    }

    public function update($pac_id){
        $paciente = Paciente::find($pac_id);
        return view('paciente.form',['paciente'=>$paciente]);
    }

    public function store(Request $request,$pac_id = 0){
        $paciente = new Paciente();
        if($pac_id)
            $paciente = Paciente::find($pac_id);
        $this->validate($request,[
            'pac_nro_hc' => ['required',Rule::unique('paciente')->ignore($pac_id,'pac_id')],
            'pac_nro_ci' => [Rule::unique('paciente')->ignore($pac_id,'pac_id')],
            'pac_nombre' => 'required',
            'pac_fecha_nac'=>'date_format:d/m/Y',
            'pac_edad_anio' => 'required|integer'
        ],[
            'required' => 'Este campo es requerido.',
            'unique'=> 'Este valor ya ha sido registrado',
            'date_format'=>'El formato de fecha debe ser dd/mm/aaaa',
            'integer' => 'La edad debe ser un numero entero'
        ]);

        $paciente->fill($request->all());
        if($request->pac_fecha_nac == '')
            $paciente->pac_fecha_nac = null;
        $paciente->user_id = Auth::user()->user_id;
        if(session()->has('institucion'))
            $paciente->inst_id = session('institucion')->inst_id;
        $paciente->save();

        return response()->json($paciente);
    }

    public function detail($pac_id){
        $paciente = Paciente::find($pac_id);
        return view('paciente.detail',['paciente'=>$paciente]);
    }

    public function group($pac_id){
        $paciente = Paciente::find($pac_id);
        return view('paciente.group',['paciente'=>$paciente]);
    }

    public function formGroup($pac_id = 0,$group_id = 0){
        $paciente = Paciente::find($pac_id);
        $gPersona = PacienteGrupoFamilium::find($group_id);
        if(!$gPersona)
            $gPersona = new PacienteGrupoFamilium();
        $gPersona->pac_id = $paciente->pac_id;
        return view('paciente._form_group',['gPersona'=>$gPersona,'paciente'=>$paciente]);
    }

    public function storeGroup(Request $request,$pac_id = 0,$group_id = 0){
        $paciente = Paciente::find($pac_id);
        $gPersona = PacienteGrupoFamilium::find($group_id);
        if(!$gPersona)
            $gPersona = new PacienteGrupoFamilium();
        $gPersona->pac_id = $paciente->pac_id;

        $this->validate($request,[
            'gru_fam_nro_ci' => [Rule::unique('paciente_grupo_familia')->ignore($group_id,'gru_fam_id')],
            'gru_fam_nombre' => 'required'
        ],[
            'required' => 'Este campo es requerido.',
            'unique'=> 'Este valor ya ha sido registrado',
            'date_format'=>'El formato de fecha debe ser dd/mm/aaaa'
        ]);

        if(Auth::check()){
            $gPersona->fill($request->all());
            $gPersona->user_id = Auth::user()->user_id;
            $gPersona->save();
        }
        return response()->json($gPersona);
    }
    
    public function getMunicipios(Request $request){
        $dep_id = 0;
        if($request->dep_id)
            $dep_id = $request->dep_id;
        $departamento = LugarDepartamento::find($dep_id);
        $lista = [];
        if($departamento){
            $lista = $departamento->municipios()->select('mun_nombre','mun_id')->get();
        }
        return response()->json($lista);
    }
    public function report($pac_id){
        $paciente = Paciente::find($pac_id);
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
            $pdf->write2DBarcode($strCodSeguridad, 'PDF417', 25, 275, 150, 6, null, 'N',true);
        });
        PDF::SetTitle('My Report');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 30, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage('P', 'Letter');
        PDF::writeHTML(view('paciente.detail',['paciente'=>$paciente])->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('usuario.pdf');
    }
}
