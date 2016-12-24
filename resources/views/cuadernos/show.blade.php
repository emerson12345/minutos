<?php
$fecha_de_nacimiento = "1948-05-11";
$fecha_actual = date ("Y-m-d");
//$fecha_actual = date ("2006-03-05"); //para pruebas
function EdadCompleta($fecha_de_nacimiento)
{
    $fecha_actual=date("Y-m-d");
    $array_nacimiento = explode ( "-", $fecha_de_nacimiento);
    $array_actual = explode ( "-", $fecha_actual );

    $anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
    $meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
    $dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días

    //ajuste de posible negativo en $días
    if ($dias < 0)
    {
        --$meses;

        //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
        switch ($array_actual[1]) {
            case 1:     $dias_mes_anterior=31; break;
            case 2:     $dias_mes_anterior=31; break;
            case 3:
                if (bisiesto($array_actual[0]))
                {
                    $dias_mes_anterior=29; break;
                } else {
                    $dias_mes_anterior=28; break;
                }
            case 4:     $dias_mes_anterior=31; break;
            case 5:     $dias_mes_anterior=30; break;
            case 6:     $dias_mes_anterior=31; break;
            case 7:     $dias_mes_anterior=30; break;
            case 8:     $dias_mes_anterior=31; break;
            case 9:     $dias_mes_anterior=31; break;
            case 10:     $dias_mes_anterior=30; break;
            case 11:     $dias_mes_anterior=31; break;
            case 12:     $dias_mes_anterior=30; break;
        }

        $dias=$dias + $dias_mes_anterior;
    }

    //ajuste de posible negativo en $meses
    if ($meses < 0)
    {
        --$anos;
        $meses=$meses + 12;
    }
    echo "$anos/$meses/$dias";
}
function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
    if (checkdate(2,29,$anio_actual))
    {
        $bisiesto=true;
    }
    return $bisiesto;
}
?>

@extends('layouts.template')
@section('title')
    Cuadernos
