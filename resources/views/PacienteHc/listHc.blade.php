
<div class="box">
    <div class="box-body" >
        <div class="box-title">
            <h3>Registro historico del paciente</h3>
        </div>
        <table class="table table-bordered" id="t_Hc">
            <tbody>
            <tr>
                <th>Registro</th><th>Fecha</th><th>Institución</th>
            </tr>
                <?php
                foreach ($listPacienteHc as $flight) {
                ?>
                <tr class="tr-cuadernos">
                    <td id="<?= $flight->cua_id ?>_<?= $flight->pac_id ?>_<?= $flight->hc_id ?>_<?= $flight->hc_fecha ?>">
                        <?= $flight->cua_nombre ?>
                        <input type="hidden" name="hc_id" value="<?= $flight->hc_id ?>">
                    </td>
                    <td id="<?= $flight->cua_id ?>_<?= $flight->pac_id ?>_<?= $flight->hc_fecha ?>">
                        <?= $flight->hc_fecha ?>
                    </td>
                    <td id="<?= $flight->cua_id ?>_<?= $flight->pac_id ?>_<?= $flight->hc_fecha ?>">
                        <?= $flight->inst_nombre ?>
                    </td>

                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    var fila_seleccinable_hc;
    $("#t_Hc").on('click', 'td', function(e) {
        var n=e.toElement.id.split("_");
        var cua_id=n[0];
        var pac_id=n[1];
        var hc_id=n[2];
        var fecha=n[3];
        console.log("lisHC2 ");
        console.log(hc_id);
        console.log("lisHC2 ");
        var url_hc='{{$url_hc}}';

        if (typeof fila_seleccinable_hc == 'undefined') {
            $(this).parent().addClass("tr-seleccionable-hc");
            fila_seleccinable_hc=$(this);
        }
        else
        {
            fila_seleccinable_hc.parent().removeClass("tr-seleccionable-hc");
            $(this).parent().addClass("tr-seleccionable-hc");
            fila_seleccinable_hc=$(this);

        }

        $.ajax({
            beforeSend: function()
            {
                console.log($("#AtenccionHc").html("cargando...."));
            },
            url:url_hc+"/"+cua_id+"/"+pac_id+"/"+hc_id+"/"+fecha,
            type:"GET",
            data:{nom:"xc"},
            success: function(info){
                //console.log(info);
                $("#AtenccionHc").html(info)
                //console.log($("#PacienteHc").html(info));
            },
            error:function(jqXHR,estado,error){
                console.log("errorrr2");

            }
        });
        //console.log("http://localhost:8000/PacienteHc/atencion/"+cua_id+"/"+Hc_id+"/"+fecha);
    });
</script>