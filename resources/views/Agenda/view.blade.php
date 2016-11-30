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
    Agenda
@stop
@section('menu_page')
    <h1>Agenda</h1>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body no-padding">
                {!! Form::open(['target'=>'_blank','id'=>'form-agenda']) !!}
                <div class="row" style="margin: 5px;">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-default btn-sm">
                            <i class="fa fa-file-pdf-o"></i>
                            Imprimir
                        </button>
                    </div>
                    <div class="col-md-3 col-md-offset-4">
                        <div class="input-group">
                            <?php
                            $institucion = \Sicere\Models\Institucion::find(session('institucion')->inst_id);
                            $user_list = $institucion->usuarios()->pluck('usuario.user_nombre','usuario.user_id');
                            ?>
                            <div class="input-group-addon">
                                <strong>Usuario:</strong>
                            </div>
                            {!! Form::select('user_id',$user_list,null,['class'=>'form-control input-sm','id'=>'user_id']) !!}
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
                <div id="calendar"></div>
            </div>
        </div>
    </section>
@stop


@section('script')
    <link rel='stylesheet' href="{{asset('template/plugins/fullcalendar/fullcalendar.css')}}"/>
    <link rel='stylesheet' href="{{asset('template/plugins/daterangepicker/daterangepicker.css')}}"/>
    <script src="{{asset('template/plugins/fullcalendar/lib/moment.min.js')}}"></script>
    <script src="{{asset('template/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{asset('template/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('template/plugins/fullcalendar/locale/es.js')}}"></script>
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
        $("#calendar").fullCalendar({
            slotDuration:'00:15:00',
            allDaySlot:false,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            buttonText: {
                today: 'hoy',
                month: 'mes',
                week: 'semana',
                day: 'dia'
            },
            viewRender:function(){
                getEvents();
            }
        });

        $("#user_id").on('change',getEvents);

        function getEvents(){
            var moment = $("#calendar").fullCalendar('getDate');
            var fec_ini =moment.startOf('month').format();
            var fec_fin =moment.endOf('month').format();
            var user_id = $("#user_id").val();
            $.ajax({
                url:"{{route('agenda.events')}}",
                method:'post',
                data:{user_id:user_id, fec_ini:fec_ini, fec_fin:fec_fin,_token:"{{csrf_token()}}" },
                beforeSend:function () {
                    var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
                    $("#calendar").closest(".box").append($over);
                },
                success:function (data) {
                    $("#calendar").fullCalendar('removeEvents');
                    $("#calendar").fullCalendar( 'addEventSource', data );
                },
                complete:function () {
                    $("#calendar").closest(".box").find(".overlay").remove();
                }
            });
        }
    </script>
@stop
