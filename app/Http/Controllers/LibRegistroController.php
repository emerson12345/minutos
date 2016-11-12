<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
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
        echo "index libregistro";
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
        $cua_id=$request->input('cua_id');
        $paciente_id=$request->input('pac_id');
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

        foreach($listFormularios as $f){
            //echo $f->for_id." VALOR ".$request->input($f->for_id);
            //echo "<br>";
            DB::table('lib_registro')->insert(
                ['pac_id' => $paciente_id, 'for_id' => $f->for_id,'red_descripcion'=>$request->input($f->for_id)]
            );
        }

        DB::table('paciente_hc')->insert(
            ['pac_id' => $paciente_id, 'rrhh_id' => 94,
                'pact_id'=>1,'hc_consulta_nueva'=>1,
                'hc_consulta_dentro'=>0,
                'hc_con_seguro'=>0,
                'user_id'=>1
            ]
        );
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
    public function edit($id)
    {
        //
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
        //
    }
}
