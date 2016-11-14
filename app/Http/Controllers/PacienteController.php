<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\Paciente;
use Yajra\Datatables\Datatables;

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
            'pac_nro_ci' => 'required',
            'pac_ap_prim' => 'required',
            'pac_nombre' => 'required'
        ],[
            'required' => 'Este campo es requerido.',
            'unique'=> 'Este valor ya ha sido registrado',
            'date_format'=>'El formato de fecha debe ser dd/mm/aaaa'
        ]);

        $paciente->fill($request->all());
        $paciente->user_id = Auth::user()->user_id;
        $paciente->pac_seleccionable = 1;
        if(session()->has('institucion'))
            $paciente->inst_id = session('institucion')->inst_id;
        $paciente->save();

        return response()->json($paciente);
    }
}
