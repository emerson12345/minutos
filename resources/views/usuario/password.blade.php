@extends('layouts.template')
@section('title')
    Usuarios
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Usuarios
@stop
@section('menu_page')
    <h1>Modificar contraseña</h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>

        </li>
    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body">
                    <div class="text-danger">
                        {{Session::get('message')}}
                    </div>
                <div class="text-info">
                    {{Session::get('status')}}
                </div>
                <div class="row">
                    {!! Form::model($usuario,['route' => ['adm.usuario.update_password'] ,'class'=>'form-horizontal']) !!}

                    <div class="form-group">
                        {!! Form::label('user_password_actual', 'Contraseña actual', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::password('user_password_actual',['class'=>'form-control']) !!}
                            <div class="text-danger">{{$errors->first('user_password_actual')}}</div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('user_password', 'Nueva contraseña', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::password('user_password',['class'=>'form-control']) !!}
                            <div class="text-danger">{{$errors->first('user_password')}}</div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('user_password2', 'Repetir nueva contraseña', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-lg-8">
                            {!! Form::password('user_password2',['class'=>'form-control']) !!}
                            <div class="text-danger">{{$errors->first('user_password2')}}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-save"></i> Modificar contraseña</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

@stop










