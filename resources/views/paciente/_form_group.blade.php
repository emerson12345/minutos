<div class="row">
    <div class="col-md-12">
        <span class="text-uppercase">{{$paciente->nombreCompleto}}</span>
        <button class="btn btn-index-group btn-primary btn-xs margin-bottom pull-right" data-url="{{route('adm.paciente.group',['pac_id'=>$paciente->pac_id])}}">
            <i class="fa fa-group"></i> Grupo familiar
        </button>
    </div>
</div>
{!! Form::model($gPersona,['class'=>'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('parent_id', 'PARENTESCO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('parent_id',\Sicere\Models\Parentesco::all()->pluck('parent_nombre','parent_id'),$gPersona->parent_id,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_nro_ci', 'C.I.', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_nro_ci',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_ap_prim', 'PRIMER APELLIDO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_ap_prim',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_ap_seg', 'SEGUNDO APELLIDO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_ap_seg',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_nombre', 'NOMBRES', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_nombre',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_sexo', 'SEXO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <label for="s_masc">Masculino</label>
        {!! Form::radio('gru_fam_sexo','M',true,['id'=>'s_masc']) !!}
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="s_fem">Femenino</label>
        {!! Form::radio('gru_fam_sexo','F',false,['id'=>'s_fem']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_telf', 'TELEFONO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_telf',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_direccion', 'DIRECCION', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_direccion',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_seleccionable', 'ESTADO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <label for="s_sel">Vigente</label>
        {!! Form::radio('gru_fam_seleccionable','1',true,['id'=>'s_sel']) !!}
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="s_nsel">No vigente</label>
        {!! Form::radio('gru_fam_seleccionable','0',false,['id'=>'s_nsel']) !!}
        <span class="label label-warning"></span>
    </div>
</div>


<button type="button" class="btn btn-primary pull-right" id="btn-save-group">
    <i class="fa fa-save"></i> Guardar
</button>

{!! Form::close() !!}