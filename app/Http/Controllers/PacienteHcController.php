<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Sicere\Models\Paciente;
use Sicere\Models\LibCuaderno;
use Sicere\Models\Rrhh;
use Illuminate\Support\Facades\DB;

class PacienteHcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url_paciente = asset('PacienteHc/historial_clinico/');
        $listPacientes = Paciente::all();
        $listCuadernos = LibCuaderno::all();
        $listRrhh = Rrhh::all();
        $view=View::make('PacienteHc.index')
            ->nest('listPacientes', 'PacienteHc.listPacientes',array('listPacientes'=>$listPacientes))
            ->nest('listCuadernos','cuadernos.listCuadernos',array('listCuadernos'=>$listCuadernos))
            ->nest('listRrhh','Rrhh.listRrhh',array('listRrhh'=>$listRrhh))
            ->with('url_paciente', $url_paciente);
        return $view;
    }
    public function registroHistoricoPaciente($id)
    {
        $url_hc = asset('PacienteHc/atencion/');
        $listPacienteHc = DB::table('paciente')
            ->join('paciente_hc', 'paciente.pac_id', '=', 'paciente_hc.pac_id')
            ->join('lib_registro','lib_registro.pac_id','=','paciente_hc.pac_id')
            ->join('lib_formulario','lib_formulario.for_id','=','lib_registro.for_id')
            ->join('lib_cuadernos','lib_cuadernos.cua_id','lib_formulario.cua_id')
            ->where('paciente.pac_id', '=', $id)
            ->select('lib_cuadernos.cua_nombre','lib_registro.lib_fecha','paciente_hc.hc_id','paciente_hc.pac_id','lib_cuadernos.cua_id')
            ->distinct()
            ->get();
        return view('PacienteHc.listHc',['listPacienteHc' => $listPacienteHc])->with('url_hc', $url_hc);
    }
    public function atencionHc($cua_id,$pac_id,$hc_id,$fecha)
    {
        //echo $hc_id;

        $listAtencionHc = DB::table('lib_registro')
            ->join('lib_formulario', 'lib_registro.for_id', '=', 'lib_formulario.for_id')
            ->join('lib_cuadernos','lib_cuadernos.cua_id','=','lib_formulario.cua_id')
            ->join('lib_columnas','lib_columnas.col_id','=','lib_formulario.col_id')
            ->where('lib_cuadernos.cua_id', '=', $cua_id)
            ->where('lib_registro.pac_id', '=', $pac_id)
            ->where('lib_registro.lib_fecha', '=', $fecha)
            ->select('lib_cuadernos.cua_id',
                    'lib_cuadernos.cua_nombre',
                    'lib_formulario.for_id',
                    'lib_columnas.col_id',
                    'lib_columnas.col_combre',
                    'lib_columnas.col_tipo',
                    'lib_registro.red_descripcion'
                )
            ->get();
        return view('PacienteHc.listAtencionHc',['listAtencionHc' => $listAtencionHc]);

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
        //
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
