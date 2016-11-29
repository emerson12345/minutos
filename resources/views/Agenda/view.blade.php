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
            <div class="box-body no-padding">
                <div class="row" style="margin: 5px;">
                    <div class="col-md-4">
                        <?php
                        $user_list = \Sicere\User::all()->pluck('user_nombre','user_id')
                        ?>
                        {!! Form::select('user_id',$user_list,null,['class'=>'form-control input-sm','id'=>'user_id']) !!}
                    </div>
                </div>

                <div id="calendar"></div>
            </div>
        </div>
    </section>
@stop


@section('script')
    <link rel='stylesheet' href="{{asset('template/plugins/fullcalendar/fullcalendar.css')}}"/>
    <script src="{{asset('template/plugins/fullcalendar/lib/moment.min.js')}}"></script>
    <script src="{{asset('template/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{asset('template/plugins/fullcalendar/locale/es.js')}}"></script>
    <script>
        $("#calendar").fullCalendar({
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
