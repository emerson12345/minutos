@extends('layouts.template')
@section('title')
    Roles
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()}}
    @endif
@stop
@section('title_page')
    Roles
@stop
@section('menu_page')
    <h4>Lista de roles</h4>
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
        <a href="{{route('rol.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Nuevo rol
        </a>

        <div class="box box-primary box-solid">
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Seleccionable</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listRoles as $rol)
                        <tr>
                            <td>{{$rol->rol_codigo}}</td>
                            <td>{{$rol->rol_nombre}}</td>
                            <td>{{$rol->rol_seleccionable}}</td>
                            <td>{{$rol->rol_fec_alta}}</td>
                            <td>
                                <a href="{{route('rol.edit',$rol->rol_id)}}" class="btn btn-primary btn-xs">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$listRoles->links()}}
            </div>
        </div>
    </section>
@stop
