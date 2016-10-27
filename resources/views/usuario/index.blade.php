@extends('layouts.template')
@section('title')
    Usuarios
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()}}
    @endif
@stop
@section('title_page')
    Lista de usuarios
@stop
@section('menu_page')
    <h4><a href="nuevo.html">Nuevo</a></h4>
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
        <a href="{{route('usuario.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Nuevo usuario
        </a>

        <div class="box box-primary box-solid">
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Seleccionable</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listUsuarios as $usuario)
                        <tr>
                            <td>{{$usuario->user_codigo}}</td>
                            <td>{{$usuario->user_nombre}}</td>
                            <td>{{$usuario->user_email}}</td>
                            <td>{{$usuario->user_seleccionable}}</td>
                            <td>
                                <a href="{{route('usuario.edit',[$usuario->user_id])}}" class="btn btn-primary btn-xs">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$listUsuarios->links()}}
            </div>
        </div>
    </section>
@stop
