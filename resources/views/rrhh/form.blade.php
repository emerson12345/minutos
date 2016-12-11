{!! Form::model($rrhh,['class'=>'form-horizontal']) !!}
<div class="row">
    <div class="col-md-6">
        <div class="well well-sm">
            <div class="form-group">
                {!! Form::label('rrhh_ci', 'C.I.', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('rrhh_ci',null,['class'=>'form-control']) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('rrhh_ap_prim', 'Primer apellido', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('rrhh_ap_prim',null,['class'=>'form-control']) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('rrhh_ap_seg', 'Segundo apellido', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('rrhh_ap_seg',null,['class'=>'form-control']) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('rrhh_nombre', 'Nombre(s)', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('rrhh_nombre',null,['class'=>'form-control','required'=>true]) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('rrhh_fecha_nac', 'Fecha de nacimiento', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('rrhh_fecha_nac',$rrhh->rrhh_fecha_nac?date('d/m/Y',strtotime($rrhh->rrhh_fecha_nac)):'',['class'=>'form-control']) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('rrhh_sexo', 'Sexo', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    HOMBRE
                    {!! Form::radio('rrhh_sexo','H') !!}
                    MUJER
                    {!! Form::radio('rrhh_sexo','M') !!}
                    <span class="label label-warning"></span>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-6">
        <div class="well well-sm">
            <div class="form-group">
                {!! Form::label('rrhh_direccion_calle', 'Dirección', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('rrhh_direccion_calle',null,['class'=>'form-control','require']) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('rrhh_telf_celular', 'Teléf.-Celular', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('rrhh_telf_celular',null,['class'=>'form-control']) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('rrhh_email', 'Email', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::email('rrhh_email',null,['class'=>'form-control']) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('prof_id', 'Profesión', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::select('prof_id',$profesion_list ,null,['placeholder'=>'Selecciona','class'=>'form-control']) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('rrhh_tipo_id', 'Fuente de financiamiento', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::select('rrhh_tipo_id',$tipo_rrhh_list,null,['placeholder'=>'Selecciona','class'=>'form-control','require']) !!}
                    <span class="label label-warning"></span>
                </div>
            </div>

            @if($rrhh->exists)
            <div class="form-group">
                {!! Form::label('rrhh_seleccionable', 'Estado', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    Vigente
                    {!! Form::radio('rrhh_seleccionable','1',true) !!}
                    No vigente
                    {!! Form::radio('rrhh_seleccionable','0') !!}
                    <span class="label label-warning"></span>
                </div>
            </div>
            @else
                {!! Form::hidden('rrhh_seleccionable',1) !!}
            @endif
        </div>
    </div>
</div>


{!! Form::close() !!}
