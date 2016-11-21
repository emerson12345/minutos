@extends('layouts.template')
@section('title')
    Pacientes
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Pacientes
@stop
@section('menu_page')
    <h1>Pacientes <small>lista</small></h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{route('adm.paciente.index')}}">Roles</a>
        </li>
    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-add btn-primary pull-right margin-bottom" data-url="{{route('adm.paciente.create')}}" disabled>
                            <i class="fa fa-plus"></i> Agregar paciente
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="pacientes-table" class="table table-bordered table-hover" data-url="{{route('adm.paciente.list')}}">
                            <thead>
                            <tr>
                                <th>No. HC</th>
                                <th>CI</th>
                                <th>1er. Apellido</th>
                                <th>2do. Apellido</th>
                                <th>Nombres</th>
                                <th>Sexo</th>
                                <th>Disc.</th>
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
                    <h4 class="modal-title">Paciente</h4>
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

    <div id="modal-group" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Grupo familiar</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary box-solid">
                        <div class="box-body">
                            Cargando...
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('script')
    <link rel="stylesheet" href="{{asset('template/plugins/datepicker/datepicker3.css')}}">
    <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/moment.min.js')}}"></script>
    <script src="{{asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('template/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
    <script src="{{asset('js/paciente/index.js')}}"></script>
@stop