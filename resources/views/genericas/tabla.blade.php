<style>
    .tr-table:hover
    {
        background-color: #1abc9c;
        cursor: pointer;
    }
</style>
<?php $Nro=0; ?>
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                    <!-- /.box-header -->
                <br>
                        <?php
                            if(isset($border))
                                echo '<table class="table-condensed" id="tabla_'.$nombre_tabla.'">';
                            else
                                echo '<table border="1" id="tabla_'.$nombre_tabla.'">';
                        ?>
                            <tr>
                                <th>Nro</th>
                                <?php
                                foreach ($nombre_campos_form as $value) {
                                    echo "<th>$value</th>";
                                }
                                ?>
                            </tr>
                             <?php
                            if($arr_tabla!=false)
                            foreach($arr_tabla as $fila)
                            {?>
                            <tr class="tr-table">
                                <?php
                                $Nro++;
                                echo "<td class='td_seleccionable'>";
                                echo $Nro;
                                echo "</td>";
                                //$id_persona=0;
                                foreach ($nombre_campos_tabla as $value){
                                    if($fila->$value=="cod")
                                        echo "<input type='hidden' id=".$fila->$value.">";
                                    echo "<td class='td_seleccionable' id=".$fila->cod.">".$fila->$value."</td>";
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
</section>
<!-- /.content -->
