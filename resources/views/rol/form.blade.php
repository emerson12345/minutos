<?php
    $app_list = \Sicere\Models\Aplicacion::where([
        'app_seleccionable'=>1,
        'app_renderiza'=>1,
        'app_nivel_menu'=>2
    ])->pluck('app_nombre','app_id');
?>
{!! Form::model($rol,['class'=>'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('rol_codigo', 'CÓDIGO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('rol_codigo',null,['class'=>'form-control','maxlength'=>20]) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('rol_nombre', 'NOMBRE DE ROL', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('rol_nombre',null,['class'=>'form-control','maxlength'=>120]) !!}
        <span class="label label-warning"></span>
    </div>
</div>

@if($rol->exists)
<div class="form-group">
    {!! Form::label('rol_seleccionable', 'ESTADO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        Vigente
        {!! Form::radio('rol_seleccionable','1',true) !!}
        No vigente
        {!! Form::radio('rol_seleccionable','0') !!}
        <span class="label label-warning"></span>
    </div>
</div>
@else
    {!! Form::hidden('rol_seleccionable',1) !!}
@endif

<div class="form-group">
    {!! Form::label('app_list','PERMISOS',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <span class="label label-warning"></span>
        {!! Form::select('app_list[]',$app_list,$rol->aplicaciones()->pluck('aplicacion.app_id')->toArray(),['class'=>'form-control', 'multiple'=>true,'id'=>'app_list','style'=>'width:100%']) !!}
    </div>
</div>


{!! Form::close() !!}
<script>
    var demo1 =$('select[name="app_list[]"]').bootstrapDualListbox
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

