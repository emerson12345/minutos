@extends('layouts.template')
@section('title')
    Instituciones
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()}}
    @else
        No autenticado
    @endif
@stop
@section('title_page')
    Nueva institución
@stop
@section('menu_page')
    <h4>Nuevo</h4>
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
                    Nueva intitución
                </h3>
            </div>
            {!! Form::model($usuario,['route' => ['usuario.update',$usuario->user_id] ,'class'=>'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('user_nombre', 'NOMBRE COMPLETO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('user_nombre',null,['class'=>'form-control']) !!}
                        @if ($errors->has('user_nombre'))
                            <span class="label label-warning">
                                {{ $errors->first('user_nombre') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('user_codigo', 'USUARIO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('user_codigo',null,['class'=>'form-control']) !!}
                        @if ($errors->has('user_codigo'))
                            <span class="label label-warning">
                                {{ $errors->first('user_codigo') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('user_password', 'PASSWORD', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::password('user_password',['class'=>'form-control']) !!}
                        @if ($errors->has('user_password'))
                            <span class="label label-warning">
                                {{ $errors->first('user_password') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('user_password2', 'REPETIR PASSWORD', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::password('user_password2',['class'=>'form-control']) !!}
                        @if ($errors->has('user_password2'))
                            <span class="label label-warning">
                                {{ $errors->first('user_password2') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('user_email', 'EMAIL', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::email('user_email',null,['class'=>'form-control']) !!}
                        @if ($errors->has('user_email'))
                            <span class="label label-warning">
                                {{ $errors->first('user_email') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('user_seleccionable', 'SEL', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        Vigente
                        {!! Form::radio('user_seleccionable','1',true) !!}
                        No vigente
                        {!! Form::radio('user_seleccionable','0') !!}
                        @if ($errors->has('user_seleccionable'))
                            <span class="label label-warning">
                                {{ $errors->first('user_seleccionable') }}
                            </span>
                        @endif
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
