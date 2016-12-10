@extends('layouts.template')
@section('title')
    Reporte
@stop
@section('title_page')
    Reporte
@stop
@section('menu_page')
    <h1>Reporte <small>morbilidad</small></h1>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid" id="conte-knt-agenda">
            {!! Form::open(['class'=>'form-horizontal','target'=>'_blank']) !!}
            <div class="box-body no-padding">
                <div class="well" style="padding: 5px">
                    <div class="row">
                        <div class="form-group no-margin col-sm-4">
                            <label for="anio" class="control-label col-sm-2">Año: </label>
                            <?php $currentYear = date('Y'); ?>
                            <div class="col-sm-10">
                                <select id="anio" name="anio" class="form-control input-sm">
                                    @while($currentYear >= '2015')
                                        <option value="{{$currentYear}}">{{$currentYear}}</option>
                                        <?php $currentYear--;?>
                                    @endwhile
                                </select>
                            </div>
                        </div>

                        <div class="form-group no-margin  col-sm-4">
                            <label for="mes" class="control-label col-sm-2">Mes: </label>
                            <div class="col-sm-10">
                                <select id="mes" name="mes" class="form-control input-sm">
                                    <?php $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];?>
                                    @foreach($meses as $index => $mes)
                                        <option value="{{$index+1}}">{{$mes}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-default pull-right">
                                <i class="fa fa-file-pdf-o"></i> Imprimir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop