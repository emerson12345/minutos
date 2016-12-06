<div class="row">
    <div class="box col-md-12">
        <div class='col-md-12'>
            <label for="">Tipo de Examen: </label>
            {!! Form::select('ec_indicadores_para_su_uso', $listExamenesTipo,$listExamenComplementario->exc_tip_id,array('name'=>'ec_indicadores_para_el_uso','id'=>'ec_indicadores_para_el_uso','disabled'=>true)) !!}
        </div>
        <div class="col-md-12">
            <label for="">Examen solicitado:</label>
            <textarea name="ec_solicitado" id="ec_solicitado" rows="3" style="margin: 0px; width: 100%; height: 60px;" disabled><?= $listExamenComplementario->hc_com_solicitud;?></textarea>
        </div>
        <div class="col-md-12">
            <label for="">Resultado:</label>
            <textarea name="ec_resultado" id="ec_resultado" rows="3" style="margin: 0px; width: 100%; height: 60px;" required><?= $listExamenComplementario->hc_com_resultado;?></textarea>
        </div>
        <div class="col-md-8">
            <input type="button" value="Actualizar" class="btn btn-success" name="bnt_actualizar_ec" id="bnt_actualizar_ec">
        </div>
        <div class="col-md-4">
            <a href="{{asset("examen_complementario/report_general/".$listExamenComplementario->cod)}}" class="btn btn-success">Imprimir</a>
        </div>
        <br>

    </div>
    <input type="hidden" id="hc_com_id" value="<?= $listExamenComplementario->cod; ?>">
</div>
<script>
    $("#bnt_actualizar_ec").on("click",function(){
        var ec_resultado=$("#ec_resultado").val();
        var hc_com_id=$("#hc_com_id").val();
        var url_examen_complementario_update='{{$url_examen_complementario_update}}';
        url_examen_complementario_update=url_examen_complementario_update+"/"+hc_com_id+"/"+ec_resultado;
        ajaxGET("#respuesta_examen_complementario",url_examen_complementario_update);
        //alert(url_examen_complementario_update);
    });
</script>
