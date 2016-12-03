<style>
    thead, tbody { display: block; }
    tbody {
        height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .tr-cuadernos:hover
    {
        background-color: #1abc9c;
        cursor: pointer;
    }
    .tr-seleccionable{
        background-color: #e74c3c;
    }
    .tr-dimencion{
        font-size: 15px;
        width: 300px;
    }
    .td-dimencion{
        width: 300px;
    }

</style>
<!-- Lista generica------------------------------------------------------------------------------------------>
<div id="<?= $strIdModal; ?>" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <?= $strModalTitulo;?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="col-md-10">
                    <div class="box">
                        <div class="box-body" >

                            <table id="t-<?= $strIdModal; ?>" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th class="tr-dimencion">
                                        CODIGO
                                    </th>
                                    <th class="tr-dimencion">
                                        NOMBRE
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($listFormularios as $value) {
                                    ?>
                                    <tr role="row">
                                        <td  class="tr-cuadernos tr-dimencion" id="<?= $value->lis_codigo; ?>+<?= $value->lis_descripcion; ?>">
                                            <?= $value->lis_codigo; ?>
                                        </td>
                                        <td class="tr-cuadernos tr-dimencion" id="<?= $value->lis_codigo; ?>+<?= $value->lis_descripcion; ?>">
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
<!--- END lista generica -->
<script>
    /*
    $('#myModal-peticion-listas').modal('show');
    $("#t_cuadernos-list-generica").DataTable();

    $("#t_cuadernos-list-generica").on('click','td',function(e){
        form_id='{{$for_id}}';
        console.log("lista generia show");
        console.log("id form "+form_id);
        console.log("lista generia show");
        console.log("valor "+e.toElement.id.split("+")[1]);
        $("#"+form_id).val(e.toElement.id.split("+")[1]);
        $('#myModal-peticion-listas').modal('hide');
    });
    */
    //$("#t-reciboRecetario").DataTable();
</script>