<style>
    .dimension{
        height: 250px;
        overflow-x:hidden;
        overflow-y:hidden;
    }
</style>
<div class="box box-primary box-solid">
    <div class="box-body">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
        <div class="table-responsive dimension">
            <table id="source" class="table table-bordered table-hover dimension">
                <thead>
                <tr>
                    <th class="tr-dimencion">Producto</th>
                    <th class="tr-dimencion">Indicadores</th>
                    <th class="tr-dimencion">Cantidad</th>
                    <th class="tr-dimencion"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listPacienteHcReceta as $value) {
                    ?>
                    <tr role="row" id="<?= $value->rec_id; ?>">
                         <td class="tr-cuadernos tr-dimencion">
                            <?= $value->rec_med_nombre; ?>
                        </td>
                        <td class="tr-cuadernos tr-dimencion">
                            <?= $value->rec_indicaciones; ?>
                        </td>
                        <td class="tr-cuadernos tr-dimencion">
                            <?= $value->rec_cantidad; ?>
                        </td>
                        <td class="tr-cuadernos tr-dimencion">
                            <input type="button" class="eliminar-reciboRecetario btn btn-primary btn-xs" value="Eliminar" >
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div><!-- /.modal-content -->
</div>
<input type="hidden" id="urlreciboRecetariodestroy" value="<?= $urlreciboRecetariodestroy ?>">
<script>
    urlreciboRecetariodestroy=$("#urlreciboRecetariodestroy").val();
    //alert(urlreciboRecetariodestroy);
    $(".eliminar-reciboRecetario").on('click',function(){
        idReciboRecetario=$(this).parents("tr").attr('id');
        //alert(urlreciboRecetariodestroy);
        ajaxGET("#Resultado",urlreciboRecetariodestroy+'/'+idReciboRecetario);
    });
</script>