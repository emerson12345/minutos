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
    Agenda de citas
@stop
@section('menu_page')
    <h1> Agenda de citas</h1>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid" id="content-agenda">
            <div class="box-body">
                {!! Form::open(['target'=>'_blank','id'=>'form-agenda']) !!}
                <div class="row" style="margin: 5px;">
                    <div class="col-md-3 col-md-offset-6">
                        <div class="input-group">
                            <?php
                            $cua_list = Auth::user()->cuadernos()->pluck('lib_cuadernos.cua_nombre','lib_cuadernos.cua_id');
                            ?>
                            <div class="input-group-addon">
                                <strong>Servicio:</strong>
                            </div>
                            {!! Form::select('cua_id',$cua_list,null,['class'=>'form-control input-sm','id'=>'cua_id']) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div id="reportrange" class="pull-right margin-right-5" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                            <input type="hidden" name="fec_ini" id="fec_ini">
                            <input type="hidden" name="fec_fin" id="fec_fin">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span></span> <b class="caret"></b>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div id="content"></div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <link rel='stylesheet' href="{{asset('template/plugins/bootstrap-daterangepicker/css/daterangepicker.css')}}"/>
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
                getEvents();
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

        $(document).ready(function(){
            getEvents();
        });

        $("#cua_id").on('change',getEvents);

        function getEvents(){
            var fec_ini = $("#fec_ini").val();
            var fec_fin = $("#fec_fin").val();
            var cua_id = $("#cua_id").val();
            $.ajax({
                url:"{{route('agenda.agenda.get')}}",
                method:'post',
                data:{cua_id:cua_id,fec_ini:fec_ini, fec_fin:fec_fin,_token:"{{csrf_token()}}" },
                beforeSend:function () {
                    var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
                    $("#content-agenda").append($over);
                },
                success:function (data) {
                    $("#content-agenda").find("#content").html(data);
                    $(".btn-change-state").off().on('click',function(){
                        var id = $(this).data('id');
                        var url = $(this).data('url');
                        var state = $(this).data('state');
                        var messageState = 'CANCELADO';
                        if(state == 'N')
                            messageState = 'NO ATENDIDO';
                        var confirmar=confirm("¿Está seguro de marcar esta cita como '"+messageState+"'?");
                        if(confirmar == true){
                            $.ajax({
                                url:url,
                                data:{agenda_id:id,agenda_estado:state,_token:"{{csrf_token()}}"},
                                method:'post',
                                complete:getEvents
                            });
                        }
                    });
                },
                complete:function () {
                    $("#content-agenda").find(".overlay").remove();
                }
            });
        }
    </script>
@stop
