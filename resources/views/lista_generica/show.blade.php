
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
                            <table id="t_cuadernos-list-generica" class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>NOMBRE</th>
                                </tr>
                                <?php
                                foreach ($listFormularios as $value) {
                                ?>
                                <tr class="tr-cuadernos">
                                    <td id="<?= $value->lis_codigo; ?>-<?= $value->lis_descripcion; ?>">
                                        <?= $value->lis_codigo; ?>
                                    </td>
                                    <td id="<?= $value->lis_codigo; ?>-<?= $value->lis_descripcion; ?>">
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
    $('#myModal').modal('show');
    $("#t_cuadernos-list-generica").on('click','td',function(e){
        form_id='{{$for_id}}';
        $("#"+form_id).val(e.toElement.id);
        $('#myModal').modal('hide');
    });
</script>