<div class="box box-success">
    <div class="box-body" >
        <div class="box-title">
            <h3>Registro de la atencion clinica</h3>
        </div>
        <table>
            <tbody>
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
                                    echo " <input type='number'>";
                                    break;
                                case 4:
                                    echo "<textarea rows='4' cols='50'></textarea>";
                                    break;
                                case 15:
                                    echo '<a id="'.$flight->col_id.'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Lista</a>';
                                    break;
                                default:
                                    echo " <input type='text'>";
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

        $("a").on('click',function(e) {
            $.ajax({
                beforeSend: function()
                {
                    console.log($("#listas").html("cargando..."));
                },
                url:"http://localhost:8000/cuaderno/peticion_listas/"+e.toElement.id,
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