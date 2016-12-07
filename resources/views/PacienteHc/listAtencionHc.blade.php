<style>
    thead, tbody { display: block; }
    #tbody-formulario {
        height: 450px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .tr-cuadernos:hover
    {
        background-color: #1abc9c;
        cursor: pointer;
    }
    SELECT {
        font-size: 7pt;
        font-family : verdana,arial,helvetica;
    }
</style>
<!----- INSTITUCIONES -->
<div id="modal_examen_complementario" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="box">


                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Examenes complementarios</h4>
                </div>
                <div class="modal-body">
                    <?= $tabla_examen_complementario ?>
                    <?= $modal_examen_complementario ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--- END INSTITUCIONES -->

<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-md-8">
                <?php
                    if($EstadoModificar==true)
                    {
                    ?>
                    <div class="col-md-8">
                        <input type="submit" value="Modificar" class="btn btn-edit btn-md btn-primary">
                    </div>
                    <div class="col-md-4">
                        <input type="button" value="Examen complementario" id="btn_examen_complementario" class="btn btn-edit btn-md btn-primary">
                    </div>
                    <br>
                    <?php
                    }
                    ?>


            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-3">
                {{ Form::hidden('hc_id',$hc_id) }}
                {{ Form::hidden('cua_id',$cua_id) }}
                {{ Form::hidden('fecha',$fecha) }}
                <label for="">Consulta nueva: </label>
                {{ Form::checkbox('hc_consulta_nueva', $listDatosHc->hc_consulta_nueva, $listDatosHc->hc_consulta_nueva) }}
                <label for="">Consulta dentro: </label>
                <?php
                if($listDatosHc->hc_consulta_dentro==1)
                    echo Form::checkbox('hc_consulta_dentro','1',true);
                else
                    echo Form::checkbox('hc_consulta_dentro','0',false);
                ?>
            </div>
            <div class="col-md-4">
                <label for="">Personal de Salud: </label>
                <?php echo Form::select('rrhh_id', $listRrhh,$listDatosHc->rrhh_id); ?>
                <br>
                <label for="">Personal de Salud2: </label>
                <?php echo Form::select('rrhh_id2', $listRrhh,$listDatosHc->rrhh_id2); ?>
            </div>
            <div class="col-md-5">
                <label for="">Tipo de Paciente: </label>
                {!! Form::select('pact_id', array('1' => 'INSTITUCIONAL','2' => 'CONVENIO'),$listDatosHc->pact_id, array('id' => 'pact_id','required'=>true)) !!}
                <div id='institucion'>
                    <label for="">
                        Institucion:
                    </label>
                    {!! Form::select('conv_id', $listInstitucion)  !!}
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-5">
                <label for="">Referido de Establecimeinto</label>
                <input type="text" id="referido_de_inst_id" name="referido_de_inst_id" size="1" value="<?= $listDatosHc->referido_a_inst_id; ?>"  style="visibility:hidden">
                <input type="text" id="tb_referido_de_establecimeinto" name="tb_referido_de_establecimeinto" size="25" value="<?= $listDatosHc->referido_d; ?>">
                <?= $btn_referido_de_establecimeinto;?>
                <!--<input type="button" value="..." id="btn_referido_de_establecimeinto" name="btn_referido_de_establecimeinto"> -->
            </div>
            <div class="col-md-1">

            </div>
            <div class="col-md-5">
                <label for="">Referido a Establecimeinto</label>
                <input type="text" id="referido_a_inst_id" name="referido_a_inst_id" size="1" value="<?= $listDatosHc->referido_a_inst_id; ?>"  style="visibility:hidden">
                <input type="text" id="tb_referido_a_establecimeinto" name="tb_referido_a_establecimeinto" size="25" value="<?= $listDatosHc->referido_a; ?>">
                <!--<input type="button" value="..." id="btn_referido_a_establecimeinto" name="btn_referido_a_establecimeinto">-->
                <?= $btn_referido_a_establecimeinto ?>
            </div>
        </div>
    </div>
