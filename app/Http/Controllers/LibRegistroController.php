<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Sicere\Http\Requests;
use Yajra\Datatables\Datatables;
use Sicere\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LibRegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo "index libregistro";
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url_data = asset('cuaderno/index/');

        $cua_id=$request->input('cua_id');
        $paciente_id=$request->input('pac_id');

        $fecha_actual=date("Y-m-d");

        //$fecha_actual=date("2020-10-10");
        $estadoCuadernoFecha=DB::table('cuaderno_estado')
            ->where('cuaderno_estado.fecha','=',$fecha_actual)
            ->where('cuaderno_estado.cua_id','=',$cua_id)
            ->count();
        $estadoCuadernoHC=DB::table('paciente_hc')
            ->where('paciente_hc.hc_fecha','=',$fecha_actual)
            ->where('paciente_hc.cua_id','=',$cua_id)
            ->where('paciente_hc.pac_id','=',$paciente_id)
            ->count();

        if($estadoCuadernoFecha==0)
        {
            $mensaje="El cuaderno no esta habilitado para esta fecha";
            return view('genericas.mensaje',['url_data'=>$url_data,'mensaje'=>$mensaje]);
        }
        //echo $estadoCuadernoHC;
        if($estadoCuadernoHC>=1)
        {
            $mensaje="El historial Clinico de este paciente para este cuaderno y esta fecha ya fue registrado anteriormente";
            return view('genericas.mensaje',['url_data'=>$url_data,'mensaje'=>$mensaje]);
        }


        $paciente_hc="";
        $listPacienteHC = DB::table('paciente')
            ->join('paciente_hc', 'paciente.pac_id', '=', 'paciente_hc.pac_id')
            ->where('paciente.pac_id', '=', $paciente_id)
            ->select('paciente_hc.hc_id')
            ->get();

        foreach($listPacienteHC as $f){
            $paciente_hc=$f->hc_id;
        }

        $listFormularios=DB::table('lib_formulario')
            ->where('lib_formulario.cua_id','=',$cua_id)
            ->select('lib_formulario.for_id')
            ->get();

        $referido_de_inst_id=$request->input('referido_de_inst_id');
        $referido_a_inst_id=$request->input('referido_a_inst_id');

        $edadPacienteHc=DB::select("
                    SELECT date_part('year',age(paciente.pac_fecha_nac)) as edad,paciente.pac_edad_anio
                    from paciente
                    where paciente.pac_id='".$paciente_id."'");
        $edadPacienteHc=$edadPacienteHc[0]->edad;

        if(is_null($edadPacienteHc))
        {
            $edadPacienteHc=DB::select("
                    SELECT paciente.pac_edad_anio
                    from paciente
                    where paciente.pac_id='".$paciente_id."'");
            $edadPacienteHc=$edadPacienteHc[0]->pac_edad_anio;
        }

        if($request->input('pact_id')==1)
        {
            $hc_id=DB::table('paciente_hc')->insertGetId(
                [
                    'pac_id' => $paciente_id,
                    'rrhh_id' => $request->input('rrhh_id'),
                    'rrhh_id2' => $request->input('rrhh_id2'),
                    'pact_id'=>$request->input('pact_id'),
                    'hc_consulta_nueva'=>$request->input('hc_consulta_nueva'),
                    'hc_consulta_dentro'=>$request->input('hc_consulta_dentro'),
                    'inst_id'=>$request->input('inst_id'),
                    'referido_de_inst_id'=>$referido_de_inst_id,
                    'referido_a_inst_id'=>$referido_a_inst_id,
                    'cua_id'=>$cua_id,
                    'pac_edad'=>$edadPacienteHc,
                    'user_id'=>Auth::user()->user_id//$request->input('user_id')
                ],'hc_id'
            );
        }
        else
        {
            $hc_id=DB::table('paciente_hc')->insertGetId(
                [
                    'pac_id' => $paciente_id,
                    'rrhh_id' => $request->input('rrhh_id'),
                    'rrhh_id2' => $request->input('rrhh_id2'),
                    'pact_id'=>$request->input('pact_id'),
                    'hc_consulta_nueva'=>$request->input('hc_consulta_nueva'),
                    'hc_consulta_dentro'=>$request->input('hc_consulta_dentro'),
                    'inst_id'=>$request->input('inst_id'),
                    'conv_id'=>$request->input('conv_id'),
                    'referido_de_inst_id'=>$referido_de_inst_id,
                    'referido_a_inst_id'=>$referido_a_inst_id,
                    'cua_id'=>$cua_id,
                    'pac_edad'=>$edadPacienteHc,
                    'user_id'=>Auth::user()->user_id//$request->input('user_id')
                ],'hc_id'
            );
        }
        DB::table('evolucion')->insert(
            [
                'hc_id'=>$hc_id,
                'evolucion_descripcion'=>$request->input('evolucion_descripcion')
            ]
        );

        foreach($listFormularios as $f){

            DB::table('lib_registro')->insert(
                ['hc_id'=>$hc_id,'pac_id' => $paciente_id, 'for_id' => $f->for_id,'red_descripcion'=>trim($request->input($f->for_id))]
            );
        }

            $mensaje="Datos insertados correctamente";
            $urlreciboRecetario = asset('recibo_recetario/index');
            return view('genericas.mensaje_success',['url_data'=>$url_data,'mensaje'=>$mensaje,"urlreciboRecetario"=>$urlreciboRecetario]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
    public function edit($id)
    {
        //
    }
    */
    public function edit(Request $request)
    {
        $hc_id=$request->input('hc_id');
        $cua_id=$request->input('cua_id');
        $fecha=$request->input('fecha');
        $url_data=asset('PacienteHc/index');

        $listFormularios=DB::table('lib_formulario')
            ->where('lib_formulario.cua_id','=',$cua_id)
            ->select('lib_formulario.for_id')
            ->get();

        $referido_de_inst_id=$request->input('referido_de_inst_id');
        $referido_a_inst_id=$request->input('referido_a_inst_id');
        $hc_consulta_nueva=$request->input('hc_consulta_nueva');
        $hc_consulta_dentro=$request->input('hc_consulta_dentro');

        if(is_null($hc_consulta_nueva))
            $hc_consulta_nueva=0;
        else
            $hc_consulta_nueva=1;

        if(is_null($hc_consulta_dentro))
            $hc_consulta_dentro=0;
        else
            $hc_consulta_dentro=1;


        if($request->input('pact_id')==1)
        {
            DB::table('paciente_hc')
                ->where('hc_id', $hc_id)
                ->update(
                    [
                        'rrhh_id' => $request->input('rrhh_id'),
                        'rrhh_id2' => $request->input('rrhh_id2'),
                        'pact_id'=>$request->input('pact_id'),
                        'hc_consulta_nueva'=>$hc_consulta_nueva,
                        'hc_consulta_dentro'=>$hc_consulta_dentro,
                        //'inst_id'=>$request->input('inst_id'),
                        'referido_de_inst_id'=>$referido_de_inst_id,
                        'referido_a_inst_id'=>$referido_a_inst_id,
                        'cua_id'=>$cua_id,
                        'user_id'=>Auth::user()->user_id//$request->input('user_id')
                    ]
                );
        }
        else
        {
            DB::table('paciente_hc')
                ->where('hc_id', $hc_id)
                ->update(
                    [
                        'rrhh_id' => $request->input('rrhh_id'),
                        'rrhh_id2' => $request->input('rrhh_id2'),
                        'pact_id'=>$request->input('pact_id'),
                        'hc_consulta_nueva'=>$hc_consulta_nueva,
                        'conv_id'=>$request->input('conv_id'),
                        'hc_consulta_dentro'=>$hc_consulta_dentro,
                        //'inst_id'=>$request->input('inst_id'),
                        'referido_de_inst_id'=>$referido_de_inst_id,
                        'referido_a_inst_id'=>$referido_a_inst_id,
                        'cua_id'=>$cua_id,
                        'user_id'=>Auth::user()->user_id//$request->input('user_id')
                    ]
                );
        }
        foreach($listFormularios as $f){
            $data=$request->input($f->for_id);
            if(isset($data)==false)
                $data=0;
            DB::table('lib_registro')
                ->where('for_id', $f->for_id)
                ->where('hc_id', $hc_id)
                ->where('lib_fecha', $fecha)
                ->update(
                    ['red_descripcion'=>$data]
                );

        }

        $mensaje="Datos actualizados correctamente";
        return view('genericas.mensaje',['url_data'=>$url_data,'mensaje'=>$mensaje]);

        //$mensaje="Datos insertados correctamente";
        //$urlreciboRecetario = asset('recibo_recetario/index');
        //return view('genericas.mensaje_success',['url_data'=>$url_data,'mensaje'=>$mensaje,"urlreciboRecetario"=>$urlreciboRecetario]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
