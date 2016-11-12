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
                                    echo '<a id="'.$flight->col_id.'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Lista</a>';
                                    echo " <input type='text' name='".$flight->for_id."'>";
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
        //console.log("estos datos");
        //ajax_formulario(url_data,"a","#listas",'click',"GET");
        $("a").on('click',function(e) {
            $.ajax({
                beforeSend: function()
                {
                    console.log($("#listas").html("cargando..."));
                },
                url:url_data+"/"+e.toElement.id,
                type:"GET",
                data:{nom:"xc"},
                success: function(info){
                    console.log(info);
                    console.log($("#listas").html(info));
                },
                error:function(jqXHR,estado,error){
                    console.log("errorrr");
                }
            });
            //console.log(e.toElement.id);
            //console.log($("#cuaderno").html(e.toElement.id));
            //console.log("asfasdfa");
            //console.log(e.toElement.id);
        });
    </script>