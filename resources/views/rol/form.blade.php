@extends('layouts.template')
@section('title')
    Form roles
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()}}
    @else
        No autenticado
    @endif
@stop
@section('title_page')
    form roles
@stop
@section('menu_page')
    <h4>Roles</h4>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>Inicio</a>
        </li>
        <li class="active">
            <a href="#">Estado civil</a>
        </li>
    </ol>
@stop

@section('content')
    <section class="content">

        <div class="box box-primary box-solid">
            <div class="box-header">
                <h3 class="box-title">
                    Roles
                </h3>
            </div>
            {!! Form::model($rol,['class'=>'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('rol_codigo', 'CODIGO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('rol_codigo',null,['class'=>'form-control']) !!}
                        @if ($errors->has('rol_codigo'))
                            <span class="label label-warning">
                                {{ $errors->first('rol_codigo') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rol_nombre', 'NOMBRE DE ROL', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('rol_nombre',null,['class'=>'form-control']) !!}
                        @if ($errors->has('rol_nombre'))
                            <span class="label label-warning">
                                {{ $errors->first('rol_nombre') }}
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('rol_seleccionable', 'SEL', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        Vigente
                        {!! Form::radio('rol_seleccionable','1',true) !!}
                        No vigente
                        {!! Form::radio('rol_seleccionable','0') !!}
                        @if ($errors->has('rol_seleccionable'))
                            <span class="label label-warning">
                                {{ $errors->first('rol_seleccionable') }}
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('app_list','PERMISOS',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('app_list[]',\Sicere\Models\Aplicacion::pluck('app_nombre','app_id'),null,['class'=>'form-control', 'multiple'=>true,'id'=>'role_list','style'=>'width:100%']) !!}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="pull-right btn btn-primary">
                    Guardar
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop

@section('script')
    <link rel="stylesheet" href="{{asset('template/plugins/select2/select2.css')}}">
    <script src="{{asset('template/plugins/select2/select2.min.js')}}"></script>
    <script>
        $("#role_list").select2();
    </script>
@stop