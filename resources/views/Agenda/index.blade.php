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

    <!----- INSTITUCIONES -->
    <div id="myModal_instituciones_r" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Cuadernos</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-10">
                        <div class="box">
                            <div class="box-body" >
                                jdsfklajklds
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!--- END INSTITUCIONES -->

@stop

@section('content')
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-5">
                </div>
                <div class="col-md-4">
                    <!--- Fecha -->
                    {!! Form::label('fechas', 'FECHAS') !!}
                    <div id="reportrange" class="pull-right margin-right-5" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                        <input type="hidden" name="rep_fec_ini" id="fec_ini">
                        <input type="hidden" name="rep_fec_fin" id="fec_fin">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                        <span></span> <b class="caret"></b>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="button" value="Imprimir Agenda semanal" id="btn_imprimir_agenda" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
        <div class="panel panel-default">
            <!-- Content Header (Page header) -->
            <div class="panel-heading"><h2> Calendario   </h2>  </div>
            <div class="panel-body">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <!-- the events -->
                                    <div id="external-events">

                                        <button type="button" class="btn btn-primary btn-block" id="new-cita" data-url="{{route('agenda.create')}}">
                                            <i class="fa fa-calendar"></i>
                                            Agendar
                                        </button>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /. box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="box box-primary">
                                <div class="box-body no-padding">
                                    <!-- THE CALENDAR -->
                                    <div id="calendar"></div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /. box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                </section>
                <!-- /.content -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->

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
            <link rel='stylesheet' href="{{asset('template/plugins/fullcalendar/fullcalendar.css')}}"/>
            <link rel='stylesheet' media='print' href="{{asset('template/plugins/fullcalendar/fullcalendar.print.css')}}" />
            <script src="{{asset('template/plugins/fullcalendar/lib/moment.min.js')}}"></script>
            <script src="{{asset('template/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
            <script src="{{asset('template/plugins/fullcalendar/locale/es.js')}}"></script>

            <script src="{{asset('template/plugins/fullcalendar/lib/jquery-ui.min.js')}}"></script>


            <link rel="stylesheet" href="{{asset('template/plugins/bootstrap-daterangepicker/css/daterangepicker.css')}}">
            <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/moment.min.js')}}"></script>
            <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/daterangepicker.js')}}"></script>


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

            <script>
                $(function () {
                    //////////////////////////////////////////////////////////////////////////////////////////////////////
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
                    //////////////////////////////////////////////////////////////////////////////////////////////////////
                    /* initialize the external events
                     -----------------------------------------------------------------*/
                    function ini_events(ele) {
                        ele.each(function () {
                            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                            // it doesn't need to have a start or end
                            var eventObject = {
                                title: $.trim($(this).text()) // use the element's text as the event title
                            };

                            // store the Event Object in the DOM element so we can get to it later
                            $(this).data('eventObject', eventObject);

                            // make the event draggable using jQuery UI
                            $(this).draggable({
                                zIndex: 1070,
                                revert: true, // will cause the event to go back to its
                                revertDuration: 0  //  original position after the drag
                            });

                        });
                    }

                    ini_events($('#external-events div.external-event'));

                    /* initialize the calendar
                     -----------------------------------------------------------------*/
                    //Date for the calendar events (dummy data)
                    var date = new Date();
                    var d = date.getDate(),
                            m = date.getMonth(),
                            y = date.getFullYear();
                    //while(reload==false){
                    $('#calendar').fullCalendar({
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
                        //events: { url:"cargaEventos"},
                        events: { url:"cargaEventos"},
                        editable: true,
                        droppable: true, // this allows things to be dropped onto the calendar !!!
                        drop: function (date, allDay) { // this function is called when something is dropped
                            // retrieve the dropped element's stored Event Object
                            var originalEventObject = $(this).data('eventObject');
                            // we need to copy it, so that multiple events don't have a reference to the same object
                            var copiedEventObject = $.extend({}, originalEventObject);
                            allDay=true;
                            // assign it the date that was reported
                            copiedEventObject.start = date;
                            copiedEventObject.allDay = allDay;
                            copiedEventObject.backgroundColor = $(this).css("background-color");
                            copiedEventObject.borderColor = $(this).css("border-color");

                            // render the event on the calendar
                            //$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                            // is the "remove after drop" checkbox checked?
                            if ($('#drop-remove').is(':checked')) {
                                // if so, remove the element from the "Draggable Events" list
                                $(this).remove();
                            }
                            //Guardamos el evento creado en base de datos
                            var title=copiedEventObject.title;
                            var start=copiedEventObject.start.format("YYYY-MM-DD HH:mm");
                            var back=copiedEventObject.backgroundColor;

                            crsfToken = document.getElementsByName("_token")[0].value;
                            $.ajax({
                                url: 'guardaEventos',
                                data: 'title='+ title+'&start='+ start+'&allday='+allDay+'&background='+back,
                                type: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": crsfToken
                                },
                                success: function(events) {
                                    console.log('Evento creado');
                                    $('#mensaje').html(events);
                                    $('#calendar').fullCalendar('refetchEvents' );
                                },
                                error: function(json){
                                    $('#mensaje').html(json);
                                    console.log($('#mensaje').val());
                                    console.log("Error al crear evento");
                                }
                            });
                        },
                        eventResize: function(event) {
                            var start = event.start.format("YYYY-MM-DD HH:mm");
                            var back=event.backgroundColor;
                            var allDay=event.allDay;
                            if(event.end){
                                var end = event.end.format("YYYY-MM-DD HH:mm");
                            }else{var end="NULL";
                            }
                            crsfToken = document.getElementsByName("_token")[0].value;
                            $.ajax({
                                url: 'actualizaEventos',
                                data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+'&background='+back+'&allday='+allDay,
                                type: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": crsfToken
                                },
                                success: function(json) {
                                    console.log("Updated Successfully");
                                },
                                error: function(json){
                                    console.log("Error al actualizar evento");
                                }
                            });
                        },
                        eventDrop: function(event, delta) {
                            var start = event.start.format("YYYY-MM-DD HH:mm");
                            if(event.end){
                                var end = event.end.format("YYYY-MM-DD HH:mm");
                            }else{var end="NULL";
                            }
                            var back=event.backgroundColor;
                            var allDay=event.allDay;
                            crsfToken = document.getElementsByName("_token")[0].value;

                            $.ajax({
                                url: 'actualizaEventos',
                                data: 'title='+ event.title+'&start='+ start +'&end='+ end+'&id='+ event.id+'&background='+back+'&allday='+allDay ,
                                type: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": crsfToken
                                },
                                success: function(json) {
                                    console.log("Updated Successfully eventdrop");
                                },
                                error: function(json){
                                    console.log("Error al actualizar eventdrop");
                                }
                            });
                        },
                        eventClick: function (event, jsEvent, view) {
                            //$('#myModal_instituciones_r').modal('show');

                            crsfToken = document.getElementsByName("_token")[0].value;
                            //alert(event.id);
                            window.location="http://localhost/SICEREP6/public/cuaderno/index/"+event.id;
                            //var con=confirm("Esta seguro que desea eliminar el evento");
                            //if(con){
                                /*
                                $.ajax({
                                    url: 'eliminaEvento',
                                    data: 'id=' + event.id,
                                    headers: {
                                        "X-CSRF-TOKEN": crsfToken
                                    },
                                    type: "POST",
                                    success: function () {
                                        $('#calendar').fullCalendar('removeEvents', event._id);
                                        console.log("Evento eliminado");
                                    }
                                });*/
                            //}else{
                              //  console.log("Cancelado");
                            //}
                        },
                        eventMouseover: function( event, jsEvent, view ) {
                            var start = (event.start.format("HH:mm"));
                            var back=event.backgroundColor;
                            if(event.end){
                                var end = event.end.format("HH:mm");
                            }else{var end="No definido";
                            }
                            if(event.allDay){
                                var allDay = "Si";
                            }else{var allDay="No";
                            }
                            var tooltip = '<div class="tooltipevent" style="width:200px;height:100px;color:white;background:'+back+';position:absolute;z-index:10001;">'+'<center>'+ event.title +'</center>'+'Todo el dia: '+allDay+'<br>'+ 'Inicio: '+start+'<br>'+ 'Fin: '+ end +'</div>';
                            $("body").append(tooltip);
                            $(this).mouseover(function(e) {
                                $(this).css('z-index', 10000);
                                $('.tooltipevent').fadeIn('500');
                                $('.tooltipevent').fadeTo('10', 1.9);
                            }).mousemove(function(e) {
                                $('.tooltipevent').css('top', e.pageY + 10);
                                $('.tooltipevent').css('left', e.pageX + 20);
                            });
                        },
                        eventMouseout: function(calEvent, jsEvent) {
                            $(this).css('z-index', 8);
                            $('.tooltipevent').remove();
                        },
                        dayClick: function(date, jsEvent, view) {
                            if (view.name === "month") {
                                $('#calendar').fullCalendar('gotoDate', date);
                                $('#calendar').fullCalendar('changeView', 'agendaDay');
                            }
                        }
                    });

                    /* AGREGANDO EVENTOS AL PANEL */
                    var currColor = "#3c8dbc"; //Red by default
                    //Color chooser button
                    var colorChooser = $("#color-chooser-btn");
                    $("#color-chooser > li > a").click(function (e) {
                        e.preventDefault();
                        //Save color
                        currColor = $(this).css("color");
                        //Add color effect to button
                        $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
                    });
                    $("#add-new-event").click(function (e) {
                        e.preventDefault();
                        //Get value and make sure it is not null
                        var val = $("#new-event").val();
                        if (val.length == 0) {
                            return;
                        }

                        //Create events
                        var event = $("<div />");
                        event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
                        event.html(val);
                        $('#external-events').prepend(event);

                        //Add draggable funtionality
                        ini_events(event);

                        //Remove event from text input
                        $("#new-event").val("");
                    });
                });

                $("#btn_imprimir_agenda").click(function (e) {
                    var fecha_inicio=$("#fec_ini").val();
                    window.open('reporte/'+fecha_inicio.split("/").join("-"));
                    /*
                     $.ajax({
                     $.ajax({
                     beforeSend: function()
                     {
                     console.log($("#mensaje").html("cargando..."));
                     },
                     url: 'reporte/'+fecha_inicio.split("/").join("-"),
                     type:"GET",
                     data:{nom:"xc"},
                     success: function(info){
                     //console.log(info);
                     //console.log($("#PacienteHc").html(info));
                     },
                     error:function(jqXHR,estado,error){
                     console.log("errorrr2");
                     }
                     });
                     */
                });


            </script>
        @stop