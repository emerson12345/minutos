@extends('layouts.template')
@section('title')
    Instituciones
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()}}
    @endif
@stop
@section('title_page')
    Lista de instituciones
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
        <a href="{{route('intitucion.create')}}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Nueva institucion
        </a>

        <div class="box box-primary box-solid">
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Seleccionable</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listInstitucion as $institucion)
                        <tr>
                            <td>{{$institucion->inst_codigo}}</td>
                            <td>{{$institucion->inst_nombre}}</td>
                            <td>{{$institucion->inst_telf1}}</td>
                            <td>{{$institucion->inst_seleccionable}}</td>
                            <td>
                            Bla
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$listInstitucion->links()}}
            </div>
        </div>
    </section>
@stop
