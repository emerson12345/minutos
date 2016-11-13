
@extends('layouts.template')
@section('title')
    Cuadernos
@stop
@section('user')
    Manuel
@stop
@section('title_page')
    Cuadernos
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>Inicio</a>
        </li>
        <li class="active">
            <a href="#">Cuadernos</a>
        </li>
    </ol>
@stop
@section('content')
    <div class="col-md-3"></div>
    <div class="col-md-7">
        <div class="box-body">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> </h4>
                 Datos insertados correctamente
                <a href="<?php echo $url_data; ?>">Regresar</a>
            </div>
        </div>
    </div>
@stop
@section('script')
@stop