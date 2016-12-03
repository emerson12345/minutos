var fila_seleccionada;
function seleccionarFila()
{
    $("#table_personal_search").on('click','td',function(e){
        if (typeof fila_seleccionada == 'undefined') {
            $(this).addClass("tr-seleccionable");
            fila_seleccionada=$(this);
        }
        else
        {
            fila_seleccionada.removeClass("tr-seleccionable");
            $(this).addClass("tr-seleccionable");
            fila_seleccionada=$(this);

        }
        arr=e.toElement.id.split("-");
        intIdPer=arr[0];
        strNombrePer=arr[1];
        $('#tb_personal_atencion').val(strNombrePer);
        $('#tb_personal_atencion_id').val(intIdPer);
        //ocultarModal();
    });
}
function getDataTable(strIdTablaModal){
    console.log(strIdTablaModal+"TABLA MODAL");
    $(strIdTablaModal).DataTable();
}


