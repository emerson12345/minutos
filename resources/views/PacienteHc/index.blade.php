@extends('layouts.template')
@section('title')
    Historial Clinico
@stop
@section('user')
@stop
@section('title_page')
    Cuadernos
@stop
@section('breadcrumb')
    <ol class="breadcrumb">
        <li>
            <a href="#"><i class="fa fa-dashboard"></i>Inicio</a>
        </li>
        <li class="active">
            <a href="#">Cuadernos</a>
        </li>
    </ol>
@stop
@section('content')
    {!! Form::open(['route' => 'libregistro.edit' ,'class'=>'form-horizontal']) !!}
    <style>
        thead, tbody { display: block; }
        tbody {
            height: 150px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .tr-cuadernos:hover
        {
            background-color: #1abc9c;
            cursor: pointer;
        }
        .tr-dimencion{
            width: 200px;
        }
        .td-dimencion{
            width: 200px;
        }
        .tr-seleccionable{
            background-color: #e74c3c;
        }
        .tr-seleccionable-hc{
            background-color: #e67e22;
        }
    </style>
    <!------------------------------------------------>

    <!------------------------------------------------>

    <!----- PERSONAL SEARCH MODAL -->
    <div id="myModal_personal_search" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">PERSONAL</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-10">
                        <div class="box">
                            <div class="box-body" >

                                <table id="table_personal_search" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="tr-dimencion">
                                            CODIGO
                                        </th>
                                        <th class="tr-dimencion">
                                            NOMBRE
                                        </th>
                                        <th class="tr-dimencion">
                                            INSTITUCIÓN
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($listPersonalSearch as $value) {
                                    ?>
                                    <tr role="row">
                                        <td class="tr-cuadernos tr-dimencion"
                                            id="<?= $value->rrhh_id; ?>-<?= $value->rrhh_nombre; ?>"
                                                >
                                            <?= $value->rrhh_id; ?>
                                        </td>
                                        <td class="tr-cuadernos tr-dimencion"
                                            id="<?= $value->rrhh_id; ?>-<?= $value->rrhh_nombre; ?>">
                                            <?= $value->rrhh_nombre; ?><?= " "; ?><?= $value->rrhh_ap_prim; ?><?= " "; ?><?= $value->rrhh_ap_seg; ?>
                                        </td>
                                        <td class="tr-cuadernos tr-dimencion"
                                            id="<?= $value->rrhh_id; ?>-<?= $value->rrhh_nombre; ?>">
                                            <?= $value->inst_nombre; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
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
    <!--- END PERSONAL MODAL SEARCH -->

        <div class="col-xs-5">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-9">

                        </div>
                        <div class="col-md-3">
                            <input type="button" value="Buscar" class="btn btn-success" name="btn-paciente-search-general" id="btn-paciente-search-general">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <!--- Fecha -->
                            {!! Form::label('fechas', 'FECHAS') !!}
                            <div id="reportrange" class="pull-right margin-right-5" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; ">
                                <input type="hidden" name="rep_fec_ini" id="fec_ini">
                                <input type="hidden" name="rep_fec_fin" id="fec_fin">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                <span></span> <b class="caret"></b>
                            </div>
                            <!--- End Fecha -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            {!! Form::label('tb_libro_atencion', 'LIBRO DE ATENCIÓN') !!}
                            {!! Form::select('tb_listCuadernos_search', $listCuadernosSearch,null,array('id'=>'tb_listCuadernos_search')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <!--- Personal search -->
                            {!! Form::label('tb_personal_atencion', 'PERSONAL') !!}
                            <input type="text" name="tb_personal_atencion_id" id="tb_personal_atencion_id" style="visibility:hidden">
                            <input type="text" name="tb_personal_atencion" id="tb_personal_atencion">
                            <input type="button" name="btn_personal_search" id="btn_personal_search" value="...">

                            <!--- End Personal search -->
                        </div>
                    </div>
                    <!--- Libro de atención -->
                    <!--- End Libro de atención -->

                </div>
            </div>
            <?= $listPacientes ?>
            <div id="PacienteHc">
            </div>
        </div>
        <div id="datos-paciente" class="col-md-5">

        </div>
        <div id="AtenccionHc" class="col-md-7">
        </div>

{!! Form::close() !!}

@stop
@section('script')
    <link rel="stylesheet" href="{{asset('template/plugins/bootstrap-daterangepicker/css/daterangepicker.css')}}">
    <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/moment.min.js')}}"></script>
    <script src="{{asset('template/plugins/bootstrap-daterangepicker/js/daterangepicker.js')}}"></script>
    <script>
        //PacienteHc/historial_clinico/
        var url_data_hc='{{$url_paciente}}';
        var fila_seleccinable_pacientes;

        $(function (){
            $("#t_pacientes").DataTable();
            $("#table_personal_search").DataTable();

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
        var t_pacientes_id_search=false;
        $("#t_pacientes").on('click', 'td', function(e) {
            t_pacientes_id_search=e.toElement.id;
            $("#AtenccionHc").html("");
                if (typeof fila_seleccinable_pacientes == 'undefined') {
                    $(this).parent().addClass("tr-seleccionable");
                    fila_seleccinable_pacientes=$(this);
                }
                else
                {
                    fila_seleccinable_pacientes.parent().removeClass("tr-seleccionable");
                    $(this).parent().addClass("tr-seleccionable");
                    fila_seleccinable_pacientes=$(this);
                }
            $.ajax({
                beforeSend: function()
                {
                    console.log($("#PacienteHc").html("cargando..."));
                },
                url:url_data_hc+"/"+e.toElement.id,
                type:"GET",
                data:{nom:"xc"},
                success: function(info){
                    //console.log(info);
                    $("#PacienteHc").html(info);
                    //console.log($("#PacienteHc").html(info));
                },
                error:function(jqXHR,estado,error){
                    console.log("errorrr2");
                }
            });
        });
        $("#btn_personal_search").on('click',function(e){
            $('#myModal_personal_search').modal('show');
        });
        var fila_personal_search;
        $("#table_personal_search").on('click','td',function(e){
            if (typeof fila_personal_search == 'undefined') {
                $(this).addClass("tr-seleccionable");
                fila_personal_search=$(this);
            }
            else
            {
                fila_personal_search.removeClass("tr-seleccionable");
                $(this).addClass("tr-seleccionable");
                fila_personal_search=$(this);

            }
            arr=e.toElement.id.split("-");
            intIdPer=arr[0];
            strNombrePer=arr[1];
            $('#tb_personal_atencion').val(strNombrePer);
            $('#tb_personal_atencion_id').val(intIdPer);
            $('#myModal_personal_search').modal('hide');
        });
        tb_listCuadernos_search="";
        tb_personal_atencion_id="";
        $("#btn-paciente-search-general").on('click',function(e){

            rep_fec_ini=$("#fec_ini").val();
            rep_fec_ini=rep_fec_ini.split("/").join("-");
            rep_fec_fin=$("#fec_fin").val();
            rep_fec_fin=rep_fec_fin.split("/").join("-");

            tb_listCuadernos_search=$("#tb_listCuadernos_search").val();
            if($("#tb_personal_atencion_id").val()=="")
                tb_personal_atencion_id=false;
            else
                tb_personal_atencion_id=$("#tb_personal_atencion_id").val();
            if(t_pacientes_id_search==false)
            {
                alert("Registre una persona");
            }
            else{
                //$fecha_inicio,$fecha_fin,$cua_id,$rrhh_id,$pac_id
                //alert(rep_fec_ini+" "+rep_fec_fin+" "+tb_listCuadernos_search+" "+t_pacientes_id_search);
                url_buscar_Hc='{{$url_buscar_Hc}}';
                $.ajax({
                    beforeSend: function()
                    {
                        console.log($("#PacienteHc").html("cargando..."));
                    },
                    url:url_buscar_Hc+"/"+rep_fec_ini+"/"+rep_fec_fin+"/"+tb_listCuadernos_search+"/"+tb_personal_atencion_id+"/"+t_pacientes_id_search,
                    type:"GET",
                    data:{nom:"xc"},
                    success: function(info){
                        //console.log(info);
                        $("#PacienteHc").html(info);
                        //console.log($("#PacienteHc").html(info));
                    },
                    error:function(jqXHR,estado,error){
                        console.log("errorrr2");
                    }
                });
            }

        });
    </script>
@stop