<?php

namespace Sicere\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;
use Sicere\Http\Requests;
use Sicere\Http\Controllers\Controller;
use Sicere\Models\Institucion;
use Sicere\Models\LugarDepartamento;
use Sicere\Models\LugarProvincia;
use Sicere\Models\LugarMunicipio;
use Sicere\Models\LugarArea;
use Yajra\Datatables\Datatables;
use PDF;
class InstitucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function institucion(){
        return Datatables::of(Institucion::all())->make(true);
    }

    public function index()
    {
        //
        return view('institucion.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $listInstitucion = new Institucion();
        $departamento = LugarDepartamento::listas();
        $provincia= LugarProvincia::Provincias(0);
        $municipio=LugarMunicipio::Municipios(0);
        $area=LugarArea::Areas(0);
        return view('institucion.form',[ 'institucion' => $listInstitucion, 'departamento'=> $departamento,'provincia'=> $provincia,'municipio'=> $municipio,'area'=>$area]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$inst_id = 0){
        $institucion= new Institucion();
        if($inst_id)
            $institucion = Institucion::find($inst_id);
        $this->validate($request,[
            'inst_codigo' => ['required',Rule::unique('institucion')->ignore($inst_id,'inst_id')],
            'inst_nombre' => 'required',
            'dep_id' => 'required',
            'prov_id' => 'required',
            'mun_id'=>'required',
            'area_id'=>'required',
            'inst_email' => ['email',Rule::unique('institucion')->ignore($inst_id,'inst_id')],
            'inst_seleccionable' => 'boolean'
        ],[
            'required' => 'Este campo es requerido.',
            'email' => 'Debe introducir un correo valido.',
            'boolean' => 'Seleccione una opcion valida.',
            'unique' => 'Este valor ya ha sido registrado'
        ]);
        $institucion->fill($request->all())->save();
        return response()->json($institucion);
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
    public function edit($idInst){
        $institucion  = Institucion::find($idInst);
        $departamento = LugarDepartamento::listas();
        $provincia    = LugarProvincia::Provincias($institucion->dep_id);
        $municipio    = LugarMunicipio::Municipios($institucion->prov_id);
        $area         = LugarArea::Areas($institucion->dep_id);
        return view('institucion.form',['institucion'=>$institucion,'departamento'=> $departamento,'provincia'=> $provincia,'municipio'=> $municipio,'area'=>$area]);
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
    //
    public function getProvincias(Request $request, $id){
        if($request->ajax()){
            $provincias = LugarProvincia::Provincias($id);
            return response()->json($provincias);
        }
    }

    public function report(){
       // Institucion::get_institucion();  fgdgd
        PDF::setHeaderCallback(function($pdf) {
            $pdf->Cell(0, 27, '', 'B', false, 'R', 0, '', 0, false, 'T', 'M');
            $pdf->Image(asset('template/dist/img/bolivia.jpg'), 15, 10, 0, 15, 'JPG', 'https://www.minsalud.gob.bo', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Text(33,22,'Sistema de centros de rehabilitación','R');
            $pdf->SetFont('helvetica', 'K', 10);
            //$pdf->Text(15,27,'Establecimiento: '.session('institucion')->inst_nombre);
            $pdf->Image(asset('template/dist/img/minsalud-logo.jpg'), 25, 12, 0, 12, 'JPG', 'https://www.minsalud.gob.bo', '', true, 150, 'R', false, false, 0, false, false, false);
        });

        PDF::setFooterCallback(function($pdf) {
            $strCodSeguridad=session('institucion')->inst_codigo . '|' . session('institucion')->inst_nombre .'|' . Auth::user()->user_id;
            $pdf->SetY(-15);
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 10, 'Pagina '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 'T', false, 'R', 0, '', 0, false, 'T', 'M');
            //$pdf->write2DBarcode(bcrypt('Mi super codigo'), 'PDF417', 25, 275, 150, 6, null, 'N',true);
            $pdf->write2DBarcode($strCodSeguridad, 'PDF417', 25, 275, 150, 6, null, 'N',true);
        });
        PDF::SetTitle('Reportes');
        PDF::SetSubject('Reporte de sistema');
        PDF::SetMargins(15, 30, 15);
        PDF::SetFontSubsetting(false);
        PDF::SetFontSize('10px');
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage('L', 'Letter');
        PDF::writeHTML(view('institucion.report')->render(), true, false, true, false, '');
        PDF::lastPage();
        PDF::Output('estableciminetos.pdf','I');
    }
}
