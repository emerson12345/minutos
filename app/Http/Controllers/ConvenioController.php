<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\Convenio;
use Yajra\Datatables\Datatables;

class ConvenioController extends Controller
{
    public function index(){
        return view('convenio.index');
    }

    public function convenios(){
        return Datatables::of(Convenio::all())->make(true);
    }

    public function create(){
        $convenio = new Convenio();
        return view('convenio.form',['convenio'=>$convenio]);
    }

    public function update($conv_id = 0){
        $convenio = Convenio::find($conv_id);
        return view('convenio.form',['convenio'=>$convenio]);
    }

    public function store(Request $request,$conv_id = 0){
        $convenio = new Convenio();
        if($conv_id)
            $convenio = Convenio::find($conv_id);
        $this->validate($request,[
            'conv_nombre' => ['required',Rule::unique('convenio')->ignore($conv_id,'conv_id')],
            'conv_codigo' => ['required',Rule::unique('convenio')->ignore($conv_id,'conv_id')],
            'conv_seleccionable' => 'boolean'
        ],[
            'required' => 'Este campo es requerido.',
            'boolean' => 'Seleccione una opcion valida.',
            'unique'=> 'Este valor ya ha sido registrado'
        ]);

        DB::transaction(function() use ($request,$convenio){
            $munList = [];
            if($request->conv_niv_nacional == '0' && $request->municipios)
                $munList =  $request->municipios;
            $convenio->fill($request->all())->save();
            $convenio->municipios()->sync($munList);
        });

        return response()->json($convenio);

    }
}
