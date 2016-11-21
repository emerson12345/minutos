<?php

namespace Sicere\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\Rrhh;
use Sicere\Models\RrhhTipo;
use Sicere\Models\Profesione;
use Yajra\Datatables\Datatables;
class RrhhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rrhh(){
         $inst_id=session('institucion')->inst_id;
        //return Datatables::of(Rrhh::all())->make(true);
        return Datatables::of(Rrhh::where('inst_id',$inst_id)->get())->make(true);
        //where('dep_id', $request->dep_id)->pluck('prov_nombre', 'prov_id')
    }
    public function index()
    {
        //
        return view('rrhh.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $rrhh = new Rrhh();
        $profesion_list= Profesione::Lista();
        $tipo_rrhh_list=RrhhTipo::Lista();
        return view('rrhh.form',[ 'rrhh' => $rrhh, 'profesion_list'=> $profesion_list,'tipo_rrhh_list'=> $tipo_rrhh_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$idRrhh=0)
    {
        //
        $rrhh= new Rrhh();
        if($idRrhh)
            $rrhh = Rrhh::find($idRrhh);
        $this->validate($request,[
            'rrhh_ci' => [Rule::unique('rrhh')->ignore($idRrhh,'rrhh_id')],
            'rrhh_ap_prim' => 'required',
            'rrhh_nombre' => 'required',
            'prof_id' => 'required',
            'rrhh_tipo_id'=>'required',
            'rrhh_email' => ['email',Rule::unique('rrhh')->ignore($idRrhh,'rrhh_id')],
            'rrhh_seleccionable' => 'boolean',
            'rrhh_sexo' => 'required'
        ],[
            'required' => 'Este campo es requerido.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.',
            'unique' => 'Este valor ya ha sido registrado'
        ]);
        $user_id=Auth::user()->user_id;
        $inst_id=session('institucion')->inst_id;
        $redor_rrhh=['rrhh_ci'=> $request->rrhh_ci,
            'rrhh_ap_prim'=> $request->rrhh_ap_prim,
            'rrhh_ap_seg'=> $request->rrhh_ap_seg,
            'rrhh_nombre'=> $request->rrhh_nombre,
            'rrhh_fecha_nac'=> $request->rrhh_fecha_nac,
            'rrhh_sexo'=> $request->rrhh_sexo,
            'rrhh_direccion_calle'=> $request->rrhh_direccion_calle,
            'rrhh_telf_celular'=> $request->rrhh_telf_celular,
            'rrhh_email'=> $request->rrhh_email,
            'prof_id'=> $request->prof_id,
            'rrhh_tipo_id'=> $request->rrhh_tipo_id,
            'inst_id'=> $inst_id,
            'rrhh_seleccionable'=> $request->rrhh_seleccionable,
            'user_id' => $user_id];
       $rrhh->fill($redor_rrhh)->save();
       return response()->json($rrhh);

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
    public function edit($idRrhh)
    {
        //
        $rrhh  = Rrhh::find($idRrhh);
        $profesion_list= Profesione::Lista();
        $tipo_rrhh_list=RrhhTipo::Lista();
        return view('rrhh.form',[ 'rrhh' => $rrhh, 'profesion_list'=> $profesion_list,'tipo_rrhh_list'=> $tipo_rrhh_list]);

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
