@extends('layouts.template')
@section('title')
    Roles
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Roles
@stop
@section('menu_page')
    <h1>Roles <small>lista</small></h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{route('adm.rol.index')}}">Roles</a>
        </li>
    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <img src="{{asset('template/dist/img/slogan.png')}}" alt="" class="img img-rounded img-responsive">
            </div>
        </div>
    </section>
@stop