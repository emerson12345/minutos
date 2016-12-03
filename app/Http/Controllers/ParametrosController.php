<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Sicere\Models\Setup;
use Validator;
use Sicere\Http\Requests;

class ParametrosController extends Controller
{
    //
    public function index(){
        return view('parametros.index');
    }

    public function setup(){
        $setup  = Setup::find('set_nro_dias_abandono');
        return view('parametros.form',['setup'=>$setup]);
    }

    public function update(Request $request){
        $rules = [
            'set_id' => 'required',
            'set_valor' => 'required',
        ];

        $messages = [
            'required' => 'El campo es requerido',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            return redirect('parametro/setup')->withErrors($validator);
        }
        else{
            $setup = Setup::find('set_nro_dias_abandono');
            $setupData = ['set_valor'=>$request->set_valor];
            $setup->fill($setupData)->save();
            return redirect('parametro/setup')->with('status', 'Parámetro modificado con éxito');
        }
    }
}
