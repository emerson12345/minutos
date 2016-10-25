@extends('layouts.template')
@section('title')
    Pagina de prueba SICERE modificado
@stop
@section('user')
    Nombre de usuario
@stop
@section('title_content')
    Pagin
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>Inicio</a>
        </li>
        <li>
            <a href="#">Pagina de prueba</a>
        </li>
        <li class="active">
            <a href="#">Actializar</a>
        </li>
    </ol>
@stop
@section('content')
    {!! Form::open(['url' => 'foo/bar']) !!}
    {!! Form::text('username') !!}
    
    {!! Form::close() !!}
@stop
@section('script')
    <script>
        $(function () {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
    <script>
        $(function () {
            console.log("Mensaje desde jquery");
            });
    </script>
@stop