<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;

use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\LibCuaderno;
use Sicere\Models\LibFormulario;
use Illuminate\Support\Facades\DB;

class LibCuadernoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listCuadernos = LibCuaderno::all();
        return view('cuadernos.show',[ 'listCuadernos' => $listCuadernos ]);
    }
    public function peticion($id)
    {
        $listFormularios = DB::table('lib_cuadernos')
            ->join('lib_formulario', 'lib_cuadernos.cua_id', '=', 'lib_formulario.cua_id')
            ->join('lib_columnas', 'lib_columnas.col_id', '=', 'lib_formulario.col_id')
            ->where('lib_cuadernos.cua_id', '=', $id)
            ->select('lib_cuadernos.cua_id','lib_cuadernos.cua_nombre' ,'lib_formulario.for_id'
                ,'lib_columnas.col_id','lib_columnas.col_combre','lib_columnas.col_tipo')
            ->get();
        //echo $users[0]->cua_id;
        //print_r($users);

        //$listFormularios = LibFormulario::all();
        return view('formulario.show',['listFormularios' => $listFormularios ]);
    }
    public function peticionListas($intIDColumna)
    {

        $listFormularios = DB::table('lib_columnas')
            ->join('lib_relaciona_tablas', 'lib_columnas.rel_id', '=', 'lib_relaciona_tablas.rel_id')
            ->join('lib_lista_generica', 'lib_lista_generica.lis_tabla', '=', 'lib_relaciona_tablas.lis_tabla')
            ->where('lib_columnas.col_id', '=', $intIDColumna)
            ->select('lib_lista_generica.lis_codigo','lib_lista_generica.lis_descripcion','lib_columnas.col_combre')
            ->get();

        //echo $users[0]->cua_id;
        //print_r($listFormularios);
        //$listFormularios = LibFormulario::all();

        return view('lista_generica.show',['listFormularios' => $listFormularios ]);
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