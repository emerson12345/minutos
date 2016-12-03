<?php $Nro=0; ?>
        <!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped" border="1">
                            <thead>
                            <tr>
                                <th>Nro</th>
                                <?php
                                foreach ($nombre_campos_form as $value) {
                                    echo "<th>$value</th>";
                                }
                                ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if($arr_tabla!=false)
                            foreach($arr_tabla as $fila)
                            {?>
                            <tr>
                                <?php
                                $Nro++;
                                echo "<td>";
                                echo $Nro;
                                echo "</td>";

                                //$id_persona=0;
                                foreach ($nombre_campos_tabla as $value){
                                    echo "<td>".$fila->$value."</td>";
                                    //$id_persona=$fila[$value];
                                }
                                ?>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                            <!--
                            <tfoot>
                            <tr>
                                 <th><a href=#>Todo</a></th>
                            </tr>
                            </tfoot>
                            -->
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
</section>
<!-- /.content -->
</div>
</div>