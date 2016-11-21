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
    Crear/Editar
@stop
@section('menu_page')

@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="{{route('adm.paciente.index')}}">Roles</a>
        </li>
    </ol>
@stop

@section('content')
    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }

    </style>

    <section class="content">
        <div class="box box-primary box-solid">
            <div class="box-body">
                <div id='calendar'></div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <link rel='stylesheet' href="{{asset('template/plugins/fullcalendar/fullcalendar.css')}}"/>
    <link rel='stylesheet' media='print' href="{{asset('template/plugins/fullcalendar/fullcalendar.print.css')}}" />
    <script src="{{asset('template/plugins/fullcalendar/lib/moment.min.js')}}"></script>
    <script src="{{asset('template/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
    <script src="{{asset('template/plugins/fullcalendar/locale/es.js')}}"></script>
    <script>

        $(document).ready(function() {

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                defaultDate: '2016-09-12',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                    {
                        title: 'All Day Event',
                        start: '2016-09-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2016-09-07',
                        end: '2016-09-10'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2016-09-09T16:00:00'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2016-09-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2016-09-11',
                        end: '2016-09-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2016-09-12T10:30:00',
                        end: '2016-09-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2016-09-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2016-09-12T14:30:00'
                    },
                    {
                        title: 'Happy Hour',
                        start: '2016-09-12T17:30:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2016-09-12T20:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2016-09-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2016-09-28'
                    }
                ]
            });

        });
    </script>


@stop