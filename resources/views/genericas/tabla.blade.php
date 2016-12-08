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
                        <?php
                            if(isset($border))
                                echo '<table class="table-condensed" id="tabla_'.$nombre_tabla.'">';
                            else
                                echo '<table border="1" id="tabla_'.$nombre_tabla.'">';
                        ?>
                            <tr>
                                 <?php
                                foreach ($nombre_campos_form as $value) {
                                    if($value!="COD")
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
                                //$id_persona=0;
                                foreach ($nombre_campos_tabla as $value){
                                    if($fila->$value=="cod")
                                        {
                                            echo "<input type='hidden' id=".$fila->$value.">";
                                        }
                                    else
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
