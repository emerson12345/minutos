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
            foreach ($listAtencionHc as $flight) {
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
                            echo " <input readonly type='number' name='".$flight->for_id."' value=".$flight->red_descripcion.">";
                            break;
                        case 4:
                            echo "<textarea readonly rows='4' cols='50' name='".$flight->for_id."'>".$flight->red_descripcion."</textarea>";
                            break;
                        case 15:
                            echo " <input readonly type='text' name='".$flight->for_id."' value=".$flight->red_descripcion.">";
                            break;
                        default:
                            echo " <input readonly type='text' name='".$flight->for_id."' value=".$flight->red_descripcion.">";
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