@extends('layouts.template')
@section('title')

@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
@stop
@section('menu_page')
@stop
@section('breadcrumb')

@stop

@section('content')

                <div class="col-md-3"></div>
                <div class="col-md-7">
                    <div class="box-body">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> </h4>
                            <?php echo $mensaje; ?>
                            <BR>
                            <a href="<?php echo $urlreciboRecetario; ?>">Registrar recibo Recetario</a>
                            <BR>
                            <a href="<?php echo $urlreciboRecetario; ?>">Registrar Examen Complementario</a>
                            <BR>
                            <a href="<?php echo $url_data; ?>">Regresar</a>
                        </div>
                    </div>
                </div>
@stop