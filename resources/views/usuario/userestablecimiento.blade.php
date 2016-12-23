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
        <div class="row margin-bottom">
            <div class="col-md-4">
                <?php
                    $listDep = \Sicere\Models\LugarDepartamento::all()->pluck('dep_nombre','dep_id');
                    $listDep->prepend('TODO',0);
                ?>
                <label>POR DEPARTAMENTOS</label>
                {!! Form::select('departamento',$listDep,null,['class'=>'form-control','data-url'=>route('adm.permiso.municipios'),'data-token'=>csrf_token()]) !!}
            </div>
            <div class="col-md-4">
                <label>POR MUNICIPIOS</label>
                {!! Form::select('municipio',[0=>'TODO'],null,['class'=>'form-control','data-url'=>route('adm.permiso.areas'),'data-token'=>csrf_token()]) !!}
            </div>
            <div class="col-md-4">
                <label>POR RED DE SALUD</label>
                {!! Form::select('area',[0=>'TODO'],null,['class'=>'form-control']) !!}
            </div>
        </div>
        {!! Form::select('institucion_list[]',\Sicere\Models\Institucion::where('inst_seleccionable',1)->pluck('inst_nombre','inst_id'),$usuario->instituciones()->pluck('institucion.inst_id')->toArray(),['class'=>'form-control roles', 'multiple'=>true,'id'=>'institucion_list','style'=>'width:100%','data-url'=>route('adm.permiso.establecimientos')]) !!}
    </div>
</div>

{!! Form::close() !!}