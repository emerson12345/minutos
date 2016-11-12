@extends('layouts.template')
@section('title')
    Pagina principal
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Pagina principal
@stop
@section('menu_page')
    <h1>Home</h1>
@stop
@section('breadcrumb')

@stop

@section('content')

@stop


@section('script')

@stop
