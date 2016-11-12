{!! Form::model($rol,['class'=>'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('rol_codigo', 'CODIGO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('rol_codigo',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('rol_nombre', 'NOMBRE DE ROL', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('rol_nombre',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>


<div class="form-group">
    {!! Form::label('rol_seleccionable', 'SEL', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        Vigente
        {!! Form::radio('rol_seleccionable','1',true) !!}
        No vigente
        {!! Form::radio('rol_seleccionable','0') !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('app_list','PERMISOS',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('app_list[]',\Sicere\Models\Aplicacion::where('app_seleccionable',1)->pluck('app_nombre','app_id'),$rol->aplicaciones()->pluck('aplicacion.app_id')->toArray(),['class'=>'form-control', 'multiple'=>true,'id'=>'app_list','style'=>'width:100%']) !!}
    </div>
</div>


{!! Form::close() !!}

@section('script')
    <link rel="stylesheet" href="{{asset('template/plugins/bootstrap-duallist/bootstrap-duallistbox.css')}}">
    <script src="{{asset('template/plugins/bootstrap-duallist/jquery.bootstrap-duallistbox.js')}}"></script>
    <script>
        $("#app_list").bootstrapDualListbox({
            filterPlaceHolder:'filtrar',
            selectedListLabel:'Seleccionados',
            nonSelectedListLabel:'Disponibles',
            infoText:'',
            infoTextEmpty:'',
            filterTextClear:'Todos'
        });
    </script>
@stop