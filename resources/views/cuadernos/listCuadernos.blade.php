<div class="box">
    <div class="box-body" >

        <table class="table table-bordered" id="t_cuadernos">
            <tbody>
            <tr>
                <th>CUADERNOS</th>
            </tr>
            <?php
            foreach ($listCuadernos as $flight) {
            ?>
            <tr class="tr-cuadernos">
                <td id="<?= $flight->cua_id ?>">
                    <?= $flight->cua_nombre ?>
                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>