{!! Form::model($usuario,['route' => ['adm.permiso.set_establecimiento',$usuario->user_id] ,'class'=>'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('user_nombre', 'Apellidos y nombres', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('user_nombre',null,['class'=>'form-control', 'disabled'=>'disabled']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('institucion_list','Establecimientos',['class'=>'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <span class="label label-warning"></span>
        {!! Form::select('institucion_list[]',\Sicere\Models\Institucion::where('inst_seleccionable',1)->pluck('inst_nombre','inst_id'),$usuario->instituciones()->pluck('institucion.inst_id')->toArray(),['class'=>'form-control roles', 'multiple'=>true,'id'=>'institucion_list','style'=>'width:100%']) !!}
    </div>
</div>

{!! Form::close() !!}