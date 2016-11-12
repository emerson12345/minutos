@extends('layouts.template')
@section('title')
    401
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @else
        No autenticado
    @endif
@stop
@section('menu_page')
    <h1>Acceso no autorizado</h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">
            <i class="fa fa-warning"></i> 401
        </li>
    </ol>
@stop

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow">401</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Acceso no autorizado.</h3>
            <p>Usted no esta autorizado para realizar esta accion.</p>
            <p>Por favor contacte con el administrador.</p>
        </div>
    </div>
@stop