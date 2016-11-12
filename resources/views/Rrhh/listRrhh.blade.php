<div class="box">
    <div class="box-body" >
        <div class="box-title">
            <h3>Personal</h3>
        </div>
        <table class="table table-bordered" id="t_Rrhh">
            <tbody>
            <tr>
                <th>Nombres</th>
            </tr>
            <?php
            foreach ($listRrhh as $flight) {
            ?>
            <tr class="tr-cuadernos">
                <td id="<?= $flight->rrhh_id ?>" class="<?= $flight->rrhh_id ?>">
                    <?= $flight->rrhh_nombre ?>
                    <?= $flight->rrhh_ap_prim ?>
                    <?= $flight->rrhh_ap_seg ?>

                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>