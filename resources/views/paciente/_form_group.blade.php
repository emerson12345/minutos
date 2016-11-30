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
    {!! Form::label('parent_id', 'Parentesco', ['class' => 'col-sm-2 control-label']) !!}
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
    {!! Form::label('gru_fam_ap_prim', 'Primer apellido', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_ap_prim',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_ap_seg', 'Segundo apellido', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_ap_seg',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_nombre', 'Nombres', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_nombre',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_sexo', 'Sexo', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <label for="s_masc">Hombre</label>
        {!! Form::radio('gru_fam_sexo','H',true,['id'=>'s_masc']) !!}
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="s_fem">Mujer</label>
        {!! Form::radio('gru_fam_sexo','M',false,['id'=>'s_fem']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_telf', 'Teléfono', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_telf',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_direccion', 'Dirección', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('gru_fam_direccion',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('gru_fam_seleccionable', 'Fallecido', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::hidden('gru_fam_seleccionable','1') !!}
        {!! Form::checkbox('gru_fam_seleccionable','0',($gPersona->gru_fam_seleccionable||!$gPersona->exists)?false:true) !!}
        <span class="label label-warning"></span>
    </div>
</div>


<button type="button" class="btn btn-primary pull-right" id="btn-save-group">
    <i class="fa fa-save"></i> Guardar
</button>

{!! Form::close() !!}