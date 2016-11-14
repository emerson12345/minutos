
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
                    <div class="box-body">
                        <label for="">Referido de Establecimiento: </label>
                        <?php echo Form::select('referido_de_inst_id', $listInstitucionAll, array('required'=> true)); ?>
                        <br>
                        <label for="">Referido a Establecimiento: </label>
                        {!! Form::select('referido_a_inst_id', $listInstitucionAll, array('id' => 'pact_id2','required'=>true)) !!}
                    </div>
                </div>

                <div class="box">
                    <div class="box-body" >
                        <label for="">CUADERNOS</label>
                        <table class="table table-bordered" id="t_cuadernos">
                            <tbody>
                            <tr>
                                <th></th>
                            </tr>
                            <?php
                            foreach ($listCuadernos as $flight) {
                            ?>
                            <tr class="tr-cuadernos">
                                <td id="<?= $flight->cua_id ?>">
                                    <?= $flight->cua_nombre ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-------------------------------------------------------------------------------------------->
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
                                                        <th>
                                                            Nro HC
                                                        </th>
                                                        <th>
                                                            NOMBRE
                                                        </th>
                                                        <th>
                                                            CI
                                                        </th>
                                                        <th>
                                                            Fecha Nacimiento
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach ($listPacientes as $value) {
                                                ?>
                                                <tr role="row">
                                                    <td class="tr-cuadernos"
                                                        id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>"
                                                            >
                                                        <?= $value->pac_id; ?>
                                                    </td>
                                                    <td class="tr-cuadernos"   id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>">
                                                        <?= $value->pac_nombre." ".$value->pac_ap_prim." ".$value->pac_ap_seg; ?>
                                                    </td>

                                                    <td class="tr-cuadernos"   id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>">
                                                        <?= $value->pac_nro_ci ?>
                                                    </td>
                                                    <td class="tr-cuadernos"   id="<?= $value->pac_id; ?>-<?= $value->pac_nombre; ?> <?= $value->pac_ap_prim; ?> <?= $value->pac_ap_seg; ?>">
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
            </div>

            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">
                        <label for="">Personal de Salud: </label>
                        <?php echo Form::select('rrhh_id', $listRrhh, array('required'=> true)); ?>
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

                        <label for="">Paciente con seguro: </label>
                        <input type="hidden" name='hc_con_seguro' value="0">
                        {!! Form::checkbox('hc_con_seguro', '1',false) !!}<br>
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
        var fila_seleccinable;
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

        $("#t_Rrhh").on('click', 'td', function(e) {
            $("#datos-rhh").html("<b>Rhh: </b> "+$(this).html());
            $("#rrhh_id").val(e.toElement.id);
        });
        $("#tb_nombre_paciente").on('keypress', function(e){
            e.preventDefault();
        });
    </script>
@stop