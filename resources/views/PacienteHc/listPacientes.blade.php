<div class="box">
    <div class="box-body" >
        <div class="box-title">
            <h3>Pacientes</h3>
        </div>
        <table class="table table-bordered" id="t_pacientes">
            <thead>
            <tr>
                <th class="tr-dimencion">Nombre</th>
                <th class="tr-dimencion">Fecha</th>
                <th class="tr-dimencion">CI</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($listPacientes as $flight) {
            ?>
            <tr class="tr-cuadernos">
                <td id="<?= $flight->pac_id ?>" class="td-dimencion">
                    <?= $flight->pac_nombre ?>
                    <?= $flight->pac_ap_prim ?>
                    <?= $flight->pac_ap_seg ?>

                </td>
                <td id="<?= $flight->pac_id ?>" class="td-dimencion">
                    <?= $flight->pac_fecha_nac ?>
                </td>
                <td id="<?= $flight->pac_id ?>" class="td-dimencion">

                    <?= $flight->pac_nro_ci ?>
                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>