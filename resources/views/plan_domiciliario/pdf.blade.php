        <!-- PLAN DOMICILIARIO------------------------------------------------------------------------------------------>
        <div id="myModal_plan_domiciliario" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        Paciente: <label id="plan_domiciliario_tb_nombre_paciente"><?php echo $listPlanDomiciliario[0]->pac_ap_prim." ".$listPlanDomiciliario[0]->pac_ap_seg." ".$listPlanDomiciliario[0]->pac_nombre ?></label><br>
                        Especialidad: <label id="plan_domiciliario_tb_cuadernos"><?php echo $listPlanDomiciliario[0]->cua_nombre; ?></label><br>
                        Fecha: <label id="plan_domiciliario_tb_cuadernos"><?php echo date("Y:m:d"); ?></label>
                    </div>
                    <div class="modal-body">

                        <div class="col-md-1"></div>
                        <div class="col-md-9">
                            <table class="table" border="1">
                                <tr>
                                    <th>Area de trabajo</th>
                                    <th>Que(Objetivo)</th>
                                    <th>Como</th>
                                    <th>Quien</th>
                                    <th>Tiempo</th>
                                    <th>Logros</th>
                                </tr>
                                <?php
                                foreach($listPlanDomiciliario as $value){
                                ?>
                                <tr>
                                    <td><?= $value->areas_trabajo; ?></td>
                                    <td><?= $value->que; ?></td>
                                    <td><?= $value->como; ?></td>
                                    <td><?= $value->quien; ?></td>
                                    <td><?= $value->tiempo; ?></td>
                                    <td><?= $value->logros_fecha; ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--- END CUADERNOS -->