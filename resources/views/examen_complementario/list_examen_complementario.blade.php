<style>
    .tr-cuadernos:hover
    {
        background-color: #1abc9c;
        cursor: pointer;
    }
    .tr-seleccionable{
        background-color: #e74c3c;
    }
    .tr-dimencion{
        width: 15px;
    }
    .td-dimencion{
        width: 15px;
    }
    .dimension{
        height: 250px;
        overflow-x:hidden;
        overflow-y:hidden;
    }
    input[type=text]
    {
        width:70px;
    }
</style>
<div class="box box-primary box-solid">
    <div class="box-body">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
        <div class="table-responsive dimension">
            <table id="source" class="table table-bordered table-hover dimension">
                <thead>
                <tr>
                    <th class="tr-dimencion">Tipo de Examen</th>
                    <th class="tr-dimencion">Examen Solicitado</th>
                    <th class="tr-dimencion">Resultado</th>
                    <th class="tr-dimencion"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listPacienteExamenComplementario as $value) {
                ?>
                <tr role="row" id="<?= $value->hc_com_id; ?>">
                    <td  class="tr-cuadernos tr-dimencion">
                        <?= $value->exc_tip_nombre; ?>
                    </td>
                    <td class="tr-cuadernos tr-dimencion">
                        <?= $value->hc_com_solicitud; ?>
                    </td>
                    <td class="tr-cuadernos tr-dimencion">
                        <?= $value->hc_com_resultado; ?>
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
<input type="hidden" id="urlexamenComplementariodestroy" value="<?= $urlexamenComplementariodestroy ?>">
<script>
    urlexamenComplementariodestroy=$("#urlexamenComplementariodestroy").val();
    //alert(urlexamenComplementariodestroy);
    $(".eliminar-reciboRecetario").on('click',function(){
        idExamenComplementario=$(this).parents("tr").attr('id');
        //alert(urlexamenComplementariodestroy);
        ajaxGET("#Resultado_ec",urlexamenComplementariodestroy+'/'+idExamenComplementario);
    });
</script>