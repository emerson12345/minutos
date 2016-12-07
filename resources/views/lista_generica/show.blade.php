<style>
    thead, tbody { display: block; }
    tbody {
        height: 150px;
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
        width: 200px;
    }
    .td-dimencion{
        width: 200px;
    }

</style>
<!-- Lista generica------------------------------------------------------------------------------------------>
<div id="myModal-peticion-listas" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <?php
                    if($col_tipo==3){
                        echo "CIE10";
                    }
                    else
                    {
                        if($col_tipo==16){
                            echo "CIF";
                        }
                        else
                            echo $listFormularios[0]->col_combre;
                        }
                    ?>
                </h4>
            </div>
            <div class="modal-body">
                <div class="col-md-10">
                    <div class="box">
                        <div class="box-body" >

                            <table id="t_cuadernos-list-generica" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th class="tr-dimencion">
                                        Código
                                    </th>
                                    <th class="tr-dimencion">
                                        Nombre
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($listFormularios as $value) {
                                ?>
                                <tr role="row">
                                    <td  class="tr-cuadernos tr-dimencion" id="<?= $value->lis_codigo; ?>+<?= $value->lis_descripcion; ?>" style="width:221px">
                                        <?= $value->lis_codigo; ?>
                                    </td>
                                    <td class="tr-cuadernos tr-dimencion" id="<?= $value->lis_codigo; ?>+<?= $value->lis_descripcion; ?>" style="width:400px">
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
    $('#myModal-peticion-listas').modal('show');
    $("#t_cuadernos-list-generica").DataTable();

    $("#t_cuadernos-list-generica").on('click','td',function(e){
        form_id='{{$for_id}}';
        console.log("lista generia show");
        console.log("id form "+form_id);
        console.log("lista generia show");
        console.log("valor "+e.target.id.split("+")[1]);
        $("#"+form_id).val(e.target.id.split("+")[1]);
        $('#myModal-peticion-listas').modal('hide');
    });
</script>