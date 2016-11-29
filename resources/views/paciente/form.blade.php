{!! Form::model($paciente) !!}
<div class="row">
    <div class="col-md-6">
        <div class="well well-sm">
            <h5><strong>Informacion basica</strong></h5>
            <div class="form-group">
                {!! Form::label('pac_nro_hc', 'NRO. H.C.') !!}
                {!! Form::text('pac_nro_hc',null,['class'=>'form-control input-sm']) !!}
                <span class="label label-warning"></span>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::label('pac_nro_ci', 'C.I.:') !!}
                        {!! Form::text('pac_nro_ci',null,['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('exp_id', 'EXP.') !!}
                        {!! Form::select('exp_id',\Sicere\Models\CiExpedido::orderBy('exp_id','asc')->get()->pluck('exp_nombre','exp_id'),$paciente->exp_id,['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('pac_ap_prim', '1ER. APELLIDO') !!}
                {!! Form::text('pac_ap_prim',null,['class'=>'form-control input-sm']) !!}
                <span class="label label-warning"></span>
            </div>

            <div class="form-group">
                {!! Form::label('pac_ap_seg', '2DO. APELLIDO') !!}
                {!! Form::text('pac_ap_seg',null,['class'=>'form-control input-sm']) !!}
                <span class="label label-warning"></span>
            </div>

            <div class="form-group">
                {!! Form::label('pac_nombre', 'NOMBRES') !!}
                {!! Form::text('pac_nombre',null,['class'=>'form-control input-sm']) !!}
                <span class="label label-warning"></span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('pac_sexo', 'SEXO') !!}<br>
                        <label for="s_masc">Hombre</label>
                        {!! Form::radio('pac_sexo','H',true,['id'=>'s_masc']) !!}
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="s_fem">Mujer</label>
                        {!! Form::radio('pac_sexo','M',false,['id'=>'s_fem']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php $estCivList = \Sicere\Models\EstadoCivil::orderBy('est_civ_id','desc')->get()->pluck('est_civ_nombre','est_civ_id');?>
                    <div class="form-group">
                        {!! Form::label('est_civ_id', 'ESTADO CIVIL') !!}
                        {!! Form::select('est_civ_id',$estCivList,$paciente->ext_civ_id,['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('pac_fecha_nac', 'FECHA NACIMIENTO') !!}
                        {!! Form::text('pac_fecha_nac',$paciente->pac_fecha_nac?date('d/m/Y',strtotime($paciente->pac_fecha_nac)):'',['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('pac_edad_anio', 'EDAD') !!}
                        {!! Form::text('pac_edad_anio',null,['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('pac_ocupacion', 'OCUPACION') !!}
                {!! Form::text('pac_ocupacion',null,['class'=>'form-control input-sm']) !!}
                <span class="label label-warning"></span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="well well-sm">
            <h5><strong>Informacion discapacidad</strong></h5>
            <div class="form-group">
                {!! Form::label('pac_con_discapaci', 'DISCAPACIDAD PERM.') !!}<br>
                <label for="disc_si">SI</label>
                {!! Form::radio('pac_con_discapaci','1',false,['id'=>'disc_si']) !!}
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label for="disc_no">NO</label>
                {!! Form::radio('pac_con_discapaci','0',true, ['id'=>'disc_no']) !!}
                <span class="label label-warning"></span>
            </div>

            <div class="row">
                <?php
                $tipoList = \Sicere\Models\DiscapaciTipo::all()->orderBy('tipo_disc_nombre DESC')->pluck('tipo_disc_nombre','tipo_disc_id');
                $gradoList = \Sicere\Models\DiscapaciGrado::all()->pluck('grad_disc_nombre','grad_disc_id');
                $gradoList->prepend('','0');
                ?>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('tipo_disc_id', 'TIPO DISC.') !!}
                        <input type="hidden" name="tipo_disc_id" value="0">
                        {!! Form::select('tipo_disc_id',$tipoList,$paciente->tipo_disc_id,['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('grad_disc_id', 'GRADO DISC.') !!}
                        <input type="hidden" name="grad_disc_id" value="0">
                        {!! Form::select('grad_disc_id',$gradoList,$paciente->grado_disc_id,['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="well well-sm">
            <h5><strong>Residencia</strong></h5>
            <div class="row">
                <div class="col-md-6">
                    <?php
                        $depList = \Sicere\Models\LugarDepartamento::all()->pluck('dep_nombre','dep_id');
                        $depList->prepend('','0');
                        $munList = ['0'=>''];
                        if($paciente->departamento){
                            $munList = $paciente->departamento->municipios()->pluck('mun_nombre','mun_id');
                            $munList->prepend('','0');
                        }
                    ?>

                    <div class="form-group">
                        {!! Form::label('dep_id', 'DEPARTAMENTO') !!}
                        {!! Form::select('dep_id',$depList,$paciente->dep_id,['class'=>'form-control input-sm','data-url'=>route('get.municipios')]) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('mun_id', 'MUNICIPIO') !!}
                        {!! Form::select('mun_id',$munList,$paciente->mun_id,['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('pac_comunidad', 'COMUNIDAD') !!}
                {!! Form::text('pac_comunidad',null,['class'=>'form-control input-sm']) !!}
                <span class="label label-warning"></span>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::label('pac_direccion', 'DIRECCION') !!}
                        {!! Form::text('pac_direccion',null,['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('pac_nro_telf', 'TELEFONO') !!}
                        {!! Form::text('pac_nro_telf',null,['class'=>'form-control input-sm']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="well well-sm">
            <h5><strong>Otros</strong></h5>
            <div class="form-group">
                {!! Form::label('pac_seleccionable', 'ESTADO') !!}<br>
                <label for="sel_si">VIGENTE</label>
                {!! Form::radio('pac_seleccionable','1',true,['id'=>'sel_si']) !!}
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label for="sel_no">NO VIGENTE</label>
                {!! Form::radio('pac_seleccionable','0',false, ['id'=>'sel_no']) !!}
                <span class="label label-warning"></span>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
