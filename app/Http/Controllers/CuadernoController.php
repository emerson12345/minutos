<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Sicere\Models\LibCuaderno;
use Sicere\Models\LibFormulario;
class CuadernoController extends Controller
{
    public function index(){
        return view('cuaderno.index');
    }

    public function cuadernos(){
        return Datatables::of(LibCuaderno::all())->make(true);
    }

    public function create(){
        $cuaderno = new LibCuaderno();
        $formulario = [];
        return view('cuaderno.form',['cuaderno'=>$cuaderno,'formulario'=>$formulario]);
    }

    public function update($cua_id = 0){
        $cuaderno = LibCuaderno::find($cua_id);
        $formulario = $cuaderno->formulario()->orderBy('for_col_posi')->get();
        return view('cuaderno.form',['cuaderno'=>$cuaderno,'formulario'=>$formulario]);
    }

    public function store(Request $request, $cua_id = 0){
        $cuaderno = LibCuaderno::find($cua_id);
        $formulario = [];
        if(!$cuaderno)
            $cuaderno = new LibCuaderno();

        $cuaderno->fill($request->all());
        if($request->lib_formulario){
            foreach ($request->lib_formulario as $form){
                $temp = new LibFormulario($form);
                if(array_key_exists('for_id',$form)){
                    $temp = LibFormulario::find($form['for_id']);
                    if($temp)
                        $temp->fill($form);
                    else
                        $temp = new LibFormulario($temp);
                }
                $formulario[] = $temp;
            }
        }

        $this->validate($request,[
            'cua_nombre' => ['required',Rule::unique('lib_cuadernos')->ignore($cua_id,'cua_id')],
            'user_seleccionable' => 'boolean',
            'lib_formulario.*.col_id'=>'integer'
        ],[
            'required' => 'Este campo es requerido.',
            'boolean' => 'Seleccione una opcion valida.',
            'unique' => 'Este valor ya ha sido tomado.',
        ]);

        DB::transaction(function() use($cuaderno,$formulario){
            $cuaderno->save();
            foreach ($formulario as $form){
                $form->cua_id = $cuaderno->cua_id;
                $form->save();
            }
        });
        return route('adm.cuaderno.index');
    }
}