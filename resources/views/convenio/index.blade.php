@extends('layouts.template')
@section('title')
    Programas
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Programas
@stop
@section('menu_page')
    <h1>Gestión de programas </h1>
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
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-add btn-primary pull-right margin-bottom" data-url="{{route('adm.convenio.create')}}" >
                            <i class="fa fa-plus"></i> Agregar programas
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="convenios-table" class="table table-bordered table-hover" data-url="{{route('adm.convenio.list')}}">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>A nivel nacional</th>
                                <th>Fecha de alta</th>
                                <th>Fecha ult. modf.</th>
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
                    <h4 class="modal-title">Programa</h4>
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
    <link rel="stylesheet" href="{{asset('template/plugins/select2/select2.min.css')}}">
    <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/moment.min.js')}}"></script>
    <script src="{{asset('template/plugins/bootstrap-duallist/jquery.bootstrap-duallistbox.js')}}"></script>
    <script src="{{asset('template/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('template/plugins/select2/i18n/es.js')}}"></script>
    <script src="{{asset('js/convenio/index.js')}}"></script>

@stop