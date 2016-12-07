<style>
    .tr-table:hover
    {
        background-color: #1abc9c;
        cursor: pointer;
    }
</style>
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                <br>
                <?php
                    echo '<table border="1" id="tabla_'.$nombre_tabla.'">';
                ?>
                <tr>
                    <th style="width: 45%;text-align: center;">Producto</th>
                    <th style="width: 45%;text-align: center;">Indicación</th>
                    <th style="width: 10%;text-align: center;">Cantidad</th>

                    <?php
                        /*
                        foreach ($nombre_campos_form as $value) {
                            echo "<th>$value</th>";
                        }*/
                    ?>
                </tr>
                <?php
                if($arr_tabla!=false)
                foreach($arr_tabla as $fila)
                {
                ?>
                <tr class="tr-table">
                    <?php
                    //$id_persona=0;
                    foreach ($nombre_campos_tabla as $value){
                        if($fila->$value=="cod")
                            echo "<input type='hidden' id=".$fila->$value.">";
                        echo "<td class='td_seleccionable' id=".$fila->cod.">"."       ".$fila->$value."</td>";
                        //$id_persona=$fila[$value];

                    }
                    ?>
                </tr>
                <?php
                }
                ?>
                </table>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
    <table>
        <tr>
            <td style="text-align: center;width: 33%;"><?= Auth::user()->user_nombre ?><br>
                Medico responsable</td>
            <td style="text-align: center;width: 33%;">V.B. Farvacia</td>
            <td style="text-align: center;width: 33%;">Nombre y firma de(la) paciente o acompañante</td>
        </tr>
    </table>
</section>
<!-- /.content -->