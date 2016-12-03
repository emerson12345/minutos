<h4>Permiso a cuadernos</h4>
{!! Form::model($usuario,['route' => ['adm.usuario.set_cuaderno',$usuario->user_id] ,'class'=>'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('user_nombre', 'Apellidos y nombres', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('user_nombre',null,['class'=>'form-control', 'disabled'=>'disabled']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('cuaderno_list','Cuadernos',['class'=>'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <span class="label label-warning"></span>
        {!! Form::select('cuaderno_list[]',\Sicere\Models\LibCuaderno::where('cua_seleccionable',1)->pluck('cua_nombre','cua_id'),$usuario->cuadernos()->pluck('lib_cuadernos.cua_id')->toArray(),['class'=>'form-control roles', 'multiple'=>true,'id'=>'cuaderno_list','style'=>'width:100%']) !!}
    </div>
</div>

{!! Form::close() !!}