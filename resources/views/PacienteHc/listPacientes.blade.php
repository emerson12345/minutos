<div class="box">
    <div class="box-body" >
        <div class="box-title">
            <h3>Pacientes</h3>
        </div>
        <table class="table table-bordered" id="t_pacientes">
            <tbody>
            <tr>
                <th>Nombres</th>
            </tr>
            <?php
            foreach ($listPacientes as $flight) {
            ?>
            <tr class="tr-cuadernos">
                <td id="<?= $flight->pac_id ?>">
                    <?= $flight->pac_nombre ?>
                    <?= $flight->pac_ap_prim ?>
                    <?= $flight->pac_ap_seg ?>

                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>