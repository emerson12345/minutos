{!! Form::model($paciente,['class'=>'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('pac_nro_hc', 'NRO. H.C.', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('pac_nro_hc',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('pac_nro_ci', 'C.I.:', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('pac_nro_ci',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('pac_ap_prim', '1ER. APELLIDO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('pac_ap_prim',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('pac_ap_seg', '2DO. APELLIDO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('pac_ap_seg',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('pac_nombre', 'NOMBRES', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('pac_nombre',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('pac_sexo', 'SEXO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <label for="s_masc">Masculino</label>
        {!! Form::radio('pac_sexo','M',true,['id'=>'s_masc']) !!}
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="s_fem">Femenino</label>
        {!! Form::radio('pac_sexo','F',false,['id'=>'s_fem']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('pac_fecha_nac', 'FECHA NACIMIENTO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('pac_fecha_nac',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('pac_con_discapaci', 'DISCAPACITADO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <label for="disc_si">SI</label>
        {!! Form::radio('pac_con_discapaci','1',false,['id'=>'disc_si']) !!}
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="disc_no">NO</label>
        {!! Form::radio('pac_con_discapaci','0',true, ['id'=>'disc_no']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

{!! Form::close() !!}
