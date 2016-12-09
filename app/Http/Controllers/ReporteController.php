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
}
