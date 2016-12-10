@extends('layouts.template')
@section('title')
    Configuración
@stop
@section('user')

@stop
@section('title_page')
    Configuración
@stop
@section('menu_page')
    <h1>Parámetros de configuración</h1>
@stop
@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('parametro.setup')}}" class="btn btn-primary" ><i class="fa fa-circle-o"></i> Parámetros de sistema</a>
                        <a href="{{route('cuaderno.estado')}}" class="btn btn-primary" ><i class="fa fa-book"></i> Estado de cuadernos</a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Usuario</h4>
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

@stop
