<input type="hidden" value="<?= $url_examen_complementario; ?>" id="url_examen_complementario">
<div id="respuesta_examen_complementario">

</div>
<script src="{{asset('js/ajax/ajax.js')}}"></script>
<script>
    $("#tabla_examen_complementario").on('click','td',function(e){
        /*
        if (typeof fila_seleccinable_instituciones_r == 'undefined') {
            $(this).addClass("tr-seleccionable");
            fila_seleccinable_instituciones_r=$(this);
        }
        else
        {
            fila_seleccinable_instituciones_r.removeClass("tr-seleccionable");
            $(this).addClass("tr-seleccionable");
            fila_seleccinable_instituciones_r=$(this);

        }
        arr=e.toElement.id.split("-");
        intIdPac=arr[0];
        strNombrePac=arr[1];
        $('#tb_referido_de_establecimeinto').val(strNombrePac);
        $('#referido_de_inst_id').val(intIdPac);
        $('#myModal_instituciones_r').modal('hide');
         ajax(url_cuaderno_peticion,"#t_cuadernos","#cuaderno",'click',"GET",intIdPac);
        */
        var url_examen_complementario=$("#url_examen_complementario").val()+"/"+e.toElement.id;
        ajaxGET("#respuesta_examen_complementario",url_examen_complementario);
    });
</script>