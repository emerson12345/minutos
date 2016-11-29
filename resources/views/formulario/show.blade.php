{{ Form::hidden('cua_id',$cua_id, array('id' => 'cua_id')) }}

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
<!-- Evolucion del paciente ------------------------------------------------------------------------------------------>
<div id="myModal-evolucion" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    Evolucion del Paciente
                </h4>
            </div>
            <div class="modal-body">
                <div class="col-md-10">
                    <div class="box">
                        <div class="box-body" >

                            <table id="t_evolucion" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th class="tr-dimencion">
                                        HC_ID
                                    </th>
                                    <th class="tr-dimencion">
                                        PERSONAL
                                    </th>
                                    <th class="tr-dimencion">
                                        FECHA
                                    </th>
                                    <th class="tr-dimencion">
                                        EVOLUCIÓN
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($listEvolucion)>0)
                                    foreach ($listEvolucion as $value) {
                                    ?>
                                    <tr role="row">
                                        <td  class="tr-cuadernos tr-dimencion">
                                            <?php echo $value->hc_id; ?>
                                        </td>
                                        <td class="tr-cuadernos tr-dimencion">
                                            <?php echo $value->rrhh_nombre; ?>
                                            <?php echo $value->rrhh_ap_prim; ?>
                                            <?php echo $value->rrhh_ap_seg; ?>
                                        </td>
                                        <td class="tr-cuadernos tr-dimencion">
                                            <?php echo $value->hc_fecha; ?>
                                        </td>
                                        <td class="tr-cuadernos tr-dimencion">
                                            <?php echo $value->evolucion_descripcion; ?>
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
<!-- END Evolucion del paciente -------------->


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
</style>
<div class="box box-success">
    <div class="box-body" >
        <div class="col-md-8">
            <div class="box-title">
                <h3>Registro de la atencion clinica</h3>
            </div>
        </div>
        <div class="col-md-4">
            <input type="button" name="btn-evolucion"  class="btn btn-success" value="Ver evolución" id="btn-evolucion">
        </div>
        <table>
            <tbody id="tbody-formulario">
            <tr>
                <th>Variables</th>
                <th>Registro</th>
            </tr>
            <tr>
                <td>EVOLUCIÓN: </td>
                <td>
                    <textarea rows='4' cols='50' name="evolucion_descripcion"></textarea>
                </td>
            </tr>
            <?php
            foreach ($listFormularios as $flight) {
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
                        echo " <input type='number' name='".$flight->for_id."' class='tr-dimencion'>";
                        break;
                    case 3:
                        if($flight->for_id!=6 && $flight->for_id!=7)
                        {
                            echo '
                                                <div class="list-data">
                                                <a id="'.$flight->col_id.'-'.$flight->for_id.'-'.$flight->col_tipo.'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Cargar</a>
                                                ';
                            echo " <input type='text' name='".$flight->for_id."' id='".$flight->for_id."' class='tr-dimencion'>
                                        </div>";
                        }
                        break;
                    case 16:
                        if($flight->for_id!=6 && $flight->for_id!=7)
                        {
                            echo '
                                                        <div class="list-data">
                                                        <a id="'.$flight->col_id.'-'.$flight->for_id.'-'.$flight->col_tipo.'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Cargar</a>
                                                        ';
                            echo " <input type='text' name='".$flight->for_id."' id='".$flight->for_id."'>
                                                </div>";
                        }
                        break;
                    case 4:
                        echo "<textarea rows='4' cols='50' name='".$flight->for_id."'></textarea>";
                        break;
                    case 15:
                        if($flight->for_id!=6 && $flight->for_id!=7)
                        {
                            echo '
                                        <div class="list-data">
                                        <a id="'.$flight->col_id.'-'.$flight->for_id.'-'.$flight->col_tipo.'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Cargar</a>
                                        </div>';
                            echo " <input type='text' name='".$flight->for_id."' id='".$flight->for_id."' class='tr-dimencion'>";
                        }
                        break;
                    case 0:
                    echo "<input type='hidden' name='".$flight->for_id."' value='0'>";
                    ?>
                    {!! Form::checkbox($flight->for_id, '1',false) !!}
                    <?php
                    break;
                    default:
                        echo " <input type='text' name='".$flight->for_id."' class='tr-dimencion'>";
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
    //URL=cuaderno/peticion_listas/
    var url_data='{{$url_cuaderno}}';
    $("a").on('click',function(e) {

        data=e.toElement.id.split("-");
        var col_id=data[0];
        var for_id=data[1];
        var col_tipo=data[2];
        console.log(for_id);
        $.ajax({
            beforeSend: function()
            {
                $("#listas").html("cargando...");
            },
            url:url_data+"/"+col_id+"/"+for_id+"/"+col_tipo,
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
    });
    $("#btn-evolucion").on('click',function(e) {
        //alert("adsfaf");
        $('#t_evolucion').DataTable();
        $('#myModal-evolucion').modal('show');
    });
</script>