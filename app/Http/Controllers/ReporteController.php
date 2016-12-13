<?php

namespace Sicere\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use PDF;
use DB;
use Sicere\Models\LibCuaderno;
use Sicere\Models\ReportTemplate;

class ReporteController extends Controller
{
    public function produccion(){
        return view('reporte.produccion');
    }

    public function produccionPDF(Request $request){
        ReportTemplate::printHeaderFooter();
        PDF::AddPage('L', 'Letter');
        ReportTemplate::printTitle('REPORTE DE PRODUCCION',$request->rep_fec_ini,$request->rep_fec_fin);
        PDF::writeHTML(view('reporte._produccion',['fec_ini' => $request->rep_fec_ini,'fec_fin'=>$request->rep_fec_fin,'cuadernos'=>$request->cuaderno,'rep_institucion'=>$request->rep_institucion])->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('produccion.pdf');
    }
    public function tratamientoRealizado()
    {
        return view('reporte.tratamiento_realizado');
    }
    public function tratamientoRealizadoPDF(Request $request)
    {
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $user_id = $request->user_id?:0;
        $anio = $request->anio?:date('Y');
        $mes = $request->mes?:date('n');
        $fecha_temp = Carbon::create($anio,$mes,1);
        $fecha_ini = $fecha_temp->startOfMonth()->format('d/m/Y');
        $fecha_fin = $fecha_temp->endOfMonth()->format('d/m/Y');


        $list_tratamiento_realizado = DB::table('lib_formulario')
            ->join('lib_columnas', 'lib_columnas.col_id', '=', 'lib_formulario.col_id')
            ->join('lib_registro','lib_registro.for_id','lib_formulario.for_id')
            ->where('lib_formulario.cua_id', '=', $request->cua_id)
            ->where('lib_columnas.col_tipo', '=', 0)
            ->where('lib_registro.red_descripcion', '=', '1')
            ->where('lib_registro.lib_fecha', '>=', $fecha_ini)
            ->where('lib_registro.lib_fecha', '<=', $fecha_fin)
            ->select('lib_columnas.col_combre', DB::raw('count(*) as total'))
            ->groupBy('lib_columnas.col_combre')
            ->get();

        $nombre_cuaderno = DB::table('lib_cuadernos')
            ->where('lib_cuadernos.cua_id','=',$request->cua_id)
            ->first();


        ReportTemplate::printHeaderFooter();
        PDF::AddPage('L', 'Letter');
        ReportTemplate::printTitle('TRATAMIENTO REALIZADO "'.strtoupper($nombre_cuaderno->cua_nombre).'"');
        PDF::writeHTML(view('reporte._tratamiento_realizado',["list_tratamiento_realizado"=>$list_tratamiento_realizado,'fecha_ini'=>$fecha_ini,'fecha_fin'=>$fecha_fin])->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('tratamiento_realizado.pdf');
        //dd($tratamiento_realizado);
    }

    public function morbilidad(){
        return view('reporte.morbilidad');
    }

    public function morbilidadPDF(Request $request){
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $anio = $request->anio?:date('Y');
        $mes = $request->mes?:date('n');
        $fecha_temp = Carbon::create($anio,$mes,1);
        $fecha_ini = $fecha_temp->startOfMonth()->format('d/m/Y');
        $fecha_fin = $fecha_temp->endOfMonth()->format('d/m/Y');
        ReportTemplate::printHeaderFooter();
        PDF::AddPage('P','Letter');
        ReportTemplate::printTitle('REPORTE DE MORBILIDAD',$fecha_ini,$fecha_fin);
        PDF::writeHTML(view('reporte._morbilidad',['fecha_ini'=>$fecha_ini,'fecha_fin'=>$fecha_fin,'inst_id'=>$inst_id])->render(),true,false,true,false,'');
        PDF::lastPage();
        PDF::Output('morbilidad.pdf');
    }
    public function pacienteRehabilitado(Request $request)
    {
        return view('reporte.tratamiento_realizado');
    }
    public function pacienteRehabilitadoPDF(Request $request)
    {
        $inst_id = session()->has('institucion')?session('institucion')->inst_id:0;
        $user_id = $request->user_id?:0;
        $anio = $request->anio?:date('Y');
        $mes = $request->mes?:date('n');
        $fecha_temp = Carbon::create($anio,$mes,1);
        $fecha_ini = $fecha_temp->startOfMonth()->format('d/m/Y');
        $fecha_fin = $fecha_temp->endOfMonth()->format('d/m/Y');

        if($request->cua_id==17)
        {
                $list_paciente_rehabilitado = DB::select("
                select red_descripcion,sum(total) as total,sum(alta_temporal) as alta_temporal,sum(alta_definitiva) as alta_definitiva
                from (select lr.red_descripcion,lr.hc_id,
                count(*) as total,
                (
                    select count(*)
                    from lib_formulario
                    join lib_columnas
                    on lib_columnas.col_id=lib_formulario.col_id
                    join lib_registro
                    on lib_registro.for_id=lib_formulario.for_id
                    where lib_formulario.for_id=672
                    and lib_registro.hc_id=lr.hc_id
                  and lib_registro.red_descripcion='1'
                    --and lib_registro.red_descripcion=lr.red_descripcion
                    --group by lib_registro.for_id
                ) as alta_temporal,
                (
                    select count(*)
                    from lib_formulario
                    join lib_columnas
                    on lib_columnas.col_id=lib_formulario.col_id
                    join lib_registro
                    on lib_registro.for_id=lib_formulario.for_id
                    where lib_formulario.for_id=673
                    and lib_registro.hc_id=lr.hc_id
                  and lib_registro.red_descripcion='1'
                    --and lib_registro.red_descripcion=lr.red_descripcion
                    --group by lib_registro.for_id
                ) as alta_definitiva
                from lib_formulario as lf
                join lib_columnas as lc
                on lc.col_id=lf.col_id
                join lib_registro as lr
                on lr.for_id=lf.for_id
                and lc.col_tipo=16
                and lr.red_descripcion!=''
                and lr.lib_fecha >='".$fecha_ini."'
                and lr.lib_fecha <='".$fecha_fin."'
                and lf.cua_id=$request->cua_id
                group by lr.red_descripcion,lr.hc_id)
                as rehavilitado_en
                group by red_descripcion
            ");
        }
        else
        {
            if($request->cua_id==0)
            {
                $list_paciente_rehabilitado = DB::select("
                select lc.cua_nombre,
                (
                    select count(lib_columnas.col_combre)
                    from lib_registro
                    join lib_formulario
                    on lib_formulario.for_id=lib_registro.for_id
                    join lib_columnas
                    on lib_columnas.col_id=lib_formulario.col_id
                    where lib_columnas.col_combre='Alta definitiva'
                    and lib_registro.red_descripcion='1'
                    and lib_formulario.cua_id=lc.cua_id
                    and lib_columnas.col_tipo='0'
                ) as alta_definitiva,
                (
                    select count(lib_columnas.col_combre)
                    from lib_registro
                    join lib_formulario
                    on lib_formulario.for_id=lib_registro.for_id
                    join lib_columnas
                    on lib_columnas.col_id=lib_formulario.col_id
                    where lib_columnas.col_combre='Alta temporal'
                    and lib_registro.red_descripcion='1'
                    and lib_formulario.cua_id=lc.cua_id
                    and lib_columnas.col_tipo='0'
                ) as alta_temporal
                from lib_cuadernos as lc
                ");
            }
            else{
                $list_paciente_rehabilitado = DB::select("
                    select lc.cua_nombre,
                        (
                        select count(lib_columnas.col_combre)
                            from lib_registro
                            join lib_formulario
                            on lib_formulario.for_id=lib_registro.for_id
                            join lib_columnas
                            on lib_columnas.col_id=lib_formulario.col_id
                            where lib_columnas.col_combre='Alta definitiva'
                            and lib_registro.red_descripcion='1'
                            and lib_formulario.cua_id=lc.cua_id
                            and lib_columnas.col_tipo='0'
                                    ) as alta_definitiva,
                                    (
                                    select count(lib_columnas.col_combre)
                                        from lib_registro
                                        join lib_formulario
                                        on lib_formulario.for_id=lib_registro.for_id
                                        join lib_columnas
                                        on lib_columnas.col_id=lib_formulario.col_id
                                        where lib_columnas.col_combre='Alta temporal'
                            and lib_registro.red_descripcion='1'
                            and lib_formulario.cua_id=lc.cua_id
                            and lib_columnas.col_tipo='0'
                                    ) as alta_temporal
                            from lib_cuadernos as lc
                            where lc.cua_id=$request->cua_id");

            }
        }

        /*
        $list_paciente_rehabilitado = DB::select("
            select col_combre as red_descripcion,sum(total) as total,sum(alta_temporal) as alta_temporal,sum(alta_definitiva) as alta_definitiva
            from (select lc.col_combre,lr.hc_id,
            count(*) as total,
            (
                select count(*)
                from lib_formulario
                join lib_columnas
                on lib_columnas.col_id=lib_formulario.col_id
                join lib_registro
                on lib_registro.for_id=lib_formulario.for_id
                where lib_formulario.for_id
                in(
										select lib_formulario.for_id from lib_columnas
										join lib_formulario
										on lib_formulario.col_id=lib_columnas.col_id
										where lib_columnas.col_combre like 'Alta temporal'
				)
                and lib_registro.hc_id=lr.hc_id
                and lib_registro.red_descripcion!=''
                --and lib_registro.red_descripcion=lr.red_descripcion
                --group by lib_registro.for_id
            ) as alta_temporal,
            (
                select count(*)
                from lib_formulario
                join lib_columnas
                on lib_columnas.col_id=lib_formulario.col_id
                join lib_registro
                on lib_registro.for_id=lib_formulario.for_id
                where lib_formulario.for_id
                in(
										select lib_formulario.for_id from lib_columnas
										join lib_formulario
										on lib_formulario.col_id=lib_columnas.col_id
										where lib_columnas.col_combre like 'Alta definitiva'
				)
                and lib_registro.hc_id=lr.hc_id
                and lib_registro.red_descripcion!=''
                --and lib_registro.red_descripcion=lr.red_descripcion
                --group by lib_registro.for_id
            ) as alta_definitiva
            from lib_formulario as lf
            join lib_columnas as lc
            on lc.col_id=lf.col_id
            join lib_registro as lr
            on lr.for_id=lf.for_id
            and lc.col_tipo=0
            and lr.red_descripcion!='0'
            and lr.lib_fecha >='".$fecha_ini."'
            and lr.lib_fecha <='".$fecha_fin."'
            and lf.cua_id=$request->cua_id
            group by lc.col_combre,lr.hc_id)
            as rehavilitado_en
            group by red_descripcion
        ");
        dd(end($list_paciente_rehabilitado));*/

//        dd($list_paciente_rehabilitado);



        $nombre_cuaderno = DB::table('lib_cuadernos')
            ->where('lib_cuadernos.cua_id','=',$request->cua_id)
            ->first();


        ReportTemplate::printHeaderFooter();
        PDF::AddPage('L', 'Letter');
        ReportTemplate::printTitle('PACIENTE REHABILITADO "'.strtoupper($nombre_cuaderno->cua_nombre).'"');


        if($request->cua_id==17)
            PDF::writeHTML(view('reporte._paciente_rehabilitado',["list_tratamiento_realizado"=>$list_paciente_rehabilitado,'fecha_ini'=>$fecha_ini,'fecha_fin'=>$fecha_fin])->render(), true, false, true, false, '');
        else
            PDF::writeHTML(view('reporte._alta',["list_tratamiento_realizado"=>$list_paciente_rehabilitado,'fecha_ini'=>$fecha_ini,'fecha_fin'=>$fecha_fin])->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('tratamiento_realizado.pdf');
        //dd($tratamiento_realizado);
    }
}
