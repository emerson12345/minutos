@extends('layouts.template')
@section('title')
    Institución
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()}}
    @else
        No autenticado
    @endif
@stop
@section('title_page')
    Nuevo usuario
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
                    Nueva institución
                </h3>
            </div>
            {!! Form::open(['route' => 'institucion.store' ,'class'=>'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('inst_codigo', 'CÓDIGO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_codigo',null,['class'=>'form-control']) !!}
                        @if ($errors->has('inst_codigo'))
                            <span class="label label-warning">
                                {{ $errors->first('inst_codigo') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('inst_nombre', 'NOMBRE', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_nombre',null,['class'=>'form-control']) !!}
                        @if ($errors->has('inst_nombre'))
                            <span class="label label-warning">
                                {{ $errors->first('inst_nombre') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_telf1', 'TELÉFONO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_telf1',null,['class'=>'form-control']) !!}
                        @if ($errors->has('inst_telf1'))
                            <span class="label label-warning">
                                {{ $errors->first('inst_telf1') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_telf2', 'TELÉFONO DOS', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_telf2',null,['class'=>'form-control']) !!}
                        @if ($errors->has('inst_telf2'))
                            <span class="label label-warning">
                                {{ $errors->first('inst_telf2') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_fax', 'FAX', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_fax',null,['class'=>'form-control','require']) !!}
                        @if ($errors->has('inst_fax'))
                            <span class="label label-warning">
                                {{ $errors->first('inst_fax') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_email', 'EMAIL', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::email('inst_email',null,['class'=>'form-control']) !!}
                        @if ($errors->has('inst_email'))
                            <span class="label label-warning">
                                {{ $errors->first('inst_email') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_nit', 'NIT', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_nit',null,['class'=>'form-control']) !!}
                        @if ($errors->has('inst_nit'))
                            <span class="label label-warning">
                                {{ $errors->first('inst_nit') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('dep_id', 'DEPARTAMENTO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('dep_id',$departamento,null,['class'=>'form-control']) !!}

                        @if ($errors->has('dep_id'))
                            <span class="label label-warning">
                                {{ $errors->first('dep_id') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('prov_id', 'PROVINCIA', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('prov_id',[],['placeholder'=>'Selecciona'],['class'=>'form-control']) !!}

                        @if ($errors->has('prov_id'))
                            <span class="label label-warning">
                                {{ $errors->first('prov_id') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('mun_id', 'MUNICIPIO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('mun_id',[],['placeholder'=>'Selecciona'],['class'=>'form-control']) !!}

                        @if ($errors->has('mun_id'))
                            <span class="label label-warning">
                                {{ $errors->first('mun_id') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_direccion_calle', 'DIRECCIÓN', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_direccion_calle',null,['class'=>'form-control']) !!}
                        @if ($errors->has('inst_direccion_calle'))
                            <span class="label label-warning">
                                {{ $errors->first('inst_direccion_calle') }}
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
@section('script')
    <script>
        $(document).ready(function() {
            $('#dep_id').change(function (e) {
                var parent = e.target.value;
                $.get('{{ url('provincia/')}}' + '/getprovincia?dep_id=' + parent, function (data) {
                    $('#prov_id').empty();
                    $.each(data, function (key, value) {
                        var option = $("<option></option>")
                                .attr("value", key)
                                .text(value);

                        $('#prov_id').append(option);
                    });
                });
            });
            /*-----------------*/
            $('#prov_id').change(function (e) {
                var parent = e.target.value;
                $.get('{{ url('municipio/')}}' + '/getmunicipio?prov_id=' + parent, function (data) {
                    $('#mun_id').empty();
                    $.each(data, function (key, value) {
                        var option = $("<option></option>")
                                .attr("value", key)
                                .text(value);
                        $('#mun_id').append(option);
                    });
                });
            });
        });
    </script>
@stop
