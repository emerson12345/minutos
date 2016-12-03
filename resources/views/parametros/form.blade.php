@extends('layouts.template')
@section('title')
    Variables de sistema
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Crear/Editar
@stop
@section('menu_page')
Parámetros de sistema
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{route('parametro.index')}}">Parámetros de configuración</a>
        </li>
    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            {!! Form::model($setup,['route' => 'parametro.update' ,'class'=>'form-horizontal']) !!}
            <div class="box-body">
                <div class="text-danger">
                    {{Session::get('message')}}
                </div>
                <div class="text-info">
                    {{Session::get('status')}}
                </div>
                <div class="form-group">
                    <div class="col-sm-3">
                        {!! Form::hidden('set_id',$setup->set_id,['class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('set_descripcion', $setup->set_descripcion, ['class' => 'col-sm-8 control-label']) !!}

                    <div class="col-sm-3">
                        {!! Form::number('set_valor',$setup->set_valor,['min'=>'0','class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop
