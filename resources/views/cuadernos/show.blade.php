
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
                width: 200px;
            }
            .td-dimencion{
                width: 200px;
            }

        </style>

        {!! Form::open(['route' => 'libregistro.store' ,'class'=>'form-horizontal']) !!}


                <div class="col-md-4">
                    <div class="box">
                        <div class="box-body">
                            <input type="submit" class="btn btn-success">
                        </div>
                    </div>

                <div class="box">
                    <div class="box-body">
                        <label for="">
                            <?php echo "Fecha: "; echo date("d/m/Y"); ?>
                        </label>
                    </div>
                </div>

                <div class="box">
                    <div class="box-body">
                        <label for="">Paciente:</label><br>
                        <input type="hidden" name="pac_id" id="tb_id_paciente" size="5" readonly>
                        <input type="text" id="tb_nombre_paciente" size="30"  required="true">
                        <input type="button" id="btn-paciente" class="btn-success" value="Buscar">
                    </div>
                </div>
                    <div class="box">
                        <div class="box-body" >
                            <label for="">CUADERNOS</label>
                            <input type="button" value="..." id="btn-cuadernos" name="btn-cuadernos">
                            <br>
                            <input type="text" id="tb-cuadernos" name="tb-cuadernos" size="45" required>
                        </div>
                    </div>



                    <div class="box">
                        <div class="box-body" >
                            <label for="">Referido de Establecimeinto</label>
                            <input type="button" value="..." id="btn_referido_de_establecimeinto" name="btn_referido_de_establecimeinto">
                            <br>
                            <input type="text" id="referido_de_inst_id" name="referido_de_inst_id" size="5" value="-1"  style="visibility:hidden">
                            <input type="text" id="tb_referido_de_establecimeinto" name="tb_referido_de_establecimeinto" size="45">
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body" >
                            <label for="">Referido a Establecimeinto</label>
                            <input type="button" value="..." id="btn_referido_a_establecimeinto" name="btn_referido_a_establecimeinto">
                            <br>
                            <input type="text" id="referido_a_inst_id" name="referido_a_inst_id" size="5" value="-1"  style="visibility:hidden">
                            <input type="text" id="tb_referido_a_establecimeinto" name="tb_referido_a_establecimeinto" size="45">
                        </div>
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
                                                        <th class="tr-dimencion">
                                                            Nro HC
                                                        </th>
                                                        <th class="tr-dimencion">
                                                            NOMBRE
                                                        </th>
                                                        <th class="tr-dimencion">
                                                            CI
                                                        </th>
                                                        <th class="tr-dimencion">
                                                            Fecha Nacimiento
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($listPacientes as $value) {
                                                ?>
                                                <tr role="row">
                                                    <td class="tr-cuadernos tr-dimencion"
                                                        id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>"
                                                            >
                                                        <?= $value->pac_id; ?>
                                                    </td>
                                                    <td class="tr-cuadernos tr-dimencion"   id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>">
                                                        <?= $value->pac_nombre." ".$value->pac_ap_prim." ".$value->pac_ap_seg; ?>
                                                    </td>

                                                    <td class="tr-cuadernos tr-dimencion"   id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>">
                                                        <?= $value->pac_nro_ci ?>
                                                    </td>
                                                    <td class="tr-cuadernos tr-dimencion"   id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>">
                                                        <?= $value->pac_fecha_nac; ?>
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
                                                            CODIGO
                                                        </th>
                                                        <th class="tr-dimencion">
                                                            NOMBRE
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    foreach ($listCuadernos as $value) {
                                                    ?>
                                                    <tr role="row">
                                                        <td class="tr-cuadernos tr-dimencion"
                                                            id="<?= $value->cua_id; ?>-<?= $value->cua_nombre; ?>"
                                                                >
                                                            <?= $value->cua_id; ?>
                                                        </td>
                                                        <td class="tr-cuadernos tr-dimencion"   id="<?= $value->cua_id; ?>-<?= $value->cua_nombre; ?>">
                                                            <?= $value->cua_nombre; ?>
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

                                                <table id="table_instituciones_r" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="tr-dimencion">
                                                            CODIGO
                                                        </th>
                                                        <th class="tr-dimencion">
                                                            NOMBRE
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    foreach ($listInstitucionAll2 as $value) {
                                                    ?>
                                                    <tr role="row">
                                                        <td class="tr-cuadernos tr-dimencion"
                                                            id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>"
                                                           y>     >e

            >                                                <?= $value->inst_id; ?>
                                                        </td>
                                                        <td class="tr-cuadernos tr-dimencion"   id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>">
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
                    <!--- END INSTITUCIONES -->
                    <!----- INSTITUCIONES REFERIDO A-->
                    <div id="myModal_instituciones_ra" class="modal fade" role="dialog">
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

                                                <table id="table_instituciones_ra" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="tr-dimencion">
                                                            CODIGO
                                                        </th>
                                                        <th class="tr-dimencion">
                                                            NOMBRE
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    foreach ($listInstitucionAll2 as $value) {
                                                    ?>
                                                    <tr role="row">
                                                        <td class="tr-cuadernos tr-dimencion"
                                                            id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>"
                                                                >
                                                            <?= $value->inst_id; ?>
                                                        </td>
                                                        <td class="tr-cuadernos tr-dimencion"   id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>">
                                                            <?= $value->inst_nombre; ?>
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

            <div class="col-md-4">

                <div class="box">
                    <div class="box-body">
                        <label for="">Personal de Salud: </label>
                        <?php echo Form::select('rrhh_id', $listRrhh, array('required'=> true)); ?>
                        <br>
                        <label for="">Personal de Salud2: </label>
                        <?php echo Form::select('rrhh_id2', $listRrhh, array('required'=> true)); ?>
                        <br>
                        <label for="">Tipo de Paciente: </label>
                        {!! Form::select('pact_id', array('1' => 'INSTITUCIONAL','2' => 'CONVENIO'),'default', array('id' => 'pact_id','required'=>true)) !!}
                        <div id='institucion'>
                            <label for="">
                                Institucion:
                            </label>
                            {!! Form::select('conv_id', $listInstitucion)  !!}
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <label for="">Consulta nueva: </label>
                        <input type="hidden" name='hc_consulta_nueva' value="0">
                        {!! Form::checkbox('hc_consulta_nueva', '1',false) !!}<br>

                        <label for="">Consulta dentro: </label>
                        <input type="hidden" name='hc_consulta_dentro' value="0">
                        {!! Form::checkbox('hc_consulta_dentro', '1',true) !!}<br>

                    </div>
                </div>
            </div>

            <div id="datos-rhh" class="col-md-8"></div>
            <div id="datos-paciente" class="col-md-8"></div>


            <div id="cuaderno" class="col-md-8">

            </div>
        {{ Form::hidden('inst_id',session('institucion')->inst_id) }}

        {!! Form::close() !!}
    @stop
@section('script')
    <script>
        var url_data='{{$url_cuaderno}}';
        var url_cuaderno_peticion_hc ='{{$url_cuaderno_peticion_hc}}';
        var fila_seleccinable,fila_seleccinable_cuadernos,fila_seleccinable_instituciones_r;
        $("#t_pacientes").on('click', 'td', function(e) {
            arr=e.toElement.id.split("-");
            intIdPac=arr[0];
            strNombrePac=arr[1];
            $('#tb_id_paciente').val(intIdPac);
            $('#tb_nombre_paciente').val(strNombrePac);
            console.log(e.toElement.id);
            $('#myModal_pacientes').modal('hide');
        });
        /*

        $("#t_pacientes").on('click', 'td', function(e) {
            console.log("dsfasdfdasf");
            console.log(e.toElement.id);
            console.log("dsfasdfdasf");
            $("#pac_id").val(e.toElement.id);
            $("#datos-paciente").html("<b>Paciente: </b> "+$(this).html());
        });*/

        $("#btn-paciente").on('click',function(e){
            $("#t_pacientes").DataTable();
            $('#myModal_pacientes').modal('show');
        });
        $("#pact_id").on('change',function(e){
            $("#institucion").toggle();
        });

        $("#institucion").hide();

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
            arr=e.toElement.id.split("-");
            intIdPac=arr[0];
            strNombrePac=arr[1];
            $('#tb-cuadernos').val(strNombrePac);
            $('#myModal_cuadernos').modal('hide');
            ajax_cuaderno2(url_cuaderno_peticion_hc,"#t_cuadernos","#cuaderno",'click',"GET",intIdPac);
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
            arr=e.toElement.id.split("-");
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
            arr=e.toElement.id.split("-");
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
            $("#rrhh_id").val(e.toElement.id);
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
    </script>
@stop