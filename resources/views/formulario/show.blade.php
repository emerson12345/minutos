{{ Form::hidden('cua_id',$cua_id, array('id' => 'cua_id')) }}

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
                foreach ($listFormularios as $flight) {
                ?>
                <tr id="info">
                    <!--
                    <td><?= $flight->cua_id ?></td>
                    <td><?= $flight->cua_nombre ?></td>
                    <td><?= $flight->for_id ?></td>
                    <td><?= $flight->col_id ?></td>
                    -->
                    <td><?= $flight->col_combre ?></td>
                    <td>
                        <?php
                            switch ($flight->col_tipo)
                            {
                                case 1:
                                    echo " <input type='number' name='".$flight->for_id."'>";
                                    break;
                                case 4:
                                    echo "<textarea rows='4' cols='50' name='".$flight->for_id."'></textarea>";
                                    break;
                                case 15:
                                    echo '
                                    <div class="list-data">
                                    <a id="'.$flight->col_id.'-'.$flight->for_id.'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Cargar</a>
                                    </div>';
                                    echo " <input type='text' name='".$flight->for_id."' id='".$flight->for_id."'>";
                                    break;
                                case 0:
                                    echo "<input type='hidden' name='".$flight->for_id."' value='0'>";
                                ?>
                                    {!! Form::checkbox($flight->for_id, '1',false) !!}
                            <?php
                                    break;
                                default:
                                    echo " <input type='text' name='".$flight->for_id."'>";
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
        var url_data='{{$url_cuaderno}}';
        $("a").on('click',function(e) {

            data=e.toElement.id.split("-");
            var col_id=data[0];
            var for_id=data[1];
            $.ajax({
                beforeSend: function()
                {
                    $("#listas").html("cargando...");
                },
                url:url_data+"/"+col_id+"/"+for_id,
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
    </script>