@extends('layouts.template')
@section('title')
    Usuarios
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Lista de usuarios
@stop
@section('menu_page')
    <h1>Usuarios <small>lista</small></h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{route('adm.usuario.index')}}">Usuarios</a>
        </li>
    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('adm.usuario.report')}}" class="btn btn-default"><i class="fa fa-file-pdf-o"></i> PDF</a>
                        <button type="button" class="btn btn-add btn-primary pull-right margin-bottom" data-url="{{route('adm.usuario.create')}}">
                            <i class="fa fa-plus"></i> Agregar usuario
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="users-table" data-url="{{route('adm.usuario.list')}}">
                            <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Alta</th>
                                <th>Edi</th>
                                <th>Vigente</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nuevo usuario</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary box-solid">
                        <div class="box-body">
                            Cargando...
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                    <button type="button" id="btn-save" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop


@section('script')
    <link rel="stylesheet" href="{{asset('template/plugins/bootstrap-duallist/bootstrap-duallistbox.css')}}">
    <script src="{{asset('template/plugins/bootstrap-duallist/jquery.bootstrap-duallistbox.js')}}"></script>
    <script src="{{asset('js/usuario/index.js')}}"></script>
@stop
