@extends('layouts.template')
@section('title')
    Agenda
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Crear
@stop
@section('menu_page')
    <h1>Agenda medica</h1>
@stop
@section('breadcrumb')

@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-primary box-solid">
                    <div class="box-body">
                        <button type="button" class="btn btn-primary btn-block" id="new-cita" data-url="{{route('agenda.create')}}">
                            <i class="fa fa-calendar"></i>
                            Agendar
                        </button>
                        <div id="select-date"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="modal-agenda" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agendar citas</h4>
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
    <link rel="stylesheet" href="{{asset('template/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/datetimepicker/bootstrap-datetimepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/touchspin/jquery.bootstrap-touchspin.min.css')}}">
    <link rel="stylesheet" href="{{asset('template/plugins/select2/select2.min.css')}}">
    <script src="{{asset('template/plugins/touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
    <script src="{{asset('template/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('template/plugins/select2/i18n/es.js')}}"></script>
    <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/moment.min.js')}}"></script>
    <script src="{{asset('template/plugins/datetimepicker/moment-locale.js')}}"></script>
    <script src="{{asset('template/plugins/datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('template/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('template/plugins/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
    <script src="{{asset('js/agenda/index.js')}}"></script>
@stop
