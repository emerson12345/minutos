@extends('layouts.template')
@section('title')
    Reporte
@stop
@section('user')
    @if(Auth::check())
        {{Auth::user()->user_nombre}}
    @endif
@stop
@section('title_page')
    Produccion
@stop
@section('menu_page')
    <h1>Reporte</h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">

    </ol>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            {!! Form::open(['class'=>'form-horizontal', 'target'=>'_blank']) !!}
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('inst_id', 'ESTABLECIMIENTO', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::select('rep_institucion',\Sicere\Models\Institucion::all()->pluck('inst_nombre','inst_id'),null,['class'=>'form-control']) !!}
                                <span class="label label-warning"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('fechas', 'FECHAS', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                                <div id="reportrange" class="pull-right margin-right-5" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                                    <input type="hidden" name="rep_fec_ini" id="fec_ini">
                                    <input type="hidden" name="rep_fec_fin" id="fec_fin">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="check-list">
                    {!! Form::label('cuadernos','CUADERNOS',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        <input type="checkbox" id="cuadernos-check">
                        <label for="cuadernos-check" id="cuadernos-label">Todos</label>
                        <hr>
                        @foreach(\Sicere\Models\LibCuaderno::where('cua_seleccionable',1)->get() as $i=>$cuaderno)
                            <input type="checkbox" id="cuaderno_{{$i}}" name="cuaderno[{{$i}}]" value="{{$cuaderno->cua_id}}">
                            <label for="cuaderno_{{$i}}">{{$cuaderno->cua_nombre}}</label>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-default pull-right" type="submit">
                    <i class="fa fa-file-pdf-o"></i> PDF
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop

@section('script')
    <link rel="stylesheet" href="{{asset('template/plugins/bootstrap-daterangepicker/css/daterangepicker.css')}}">
    <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/moment.min.js')}}"></script>
    <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/daterangepicker.js')}}"></script>
    <script>
        $(function() {
            var start = moment();
            var end = moment();
            function cb(start, end) {
                $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                $('#fec_ini').val(start.format('DD/MM/YYYY'));
                $('#fec_fin').val(end.format('DD/MM/YYYY'));
            }
            $('#reportrange').daterangepicker({
                locale:{'format':'DD/MM/YYYY','customRangeLabel':'Personalizado'},
                startDate: start,
                endDate: end,
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'El mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);
            cb(start, end);

        });
        $("#cuadernos-check").on('click',function(){
            if($(this).prop('checked')){
                $('#check-list').find('input[type=checkbox]').prop('checked',true);
                $('#cuadernos-label').text('Ninguno');
            }else{
                $('#check-list').find('input[type=checkbox]').prop('checked',false);
                $('#cuadernos-label').text('Todos');
            }

        });
    </script>
@stop