</div>
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
                                    <td id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:270px;">
                                        <?= $value->inst_id; ?>
                                    </td>
                                    <td id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:345px;">
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
                                    <td class="tr-cuadernos" id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:270px;">
                                        <?= $value->inst_id; ?>
                                    </td>
                                    <td class="tr-cuadernos"   id="<?= $value->inst_id; ?>-<?= $value->inst_nombre; ?>" style="width:345px;">
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

<div class="box box-success">
    <div class="box-body" >
        <div class="box-title">
            <h3>Registro de la atencion clinica</h3>
        </div>
        <table>
            <tbody id="tbody-formulario">
            <tr>
                <th>Variables</th>
                <th>Registro</th>
            </tr>
            <?php
            foreach ($listAtencionHc as $flight) {
            ?>
            <tr id="info">
                <!--
                    <td><?= $flight->cua_id ?></td>
                    <td><?= $flight->cua_nombre ?></td>
                    <td><?= $flight->for_id ?></td>
                    <td><?= $flight->col_id ?></td>
                    -->
                <?php
                if($flight->for_id!=6 && $flight->for_id!=7)
                {?>
                <td><?= $flight->col_combre ?></td>
                <?php
                }
                ?>
                <td>
                    <?php
                        switch ($flight->col_tipo)
                        {
                        case 1:
                            echo " <input type='number' name='".$flight->for_id."' value=".$flight->red_descripcion.">";
                            break;
                        case 3:
                            if($flight->for_id!=6 && $flight->for_id!=7)
                                {
                            echo '<div class="list-data">
                                  <a id="'.$flight->col_id.'-'.$flight->for_id.'-'.$flight->col_tipo.'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Cargar</a>
                                  ';
                            echo "
                                    <input type='text' name='".$flight->for_id."' id='".$flight->for_id."' value='".$flight->red_descripcion."' readonly>";
                                }
                            break;
                        case 4:
                            echo "<textarea rows='4' cols='30' name='".$flight->for_id."'>".trim($flight->red_descripcion)."</textarea>";
                            break;
                        case 15:
                            if($flight->for_id!=6 && $flight->for_id!=7)
                            {
                                echo '
                                            <div class="list-data">
                                            <a id="'.$flight->col_id.'-'.$flight->for_id.'-'.$flight->col_tipo.'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Cargar</a>
                                            </div>';
                                echo " <input type='text' name='".$flight->for_id."' id='".$flight->for_id."' value='".$flight->red_descripcion."' readonly>";
                            }
                            break;
                        case 0:
                            if($flight->red_descripcion==1)
                                echo  Form::checkbox($flight->for_id, "1",true);
                            else
                                echo  Form::checkbox($flight->for_id, "1",false);
                        ?>
                        <?php
                        break;
                        default:
                            echo " <input type='text' name='".$flight->for_id."' value=".$flight->red_descripcion.">";
                        }
                    ?>
                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<div id="listas">

</div>
<script>
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
        //alert(e.target.id);
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
    $("#btn_examen_complementario").on('click',function(e){
        //$("#table_instituciones_ra").DataTable();
        $('#modal_examen_complementario').modal('show');
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
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //URL=cuaderno/peticion_listas/
    var url_peticion_listas='{{$url_peticion_listas}}';
    //var url_data='http://127.0.0.1/SICEREP2/public/cuaderno/peticion_listas';
    $("a").on('click',function(e) {
        data=e.target.id.split("-");
        var col_id=data[0];
        var for_id=data[1];
        var col_tipo=data[2];
        $.ajax({
            beforeSend: function()
            {
                $("#listas").html("cargando...");
            },
            url:url_peticion_listas+"/"+col_id+"/"+for_id+"/"+col_tipo,
            type:"GET",
            data:{nom:"xc"},
            success: function(info){
                //console.log(info);
                $("#listas").html(info);
            },
            error:function(jqXHR,estado,error){
                console.log("errorrr");
            }
        });
        //console.log(url_data+"/"+col_id+"/"+for_id+"/"+col_tipo);
    });
</script>