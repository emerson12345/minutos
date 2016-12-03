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
    <h1>Agenda <small>Sesiones por grupo etario</small></h1>
@stop

@section('content')
    <section class="content">
        <div class="box box-primary box-solid" id="conte-knt-agenda">
            {!! Form::open(['class'=>'form-horizontal','target'=>'_blank']) !!}
            <div class="box-body no-padding">
                <div class="well" style="padding: 5px">
                    <div class="row">
                        <div class="form-group no-margin col-sm-4">
                            <label for="anio" class="control-label col-sm-2">Año: </label>
                            <?php $currentYear = date('Y'); ?>
                            <div class="col-sm-10">
                                <select id="anio" name="anio" class="form-control input-sm">
                                    @while($currentYear >= '2015')
                                        <option value="{{$currentYear}}">{{$currentYear}}</option>
                                        <?php $currentYear--;?>
                                    @endwhile
                                </select>
                            </div>
                        </div>

                        <div class="form-group no-margin  col-sm-4">
                            <label for="mes" class="control-label col-sm-2">Mes: </label>
                            <div class="col-sm-10">
                                <select id="mes" name="mes" class="form-control input-sm">
                                    <?php $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];?>
                                    @foreach($meses as $index => $mes)
                                        <option value="{{$index+1}}">{{$mes}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group no-margin col-sm-4">
                            <?php
                            $user_list = [];
                            if(session()->has('institucion')){
                                $institucion = \Sicere\Models\Institucion::find(session('institucion')->inst_id);
                                $user_list= $institucion->usuarios()->pluck('user_nombre','usuario.user_id');
                                $user_list->prepend('Todos',0);
                            }
                            ?>
                            <label for="user_id" class="control-label col-sm-2">Usuario: </label>
                            <div class="col-sm-10">
                                {!! Form::select('user_id',$user_list,0,['class'=>'form-control input-sm','id'=>'user_id']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="cuadernos" class="well-sm" data-url="{{route('reporte.agenda.cuadernos')}}" data-token="{{csrf_token()}}">
                    hola mundo
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-default pull-right">
                    <i class="fa fa-file-pdf-o"></i> Imprimir
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@stop

@section('script')
    <script>
        $(document).ready(getCuadernos);
        $("#user_id").on('change',getCuadernos);
        function getCuadernos(){
            var url = $("#cuadernos").data("url");
            var user_id = $("#user_id").val();
            var token = $("#cuadernos").data("token");
            $.ajax({
                url:url,
                data:{user_id:user_id,_token:token},
                method:'post',
                success:function(data){
                    $("#cuadernos").html(data);
                    eventHandlers();
                },
                beforeSend:function () {
                    var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
                    $("#cuadernos").closest(".box").append($over);
                },
                complete:function () {
                    $("#cuadernos").closest(".box").find(".overlay").remove();
                }
            });
        }

        function eventHandlers(){
            $("#btn-check").on("click",function(){
                $(".cua_check").prop("checked",true);
            });
            $("#btn-uncheck").on("click",function(){
                $(".cua_check").prop("checked",false);
            });
        }
    </script>
@stop