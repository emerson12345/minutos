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
    <h1> <small></small></h1>
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
                <img src="{{asset('template/dist/img/slogan.png')}}" alt="" class="img img-rounded img-responsive">
            </div>
        </div>
    </section>
@stop