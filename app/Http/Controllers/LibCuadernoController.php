<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\LibCuaderno;
use Sicere\Models\Paciente;
use Sicere\Models\Rrhh;
use Sicere\Models\institucion;
use Sicere\Models\LibFormulario;
use Illuminate\Support\Facades\DB;
use Session;

class LibCuadernoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($agenda_id=0)
    {
        $listAgendaPacientes = DB::table('agenda')
            ->join('paciente','agenda.pac_id','=','paciente.pac_id')
            ->join('lib_cuadernos','lib_cuadernos.cua_id','=','agenda.cua_id')
            ->where('agenda_id','=',$agenda_id)
            ->select('paciente.pac_id','paciente.pac_ap_prim','paciente.pac_ap_seg','paciente.pac_nombre','lib_cuadernos.cua_id','lib_cuadernos.cua_nombre')
            ->first();

        $url_cuaderno = asset('cuaderno/peticion/');
        $url_cuaderno_peticion_hc = asset('cuaderno/peticion/');
        $inst_id=session('institucion')->inst_id;
        $estadoAgenda=true;

        ////////////////////////////////////////////////////////////////////////////////
        if ($agenda_id!=0){
            $AgendaPacidentesPacId=$listAgendaPacientes->pac_id;
            $AgendaPacidentesCuaId=$listAgendaPacientes->cua_id;
        }
        else
        {
            $estadoAgenda=false;
            $AgendaPacidentesPacId=0;
            $AgendaPacidentesCuaId=0;
        }


        ////////////////////////////////////////////////////////////////////////////////
        /*
        $listInstitucion = DB::table('institucion')
            ->join('municipio_convenio', 'municipio_convenio.mun_id', '=', 'institucion.mun_id')

            ->join('convenio','convenio.conv_id','=','institucion_convenio.conv_id')

            ->where('institucion.inst_id','=',$inst_id)
            ->pluck('convenio.conv_nombre','convenio.conv_id');*/

        $listConvenio1 = DB::table('convenio')
            ->where('convenio.conv_niv_nacional','=',1)
            ->select('convenio.conv_nombre','convenio.conv_id');
        $listConvenio2 = DB::table('institucion')
            ->join('lugar_municipio','lugar_municipio.mun_id','=','institucion.mun_id')
            ->join('municipio_convenio','municipio_convenio.mun_id','=','lugar_municipio.mun_id')
            ->join('convenio','convenio.conv_id','=','municipio_convenio.conv_id')
            ->where('institucion.inst_id','=',$inst_id)
            ->select('convenio.conv_nombre','convenio.conv_id');
        $listInstitucion=$listConvenio1->union($listConvenio2)->pluck('convenio.conv_nombre','convenio.conv_id');


        //$listCuadernos = LibCuaderno::all()->pluck('cua_nombre','cua_id');
        $listInstitucionAll=Institucion::all()->pluck('inst_nombre','inst_id');
        $listInstitucionAll2=Institucion::all();

        //$listCuadernos = LibCuaderno::all();
        $listCuadernos = DB::table('usuario')
            ->join('usuario_lib_cuaderno','usuario_lib_cuaderno.user_id','=','usuario.user_id')
            ->join('lib_cuadernos','lib_cuadernos.cua_id','=','usuario_lib_cuaderno.cua_id')
            ->where('lib_cuadernos.cua_seleccionable','=','1')
            ->where('usuario.user_id','=',\Auth::user()->user_id)
            ->select('lib_cuadernos.*')
            ->get();


        $listPacientes = Paciente::all();
        $listRrhh=  Rrhh::all()->where('inst_id','=',$inst_id)->pluck('rrhh_nombre','rrhh_id');



//dd($listAgendaPacientes);
        return view('cuadernos.show',
            [
                'listCuadernos' => $listCuadernos,
                'listPacientes' => $listPacientes,
                'listRrhh' => $listRrhh,
                'listInstitucion'=>$listInstitucion,
                'listInstitucionAll2'=>$listInstitucionAll2,
                'listAgendaPacientes'=>$listAgendaPacientes
            ])->with('url_cuaderno', $url_cuaderno)
                ->with(
                        array(
                                'url_cuaderno_peticion_hc'=>$url_cuaderno_peticion_hc,
                                'AgendaPacidentesPacId'=>$AgendaPacidentesPacId,
                                'AgendaPacidentesCuaId'=>$AgendaPacidentesCuaId,
                                'estadoAgenda'=>$estadoAgenda
                        )
                );
    }
    public function peticion($cua_id,$pac_id)
    {
        $listEvolucion = DB::table('evolucion')
            ->join('paciente_hc', 'paciente_hc.hc_id', '=', 'evolucion.hc_id')
            ->join('rrhh', 'rrhh.rrhh_id', '=', 'paciente_hc.rrhh_id')
            ->join('paciente', 'paciente.pac_id', '=', 'paciente_hc.pac_id')
            ->where([
                ['paciente_hc.cua_id', '=', $cua_id],
                ['paciente.pac_id', '=', $pac_id],
            ])
            ->orderBy('paciente_hc.hc_fecha')
            ->select('paciente_hc.hc_id','paciente_hc.hc_fecha','paciente.pac_id' ,'paciente_hc.cua_id'
                ,'rrhh.rrhh_nombre','rrhh.rrhh_ap_prim','rrhh_ap_seg','evolucion.evolucion_descripcion')
            ->get();

        $url_cuaderno = asset('cuaderno/peticion_listas/');


        /*$listFormularios = DB::table('lib_cuadernos')
            ->join('lib_formulario', 'lib_cuadernos.cua_id', '=', 'lib_formulario.cua_id')
            ->join('lib_columnas', 'lib_columnas.col_id', '=', 'lib_formulario.col_id')
            ->where([
                ['lib_cuadernos.cua_id', '=', $cua_id],
                ['lib_formulario.for_seleccionable', '=', '1'],
            ])
            ->select('lib_formulario.for_col_posi','lib_cuadernos.cua_id','lib_cuadernos.cua_nombre' ,'lib_formulario.for_id'
                ,'lib_columnas.col_id','lib_columnas.col_combre','lib_columnas.col_tipo')
            ->orderBy('lib_formulario.for_col_posi', 'asc')
            ->get();*/
        //dd($listFormularios);
        //echo $users[0]->cua_id;
        //print_r($users);

        //$listFormularios = LibFormulario::all();

        $listFormularios = DB::table('lib_cuadernos')
            ->join('lib_formulario', 'lib_cuadernos.cua_id', '=', 'lib_formulario.cua_id')
            ->join('lib_columnas', 'lib_columnas.col_id', '=', 'lib_formulario.col_id')
            ->where([
                ['lib_cuadernos.cua_id', '=', $cua_id],
                ['lib_formulario.for_seleccionable', '=', '1'],
            ])
            ->select('lib_cuadernos.cua_id','lib_cuadernos.cua_nombre' ,'lib_formulario.for_id'
                ,'lib_columnas.col_id','lib_columnas.col_combre','lib_columnas.col_tipo')
            ->orderBy('lib_formulario.for_col_posi', 'asc')
            ->get();


        $countPacienteHcReceta=DB::table('lib_cuadernos')
            ->join('cuaderno_estado','cuaderno_estado.cua_id','=','lib_cuadernos.cua_id')
            ->where('lib_cuadernos.cua_id','=',$cua_id)
            ->where('cuaderno_estado.fecha','=',date("d/m/Y"))
            ->count();


        $url_cuaderno_index = asset('/cuaderno/index/');

        if($countPacienteHcReceta==0)
        {
            $mensaje="El cuaderno no esta habilitado para esta fecha";
                return view('genericas.mensaje',['url_data'=>$url_cuaderno_index,'mensaje'=>$mensaje]);
        }

        $fecha_actual=date("Y-m-d");
        $estadoCuadernoHC=DB::table('paciente_hc')
            ->where('paciente_hc.hc_fecha','=',$fecha_actual)
            ->where('paciente_hc.cua_id','=',$cua_id)
            ->where('paciente_hc.pac_id','=',$pac_id)
            ->count();

        if($estadoCuadernoHC>=1) {
            $mensaje = "El Historial Clinico de este paciente, para este cuaderno ya fue registrado anteriormente";
            return view('genericas.mensaje', ['url_data' => $url_cuaderno_index, 'mensaje' => $mensaje]);
        }


        return view('formulario.show',
            [
                'listFormularios' => $listFormularios,
                'cua_id'=> $cua_id,
                'listEvolucion'=> $listEvolucion
            ])->with('url_cuaderno', $url_cuaderno);
    }
    public function detalle($hc_id,$cua_id)
    {
        $listFormularios = DB::table('lib_registro')
            ->join('lib_formulario', 'lib_registro.for_id', '=', 'lib_formulario.for_id')
            ->join('paciente_hc', 'paciente_hc.hc_id', '=', 'lib_registro.hc_id')
            ->where('lib_registro.hc_id', '=', $hc_id)
            ->select('lib_cuadernos.cua_id','lib_cuadernos.cua_nombre' ,'lib_formulario.for_id'
                ,'lib_columnas.col_id','lib_columnas.col_combre','lib_columnas.col_tipo')
            ->get();
        //return view('formulario.show',['listFormularios' => $listFormularios,'cua_id'=> $id]);
    }
    public function peticionListas($intIDColumna,$for_id,$col_tipo)
    {
        //console.log("forid fucion peticion listas: ".$for_id);
        $listFormularios="";
        if($col_tipo==3)
        {
            $strCie10='CIE 10';
            $listFormularios = DB::table('cie10')
                ->where('cie10.cie_seleccionable', '=', '1')
                ->select('cie10.cie_cod as lis_codigo','cie10.cie_nombre as lis_descripcion')
                ->take(2000)
                ->get();
        }
        else
        {
            if($col_tipo==16)
            {
                //select cif_id,cif_cod,cif_nombre from cif;
                $strCie10='CIF';
                $listFormularios = DB::table('cif')
                    ->where('cif.cif_seleccionable', '=', '1')
                    ->select('cif.cif_cod as lis_codigo','cif.cif_nombre as lis_descripcion')
                    //->take(2000)
                    ->get();
            }
            else
            {
                $listFormularios = DB::table('lib_columnas')
                    ->join('lib_relaciona_tablas', 'lib_columnas.rel_id', '=', 'lib_relaciona_tablas.rel_id')
                    ->join('lib_lista_generica', 'lib_lista_generica.lis_tabla', '=', 'lib_relaciona_tablas.lis_tabla')
                    ->where('lib_columnas.col_id', '=', $intIDColumna)
                    ->select('lib_lista_generica.lis_codigo','lib_lista_generica.lis_descripcion','lib_columnas.col_combre')
                    ->get();
            }

        }
        return view('lista_generica.show',['listFormularios' => $listFormularios,'col_tipo'=>$col_tipo])->with('for_id',$for_id);
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
