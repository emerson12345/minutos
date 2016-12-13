{!! Form::model($convenio,['class'=>'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('conv_codigo', 'CODIGO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('conv_codigo',null,['class'=>'form-control','maxlength'=>15]) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('conv_nombre', 'NOMBRE', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('conv_nombre',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

@if($convenio->exists)
<div class="form-group">
    {!! Form::label('conv_seleccionable', 'ESTADO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <label for="e_si">Vigente</label>
        {!! Form::radio('conv_seleccionable','1',true,['id'=>'e_si']) !!}
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="e_no">NO vigente</label>
        {!! Form::radio('conv_seleccionable','0',false,['id'=>'e_no']) !!}
        <span class="label label-warning"></span>
    </div>
</div>
@else
    {!! Form::hidden('conv_seleccionable',1) !!}
@endif

<div class="form-group">
    {!! Form::label('conv_niv_nacional', 'A NIVEL NACIONAL', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <label for="cn_si">SI</label>
        {!! Form::radio('conv_niv_nacional','1',false,['id'=>'cn_si']) !!}
        &nbsp;&nbsp;&nbsp;&nbsp;
        <label for="cn_no">NO</label>
        {!! Form::radio('conv_niv_nacional','0',true,['id'=>'cn_no']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group {{($convenio->conv_niv_nacional)?'hidden':''}}" id="municipios">
    {!! Form::label('municipios','MUNICIPIOS',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <span class="label label-warning"></span>
        {!! Form::select('municipios[]',\Sicere\Models\LugarMunicipio::all()->pluck('mun_nombre','mun_id'),$convenio->municipios()->pluck('lugar_municipio.mun_id')->toArray() ,['class'=>'form-control','multiple'=>true]) !!}
    </div>
</div>
{!! Form::close() !!}
<script>
    var demo1 =$('select[name="municipios[]"]').bootstrapDualListbox
    ({
        filterPlaceHolder:'filtrar',
        selectedListLabel:'Seleccionados',
        nonSelectedListLabel:'Disponibles',
        infoText:'Total ({0})',
        infoTextEmpty:'Lista vacia',
        filterTextClear:'Todos',
        infoTextFiltered: '<span class="label label-warning">Filtrados</span> {0} de {1}'
    });
</script>