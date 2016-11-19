
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
    <h1>Cuadernos</h1>
@stop
@section('breadcrumb')
    <ol class="breadcrumb">

    </ol>
@stop

@section('content')

    <style>
        .badgebox{
            opacity: 0;
        }
        .badgebox + .badge{
            text-indent: -999999px;
            width: 27px;
        }
        .badgebox:focus + .badge{
            box-shadow: inset 0px 0px 5px;
        }
        .badgebox:checked + .badge{
            text-indent: 0;
        }
    </style>

    <section class="content">
        <div class="box box-primary box-solid">
            {!! Form::open(['route'=>'cuaderno.setData']) !!}
            <div class="box-body">
                <div class="row margin-bottom">
                    <div class="col-md-6">
                        {!! Form::select('cua_id',\Sicere\Models\LibCuaderno::all()->pluck('cua_nombre','cua_id'),null,['class'=>'form-control','id'=>'cua_id','data-url'=>route('cuaderno.getData')  ]) !!}
                    </div>
                    <div class="col-md-6">
                        <div id="reportrange" class="pull-right margin-right-5" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                            <input type="hidden" name="fec_ini" id="fec_ini">
                            <input type="hidden" name="fec_fin" id="fec_fin">
                            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                            <span></span> <b class="caret"></b>
                        </div>
                    </div>
                </div>
                <label for="check-control" class="btn btn-primary" id="check-label" style="margin-bottom: 3px">
                    <span class="text">Todo</span>
                    <input type="checkbox" id="check-control" class="badgebox">
                    <span class="badge">&check;</span>
                </label>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid box-primary">
                            <div class="box-body" id="check-list">
                                Cargando...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button class="btn btn-primary pull-right" type="submit">
                    <i class="fa fa-save"></i> Guardar
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
                getData();
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

            $("#cua_id").on("change",getData);
        });

        function getData(){
            var fec_ini =$('#fec_ini').val();
            var fec_fin =$('#fec_fin').val();
            var cua_id = $("#cua_id").val();
            var url = $('#cua_id').data('url');
            $.ajax({
                url:url,
                data:{ fec_ini:fec_ini,fec_fin:fec_fin,cua_id:cua_id,'_token': '{{csrf_token()}}' },
                method:'post',
                beforeSend:function(){
                    var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
                    $("#check-list").closest(".box").append($over);
                },
                success:function (data) {
                    $("#check-list").html(data);
                },
                complete:function(){
                    $('#check-list').closest('.box').find('.overlay').remove();
                }
            });
        }

        $("#check-control").on('click',function(){
            if($(this).prop('checked')){
                $('#check-list').find('input[type=checkbox]').prop('checked',true);
                $('#check-label').find("span.text").text('Ninguno');
            }else{
                $('#check-list').find('input[type=checkbox]').prop('checked',false);
                $('#check-label').find("span.text").text('Todo');
            }

        });
    </script>
@stop