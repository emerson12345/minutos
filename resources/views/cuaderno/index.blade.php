@extends('layouts.template')
@section('title')
    Cuadernos
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Lista de cuadernos
@stop
@section('menu_page')
    <h1>Cuadernos <small>lista</small></h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{route('adm.cuaderno.index')}}">Usuarios</a>
        </li>
    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('adm.cuaderno.create')}}" class="btn btn-add btn-primary pull-right margin-bottom">
                            <i class="fa fa-plus"></i> Agregar cuaderno
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover" id="cuadernos-table" data-url="{{route('adm.cuaderno.list')}}">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha alta</th>
                                <th>Fecha mod.</th>
                                <th>Estado</th>
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
                    <h4 class="modal-title">Nuevo cuaderno</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary box-solid">
                        <div class="box-body">
                            The body of the box
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
    <script src="{{asset('js/cuaderno/index.js')}}"></script>
@stop
