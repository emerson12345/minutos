<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Sicere\Models\Paciente;
use Sicere\Models\LibCuaderno;
use Sicere\Models\Rrhh;
use Sicere\Models\institucion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $url_buscar_Hc = asset('PacienteHc/buscar_historial_clinico/');
        $listPacientes = Paciente::all();
        $listCuadernos = LibCuaderno::all();
        $listCuadernosSearch=LibCuaderno::all()
                            ->pluck('cua_nombre','cua_id');
        //$listRrhh = Rrhh::all();
        $listRrhh = DB::table('rrhh')
            ->where('rrhh.inst_id','=',session('institucion')->inst_id)
            ->join('institucion','institucion.inst_id','rrhh.inst_id')
            ->select('*')
            ->get();

        $listPersonalSearch = DB::table('rrhh')
            ->join('institucion','institucion.inst_id','rrhh.inst_id')
            ->select('rrhh.rrhh_id','rrhh.rrhh_nombre','rrhh.rrhh_ap_prim','rrhh.rrhh_ap_seg','institucion.inst_nombre','institucion.inst_localidad')
            ->get();
        $view=View::make('PacienteHc.index',array('listCuadernosSearch'=>$listCuadernosSearch,'listPersonalSearch'=>$listPersonalSearch))
            ->nest('listPacientes', 'PacienteHc.listPacientes',array('listPacientes'=>$listPacientes))
            ->nest('listCuadernos','cuadernos.listCuadernos',array('listCuadernos'=>$listCuadernos))
            ->nest('listRrhh','Rrhh.listRrhh',array('listRrhh'=>$listRrhh))
            ->with(array('url_paciente'=>$url_paciente,'url_buscar_Hc'=>$url_buscar_Hc));
        return $view;
    }
    public function registroHistoricoPaciente($id)
    {
        $url_hc = asset('PacienteHc/atencion/');
        /*
        $listPacienteHc = DB::table('paciente')
            ->join('paciente_hc', 'paciente.pac_id', '=', 'paciente_hc.pac_id')
            ->join('lib_registro','lib_registro.pac_id','=','paciente_hc.pac_id')
            ->join('lib_formulario','lib_formulario.for_id','=','lib_registro.for_id')
            ->join('lib_cuadernos','lib_cuadernos.cua_id','lib_formulario.cua_id')
            ->where('paciente.pac_id', '=', $id)
            ->select('lib_cuadernos.cua_nombre','lib_registro.lib_fecha','paciente_hc.hc_id','paciente_hc.pac_id','lib_cuadernos.cua_id')
            ->distinct()
            ->get();
        */
                $listPacienteHc = DB::table('paciente')
                    ->join('paciente_hc', 'paciente.pac_id', '=', 'paciente_hc.pac_id')
                    ->join('lib_cuadernos','lib_cuadernos.cua_id','paciente_hc.cua_id')
                    ->join('institucion','institucion.inst_id','paciente_hc.inst_id')
                    ->where('paciente.pac_id', '=', $id)
                    ->select('lib_cuadernos.cua_nombre','paciente_hc.hc_fecha','paciente_hc.hc_id','paciente_hc.pac_id','lib_cuadernos.cua_id','institucion.inst_nombre')
                    ->distinct()
                    ->get();

        return view('PacienteHc.listHc',['listPacienteHc' => $listPacienteHc])->with('url_hc', $url_hc);
    }
    public function atencionHc($cua_id,$pac_id,$hc_id,$fecha)
    {

        $fecha_actual=date("Y-m-d");

        //$fecha_actual=date("2020-10-10");
        $estadoCuadernoFecha=DB::table('cuaderno_estado')
            ->where('cuaderno_estado.fecha','=',$fecha_actual)
            ->where('cuaderno_estado.cua_id','=',$cua_id)
            ->count();
        $estadoCuadernoHC=DB::table('paciente_hc')
            ->where('paciente_hc.user_id','=',Auth::user()->user_id)
            ->where('paciente_hc.hc_id','=',$hc_id)
            ->count();
        $EstadoModificar=true;
        //echo "Valores ".Auth::user()->user_id." ".$hc_id;

        if($estadoCuadernoFecha==0)
        {
            $EstadoModificar=false;
        }
        //echo $estadoCuadernoHC;
        if($estadoCuadernoHC==0)
        {
            $EstadoModificar=false;
        }

        $url_peticion_listas=asset('cuaderno/peticion_listas/');
        $listDatosHc = DB::select(
            "select
                paciente.pac_id,
                paciente.pac_nombre,
                paciente_hc.hc_id,
                paciente_hc.cua_id,
                lib_cuadernos.cua_nombre,
                paciente_hc.pact_id,
                paciente_tipo.pact_nombre,
                paciente_hc.hc_consulta_nueva,paciente_hc.hc_consulta_dentro,
                paciente_hc.referido_a_inst_id,
                (select institucion.inst_nombre from institucion where institucion.inst_id=paciente_hc.referido_a_inst_id) as referido_d,
                paciente_hc.referido_de_inst_id,
                (select institucion.inst_nombre from institucion where institucion.inst_id=paciente_hc.referido_de_inst_id) as referido_a,
                paciente_hc.rrhh_id,
                (select rrhh.rrhh_nombre from rrhh where rrhh.rrhh_id=paciente_hc.rrhh_id) as rrhh1,
                paciente_hc.rrhh_id2,
                (select rrhh.rrhh_nombre from rrhh where rrhh.rrhh_id=paciente_hc.rrhh_id2) as rrhh2,
                rrhh.rrhh_nombre
                from paciente_hc
                join rrhh
                on rrhh.rrhh_id=paciente_hc.rrhh_id
                join paciente_tipo
                on paciente_tipo.pact_id=paciente_hc.pact_id
                join lib_cuadernos
                on lib_cuadernos.cua_id=paciente_hc.cua_id
                join paciente
                on paciente.pac_id=paciente_hc.pac_id
                where paciente_hc.hc_id=$hc_id
                "
        );
        $listDatosHc=$listDatosHc[0];
        //->get();
        //->toSql();
        //print_r($listDatosHc[0]);
        //echo "<br>";
        //echo $listDatosHc[0]->pac_nombre;
        //echo $listDatosHc[0]['pact_nombre'];
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
        $inst_id=session('institucion')->inst_id;
        /*
        $listInstitucion = DB::table('institucion')
            ->join('institucion_convenio', 'institucion.inst_id', '=', 'institucion_convenio.inst_id')
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
        $listCuadernos = DB::table('lib_cuadernos')
            ->where('lib_cuadernos.cua_seleccionable','=','1')
            ->select('*')
            ->get();
        $listPacientes = Paciente::all();

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $listRrhh=  Rrhh::all()->where('inst_id','=',$inst_id)->pluck('rrhh_nombre','rrhh_id');

        return view('PacienteHc.listAtencionHc',
            [
                'listAtencionHc' => $listAtencionHc,'listDatosHc' => $listDatosHc,
                'listCuadernos' => $listCuadernos,'listPacientes' => $listPacientes,
                'listRrhh' => $listRrhh,
                'listInstitucion'=>$listInstitucion,
                'listInstitucionAll2'=>$listInstitucionAll2,
                'hc_id'=>$hc_id,
                'cua_id'=>$cua_id,
                'fecha'=>$fecha,
                'EstadoModificar'=>$EstadoModificar,
            ])->with('url_peticion_listas', $url_peticion_listas);
    }
    public function searchHc($fecha_inicio,$fecha_fin,$cua_id,$rrhh_id,$pac_id)
    {
        if($rrhh_id=='false')
            $rrhh_id="%";
        $url_hc = asset('PacienteHc/atencion/');
        $listPacienteHc = DB::select(
            "
                select lib_cuadernos.cua_nombre,paciente_hc.hc_fecha,paciente_hc.hc_id,lib_cuadernos.cua_id,
                institucion.inst_nombre,paciente_hc.rrhh_id,paciente_hc.rrhh_id2,paciente_hc.pac_id
                from paciente
                join paciente_hc
                on paciente.pac_id=paciente_hc.pac_id
                join lib_cuadernos
                on lib_cuadernos.cua_id=paciente_hc.cua_id
                join institucion
                on institucion.inst_id=paciente_hc.inst_id
                where paciente.pac_id=".$pac_id."
                    and
                    (paciente_hc.hc_fecha>='".$fecha_inicio."' and paciente_hc.hc_fecha<='".$fecha_fin."')
                    and CAST(lib_cuadernos.cua_id AS VARCHAR(20)) like '".$cua_id."'
                    and CAST(paciente_hc.rrhh_id AS VARCHAR(20)) like '%".$rrhh_id."%'
            ");
        /*
        $listPacienteHc = DB::table('paciente')
            ->join('paciente_hc', 'paciente.pac_id', '=', 'paciente_hc.pac_id')
            ->join('lib_cuadernos','lib_cuadernos.cua_id','paciente_hc.cua_id')
            ->join('institucion','institucion.inst_id','paciente_hc.inst_id')
            ->where('paciente.pac_id', '=', $pac_id)
            ->select('lib_cuadernos.cua_nombre','paciente_hc.hc_fecha','paciente_hc.hc_id','paciente_hc.pac_id','lib_cuadernos.cua_id','institucion.inst_nombre')
            ->distinct()
            ->get();*/
        return view('PacienteHc.listHc',['listPacienteHc' => $listPacienteHc,'pac_id'=>$pac_id])->with('url_hc', $url_hc);
    }
    public  function agenda()
    {
        return view('PacienteHc.agenda');
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
