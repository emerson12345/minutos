
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= $listFormularios[0]->col_combre; ?></h4>
            </div>
            <div class="modal-body">
                <div class="col-md-10">
                    <div class="box">
                        <div class="box-body" >
                            <div class="">

                            </div>
                            <table class="table table-bordered" id="t_cuadernos">
                                <tbody>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>NOMBRE</th>
                                </tr>
                                <?php
                                foreach ($listFormularios as $value) {
                                ?>
                                <tr class="tr-cuadernos">
                                    <td>
                                        <?= $value->lis_codigo; ?>
                                    </td>
                                    <td>
                                        <?= $value->lis_descripcion; ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div>
</div>
<script>
    $('#myModal').modal('show')
</script>