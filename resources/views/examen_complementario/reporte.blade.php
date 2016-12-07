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
                    <th style="width: 20%;text-align: center;">Tipo de examen</th>
                    <th style="width: 40%;text-align: center;">Examen solicitado</th>
                    <th style="width: 40%;text-align: center;">Resultado</th>

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
                        echo "<td>"."".$fila->$value."</td>";
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
    <table>
        <tr>
            <td style="text-align: center;width: 33%;"><?= Auth::user()->user_nombre ?><br>
                Medico responsable</td>
        </tr>
    </table>
    <!-- /.row -->
</section>
<!-- /.content -->