@stop
@section('user')
    Manuel
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
        .tr-seleccionable{
            background-color: #e74c3c;
        }
        .tr-dimencion{
            font-size: 11px;
            width: 250px;
        }
        .tr-dimencion-title{
            font-size: 11px;
            width: 200px;
        }
        .tr-nro{
            font-size: 11px;
            width: 60px;
        }
        .tr-nro-title{
            font-size: 11px;
            width: 25px;
        }
        .td-dimencion{
            width: 200px;
        }
        .btn_buscar{
            width: 40px;
            height: 27px;
        }
        .contenedor{
            border: 1px solid #367fa9 !important;
            border-radius: 10px;
            padding: 3px;
        }
        SELECT {
            font-size: 10px;
            font-family : verdana,arial,helvetica;
        }
        OPTION
        {
            font-size: 10px;
            font-family : verdana,arial,helvetica;
        }

    </style>

    {!! Form::open(['route' => 'libregistro.store' ,'class'=>'form-horizontal']) !!}


    <div class="col-md-4">
        <div class="box contenedor">
            <div class="box-body">
                <label for="">
                    <?php echo "Fecha: "; echo date("d/m/Y"); ?>
                </label>
            </div>
            <div class="box-body with-border">
                <label for="">Paciente:</label><br>
                <?php
                if(isset($listAgendaPacientes))
                {
                ?>
                <input type="hidden" name="pac_id" id="tb_id_paciente" size="5" value="<?php echo $listAgendaPacientes->pac_id; ?>" readonly>
                <input type="text" id="tb_nombre_paciente" size="30"  value="<?php echo $listAgendaPacientes->pac_ap_prim." ".$listAgendaPacientes->pac_ap_seg." ".$listAgendaPacientes->pac_nombre;?>" required>
                <?php
                }
                else
                {
                ?>
                <input type="hidden" name="pac_id" id="tb_id_paciente" size="5" readonly>
                <input type="text" id="tb_nombre_paciente" size="30" required>
            <?php
            }
            ?>
            <!-- <input type="button" id="btn-paciente" class="btn btn-edit btn-xs btn-primary" value="Buscar">-->

                <button type="button" id="btn-paciente" class="btn btn-edit btn-md btn-primary btn_buscar " value="Buscar">
                    <span class="glyphicon glyphicon-search"></span>
                </button>

            </div>
            <div class="box-body" >
                <label for="">Cuadernos</label>
                <?php
                if(isset($listAgendaPacientes))
                {
                ?>
                <input type="text" id="tb-cuadernos" name="tb-cuadernos" size="40" required value="<?php echo $listAgendaPacientes->cua_nombre;?>">
                <?php
                }
                else
                {
                ?>
                <input type="text" id="tb-cuadernos" name="tb-cuadernos" size="40" required>
                <?php
                }
                ?>
                <button type="button" id="btn-cuadernos" name="btn-cuadernos" class="btn btn-edit btn-md btn-primary btn_buscar" value="Buscar">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
            <div class="box-body" >
                <label for="">Referido de Establecimiento</label>
                <input type="text" id="referido_de_inst_id" name="referido_de_inst_id" size="0" value="-1"  style="visibility:hidden">
                <input type="text" id="tb_referido_de_establecimeinto" name="tb_referido_de_establecimeinto" size="40">
                <button type="button" id="btn_referido_de_establecimeinto" name="btn_referido_de_establecimeinto" class="btn btn-edit btn-md btn-primary btn_buscar" value="Buscar">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
            <div class="box-body" >
                <label for="">Referido a Establecimiento</label>
                <input type="text" id="referido_a_inst_id" name="referido_a_inst_id" size="5" value="-1"  style="visibility:hidden">
                <input type="text" id="tb_referido_a_establecimeinto" name="tb_referido_a_establecimeinto" size="40">

                <button type="button" id="btn_referido_a_establecimeinto" name="btn_referido_a_establecimeinto" class="btn btn-edit btn-md btn-primary btn_buscar" value="Buscar">
                    <span class="glyphicon glyphicon-search"></span>
                </button>

            </div>
        </div>
        <button type="button" id="btn-plan-domiciliario" class="btn btn-primary">Plan Domiciliario</button>
    </div>


    <!-- PACIENTES------------------------------------------------------------------------------------------>
    <div id="myModal_pacientes" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Pacientes</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-10">
                        <div class="box">
                            <div class="box-body" >

                                <table id="t_pacientes" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="tr-nro-title">
                                            Nro HC
                                        </th>
                                        <th class="tr-dimencion-title">
                                            Nombre
                                        </th>
                                        <th class="tr-dimencion-title">
                                            CI
                                        </th>
                                        <th class="tr-dimencion-title">
                                            Edad(AA/MM/DD)
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $estado_pac_id=true;
                                    $default_pac_id=-1;
                                    foreach ($listPacientes as $value)
                                    {
                                    if ($estado_pac_id)
                                    {
                                        $default_pac_id=$value->pac_id;
                                        $estado_pac_id=false;
                                        echo '<input type="hidden" name="default_pac_id" id="default_pac_id" value='.$default_pac_id.'>';
                                    }
                                    ?>
                                    <tr role="row">
                                        <td class="tr-cuadernos tr-nro"
                                            id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>"
                                        >
                                            <?= $value->pac_id; ?>
                                        </td>
                                        <td class="tr-cuadernos tr-dimencion"   id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>">
                                            <?= $value->pac_ap_prim." ".$value->pac_ap_seg." ".$value->pac_nombre; ?>
                                        </td>

                                        <td class="tr-cuadernos tr-dimencion"   id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>">
                                            <?= $value->pac_nro_ci ?>
                                        </td>
                                        <td class="tr-cuadernos tr-dimencion"   id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>">

                                            <?= EdadCompleta($value->pac_fecha_nac); ?>

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

    <!-- CUADERNOS------------------------------------------------------------------------------------------>
    <div id="myModal_cuadernos" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

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

                                <table id="table_cuadernos" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="tr-dimencion">
                                            Codigo
                                        </th>
                                        <th class="tr-dimencion">
                                            Nombre
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $default_cua_id=-1;
                                    $estado_cua_id=true;
                                    $default_pac_id=-1;
                                    $default_cua_nombre="";
                                    $nro_cuadernos=0;
                                    foreach ($listCuadernos as $value)
                                    {
                                    $nro_cuadernos++;
                                    if ($estado_cua_id)
                                    {
                                        $default_cua_id=$value->cua_id;
                                        $estado_cua_id=false;
                                        echo '<input type="hidden" name="default_cua_id" id="default_cua_id" value='.$default_cua_id.'>';
                                        echo '<input type="hidden" name="default_cua_nombre" id="default_cua_nombre" value='.$value->cua_nombre.'>';
                                    }
                                    ?>
                                    <tr role="row">
                                        <td class="tr-cuadernos tr-dimencion" id="<?= $value->cua_id; ?>-<?= $value->cua_nombre; ?>"
                                            style="width:272px">
                                            <?= $value->cua_id; ?>
                                        </td>
                                        <td class="tr-cuadernos tr-dimencion"   id="<?= $value->cua_id; ?>-<?= $value->cua_nombre; ?>" style="width:370px">
                                            <?= $value->cua_nombre; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    echo '<input type="hidden" name="nro_cuadernos" id="nro_cuadernos" value='.$nro_cuadernos.'>';
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
    <!--- END CUADERNOS -->






    <!-- PLAN DOMICILIARIO------------------------------------------------------------------------------------------>
    <div id="myModal_plan_domiciliario" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">PLAN DOMICILIARIO - PLAN DE REHABILITACIÓN PARA LA CASA</h4>
                    Paciente: <label id="plan_domiciliario_tb_nombre_paciente"></label><br>
                    Especialidad: <label id="plan_domiciliario_tb_cuadernos"></label>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-9">
                            <table class="table">
                                <tr>
                                    <th>Area de trabajo</th>
                                    <th>Que(Objetivo)</th>
                                    <th>Como</th>
                                    <th>Quien</th>
                                    <th>Tiempo</th>
                                    <th>Logros</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><textarea name="txtarea-area-trabajo" id="txtarea-area-trabajo" cols="15" rows="2"></textarea></td>
                                    <td><textarea name="txtarea-area-que" id="txtarea-area-que" cols="15" rows="2"></textarea></td>
                                    <td><textarea name="txtarea-area-como" id="txtarea-area-como" cols="15" rows="2"></textarea></td>
                                    <td><textarea name="txtarea-area-quien" id="txtarea-area-quien" cols="15" rows="2"></textarea></td>
                                    <td><textarea name="txtarea-area-tiempo" id="txtarea-area-tiempo" cols="15" rows="2"></textarea></td>
                                    <td><textarea name="txtarea-area-logros" id="txtarea-area-logros" cols="15" rows="2"></textarea></td>
                                    <td>
                                        <input type="button" value="Agregar" id="btn-agregar-plan" class="btn btn-primary">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row" id="resultado_plan_domiciliario">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" class="btn btn-primary">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!--- END CUADERNOS -->

    <!----- INSTITUCIONES -->
    <div id="myModal_instituciones_r" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

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
                                <div class="col-md-1"></div>
                                <div class="col-md-10">

                                    <table id="table_instituciones_r" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="tr-dimencion">
                                                Codigo
                                            </th>
                                            <th class="tr-dimencion">
                                                Nombre
                                            </th>
                                            <th>
                                                Departamento
                                            </th>
                                            <th>
                                                Municipio
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($listInstitucionAll2 as $value) {
                                        ?>
                                        <tr role="row">
                                            <td class="tr-cuadernos" id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:272px">
                                                <?= $value->inst_id; ?>
                                            </td>
                                            <td class="tr-cuadernos"   id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:345px">
                                                <?= $value->inst_nombre; ?>
                                            </td>
                                            <td class="tr-cuadernos"   id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:345px">
                                                <?= $value->departamento->dep_nombre;?>
                                            </td>
                                            <td class="tr-cuadernos"   id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:345px">
                                                <?= $value->municipio->mun_nombre;?>
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
        <!--- END INSTITUCIONES -->
        <!----- INSTITUCIONES REFERIDO A-->
        <div id="myModal_instituciones_ra" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Establecimiento</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-10">
                            <div class="box">
                                <div class="box-body" >

                                    <table id="table_instituciones_ra" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="tr-dimencion">
                                                Codigo
                                            </th>
                                            <th class="tr-dimencion">
                                                Nombre
                                            </th>
                                            <th class="tr-dimencion">
                                                DEPARTAMENTO
                                            </th>
                                            <th class="tr-dimencion">
                                                MUNICIPIO
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($listInstitucionAll2 as $value) {
                                        ?>
                                        <tr role="row">
                                            <td class="tr-cuadernos tr-dimencion" id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:272px">
                                                <?= $value->inst_id; ?>
                                            </td>
                                            <td class="tr-cuadernos tr-dimencion"   id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:345px">
                                                <?= $value->inst_nombre; ?>
                                            </td>
                                            <td class="tr-cuadernos tr-dimencion"   id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:345px">
                                                <?= $value->departamento->dep_nombre;?>
                                            </td>
                                            <td class="tr-cuadernos tr-dimencion"   id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:345px">
                                                <?= $value->municipio->mun_nombre;?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table></div>
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

    </div>

    <div class="col-md-8">
        <div class="box contenedor">
            <div class="box-body">
                <div class="col-md-4">
                    <label for="">Personal de Salud: </label>
                    <?php echo Form::select('rrhh_id', $listRrhh, $usuarioRrhh,array('required'=> true,'class'=>"selectpicker")); ?>
                </div>
                <div class="col-md-3">
                    <label for="">Tipo de Paciente: </label>
                    {!! Form::select('pact_id', array('1' => 'Institucional','2' => 'Convenio'),'default', array('id' => 'pact_id','required'=>true)) !!}
                    <div id='institucion'>
                        <label for="">
                            Institución:
                        </label>
                        {!! Form::select('conv_id', $listInstitucion)  !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="">Consulta nueva: </label>
                    <input type="hidden" name='hc_consulta_nueva' value="0">
                    {!! Form::checkbox('hc_consulta_nueva', '1',false) !!}<br>

                    <label for="">Consulta dentro: </label>
                    <input type="hidden" name='hc_consulta_dentro' value="0">
                    {!! Form::checkbox('hc_consulta_dentro', '1',true) !!}<br>
                </div>
                <div class="col-md-2">
                    <button type="submit" id="btn-save" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>

            </div>
        </div>

    </div>

    <div id="datos-rhh" class="col-md-8"></div>
    <div id="datos-paciente" class="col-md-8"></div>


    <div id="cuaderno" class="col-md-8">

    </div>
    {{ Form::hidden('inst_id',session('institucion')->inst_id) }}

    {!! Form::close() !!}
    <input type="hidden" id="url_create_plan_domiciliario" value="{{asset("plan_domiciliario/create/")}}">
    <input type="hidden" id="url_show_plan_domiciliario" value="{{asset("plan_domiciliario/show/")}}">
    <input type="hidden" id="url_pdf_plan_domiciliario" value="{{asset("plan_domiciliario/pdf/")}}">
    <input type="hidden" id="hidden-cua_id" value="0">
@stop
@section('script')
    <script src="{{asset('js/ajax/ajax.js')}}"></script>
    <script src="{{asset('js/ajax/ajax.js')}}"></script>
    <script>
        var url_data='{{$url_cuaderno}}';
        var url_cuaderno_peticion_hc ='{{$url_cuaderno_peticion_hc}}';
        var estado_agenda='{{$estadoAgenda}}';
        var fila_seleccinable,fila_seleccinable_cuadernos,fila_seleccinable_instituciones_r;
        var default_cua_id=$("#default_cua_id").val();
        var default_pac_id=$("#default_pac_id").val();
        var default_cua_nombre=$("#default_cua_nombre").val();
        var nro_cuadernos=$("#nro_cuadernos").val();
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $(document).ready(
                function(){
                    if(default_cua_id!=-1)
                    {
                        if(nro_cuadernos==1)
                        {
                            ajax_cuaderno2(url_cuaderno_peticion_hc,"#t_cuadernos","#cuaderno",'click',"GET",default_cua_id,default_pac_id);
                            $("#tb-cuadernos").val(default_cua_nombre);
                        }
                    }
                    if(estado_agenda==true)
                        ajax_cuaderno2(url_cuaderno_peticion_hc,"#t_cuadernos","#cuaderno",'click',"GET",'{{$AgendaPacidentesCuaId}}','{{$AgendaPacidentesPacId}}');

                }
        );
        /////////////////////////////////////////////////////
        $("#t_pacientes").on('click', 'td', function(e) {
            //e.toElement.id
            arr=e.target.id.split("-");
            intIdPac=arr[0];
            strNombrePac=arr[1];
            $('#tb_id_paciente').val(intIdPac);
            $('#tb_nombre_paciente').val(strNombrePac);
            console.log(e.target.id);
            $('#myModal_pacientes').modal('hide');
        });
        $("#btn-paciente").on('click',function(e){
            $("#t_pacientes").DataTable();
            $('#myModal_pacientes').modal('show');
        });
        $("#pact_id").on('change',function(e){
            $("#institucion").toggle();
        });

        $("#institucion").hide();
        //ajax_cuaderno3(url_data,"#t_cuadernos","#cuaderno",'click',"GET",$('#tb_id_paciente').val());
        ajax_cuaderno(url_data,"#t_cuadernos","#cuaderno",'click',"GET");
        $("#t_cuadernos").on('click','td',function(e){
            if (typeof fila_seleccinable == 'undefined') {
                $(this).addClass("tr-seleccionable");
                fila_seleccinable=$(this);
            }
            else
            {
                fila_seleccinable.removeClass("tr-seleccionable");
                $(this).addClass("tr-seleccionable");
                fila_seleccinable=$(this);

            }
        });
        /////////////////////////cuadernos///////////////////////////////////////////
        $("#btn-cuadernos").on('click',function(e){
            $("#table_cuadernos").DataTable();
            $('#myModal_cuadernos').modal('show');
        });
        $("#table_cuadernos").on('click','td',function(e){
            var tb_id_paciente;
            if($("#tb_id_paciente").val()=="")
                tb_id_paciente=-1;
            else
                tb_id_paciente=$("#tb_id_paciente").val();
            if (typeof fila_seleccinable_cuadernos == 'undefined') {
                $(this).addClass("tr-seleccionable");
                fila_seleccinable_cuadernos=$(this);
            }
            else
            {
                fila_seleccinable_cuadernos.removeClass("tr-seleccionable");
                $(this).addClass("tr-seleccionable");
                fila_seleccinable_cuadernos=$(this);

            }
            arr=e.target.id.split("-");
            intIdPac=arr[0];
            $('#hidden-cua_id').val(intIdPac);
            strNombrePac=arr[1];
            $('#tb-cuadernos').val(strNombrePac);
            $('#myModal_cuadernos').modal('hide');
            ajax_cuaderno2(url_cuaderno_peticion_hc,"#t_cuadernos","#cuaderno",'click',"GET",intIdPac,tb_id_paciente);
        });
        //////////////////////end cuadernos////////////////////////////////////
        /////////////////////////instituciones///////////////////////////////////////////
        $("#btn_referido_de_establecimeinto").on('click',function(e){
            $("#table_instituciones_r").DataTable();
            $('#myModal_instituciones_r').modal('show');
        });
        $("#table_instituciones_r").on('click','td',function(e){
            if (typeof fila_seleccinable_instituciones_r == 'undefined') {
                $(this).addClass("tr-seleccionable");
                fila_seleccinable_instituciones_r=$(this);
            }
            else
            {
                fila_seleccinable_instituciones_r.removeClass("tr-seleccionable");
                $(this).addClass("tr-seleccionable");
                fila_seleccinable_instituciones_r=$(this);

            }
            arr=e.target.id.split("-");
            intIdPac=arr[0];
            strNombrePac=arr[1];
            $('#tb_referido_de_establecimeinto').val(strNombrePac);
            $('#referido_de_inst_id').val(intIdPac);
            $('#myModal_instituciones_r').modal('hide');
            //ajax_cuaderno2(url_cuaderno_peticion,"#t_cuadernos","#cuaderno",'click',"GET",intIdPac);
        });
        //////////////////////end instituciones////////////////////////////////////
        /////////////////////////instituciones referido A///////////////////////////////////////////
        $("#btn_referido_a_establecimeinto").on('click',function(e){
            $("#table_instituciones_ra").DataTable();
            $('#myModal_instituciones_ra').modal('show');
        });
        $("#table_instituciones_ra").on('click','td',function(e){
            if (typeof fila_seleccinable_instituciones_r == 'undefined') {
                $(this).addClass("tr-seleccionable");
                fila_seleccinable_instituciones_r=$(this);
            }
            else
            {
                fila_seleccinable_instituciones_r.removeClass("tr-seleccionable");
                $(this).addClass("tr-seleccionable");
                fila_seleccinable_instituciones_r=$(this);

            }
            arr=e.target.id.split("-");
            intIdPac=arr[0];
            strNombrePac=arr[1];
            $('#tb_referido_a_establecimeinto').val(strNombrePac);
            $('#referido_a_inst_id').val(intIdPac);
            $('#myModal_instituciones_ra').modal('hide');
            //ajax_cuaderno2(url_cuaderno_peticion,"#t_cuadernos","#cuaderno",'click',"GET",intIdPac);
        });
        //////////////////////end instituciones////////////////////////////////////
        $("#t_Rrhh").on('click', 'td', function(e) {
            $("#datos-rhh").html("<b>Rhh: </b> "+$(this).html());
            $("#rrhh_id").val(e.target.id);
        });
        $("#tb_nombre_paciente").on('keypress', function(e){
            e.preventDefault();
        });
        $("#tb-cuadernos").on('keypress', function(e){
            e.preventDefault();
        });
        $("#tb_referido_de_establecimeinto").on('keypress', function(e){
            e.preventDefault();
        });
        $("#tb_referido_a_establecimeinto").on('keypress', function(e){
            e.preventDefault();
        });
        $("#btn-plan-domiciliario").on('click', function(e){
            url_data=$("#url_show_plan_domiciliario").val();
            tb_id_paciente=$("#tb_id_paciente").val();
            cua_id=$("#hidden-cua_id").val();
            url_data=url_data+"/"+tb_id_paciente+"/"+cua_id;
            console.log(url_data);
            $("#plan_domiciliario_tb_nombre_paciente").text($("#tb_nombre_paciente").val());
            $("#plan_domiciliario_tb_cuadernos").text($("#tb-cuadernos").val());
            ajaxGET("#resultado_plan_domiciliario",url_data);
            $('#myModal_plan_domiciliario').modal('show');
        });


        $("#btn-pdf-plan").on('click', function(e){
            url_data=$("#url_pdf_plan_domiciliario").val();
            tb_id_paciente=$("#tb_id_paciente").val();
            cua_id=$("#hidden-cua_id").val();
            url_data=url_data+"/"+tb_id_paciente+"/"+cua_id;

            $(this).attr('href',url_data);
            console.log(url_data);
            /*
             $("#plan_domiciliario_tb_nombre_paciente").text($("#tb_nombre_paciente").val());
             $("#plan_domiciliario_tb_cuadernos").text($("#tb-cuadernos").val());
             ajaxGET("#resultado_plan_domiciliario",url_data);
             $('#myModal_plan_domiciliario').modal('show');*/
        });


        $("#btn-agregar-plan").on('click',function(e){
            txt_area_trabajo=$("#txtarea-area-trabajo").val();
            txt_area_que=$("#txtarea-area-que").val();
            txt_area_como=$("#txtarea-area-como").val();
            txt_area_quien=$("#txtarea-area-quien").val();
            txt_area_tiempo=$("#txtarea-area-tiempo").val();
            txt_area_logros=$("#txtarea-area-logros").val();
            url_data=$("#url_create_plan_domiciliario").val();
            tb_id_paciente=$("#tb_id_paciente").val();
            cua_id=$("#hidden-cua_id").val();



            $("#txtarea-area-trabajo").val("");
            $("#txtarea-area-que").val("");
            $("#txtarea-area-como").val("");
            $("#txtarea-area-quien").val("");
            $("#txtarea-area-tiempo").val("");
            $("#txtarea-area-logros").val("");


            familiar_seg_id="Familiar1";
            persona_ref_id="PersonaReg1";
            url_data=url_data+"/"+tb_id_paciente+"/"+familiar_seg_id+"/"+persona_ref_id+"/"+txt_area_trabajo+"/"+txt_area_que+"/"+txt_area_como+"/"+txt_area_quien+"/"+txt_area_tiempo+"/"+txt_area_logros+"/"+cua_id;
            console.log(url_data);
            ajaxGET("#resultado_plan_domiciliario",url_data);
        });
    </script>
@stop