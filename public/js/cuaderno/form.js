var table = $("#table-list-columns").DataTable();

$('#table-list-columns tbody').on('click', 'tr:not(.item-unselected)', function () {
    var $row = $(table.row( this ).node());
    $row.toggleClass("item-selected");
} );

$("#table-items-selected tbody tr").on("click",function(){
    $("#table-items-selected tbody tr").removeClass("item-selected");
    $(this).addClass("item-selected")
});

$("#btn-add-column").on("click",function(){
    table.rows(".item-selected").eq(0).each(function(index){
        var $currentRow = $(table.row(index).node());
        $currentRow.removeClass("item-selected");
        var id = $currentRow.data("id");
        var nombre = $currentRow.find("td").eq(0).text();

        var $row = $('<tr data-id="'+id+'" class="new-column">'
            +'<td></td>'
            +'<td>'+nombre+'</td>'
            +'<td>'
            +'<input type="hidden" name="lib_formulario[][col_id]" value="'+id+'">'
            +'<input type="hidden" name="lib_formulario[][for_col_posi]">'
            +'<input type="hidden" name="lib_formulario[][for_seleccionable]" value="0">'
            +'<input type="checkbox" name="lib_formulario[][for_seleccionable]" value="1">'
            +'</td>'
            +'<td>'
            +'<input type="hidden" name="lib_formulario[][for_obliga]" value="N">'
            +'<input type="checkbox" name="lib_formulario[][for_obliga]" value="S">'
            +'</td>'
            +'<td>'
            +'<input type="hidden" name="lib_formulario[][for_modifica]" value="N">'
            +'<input type="checkbox" name="lib_formulario[][for_modifica]" value="S">'
            +'</td>'
            +'</tr>');
        $("#table-items-selected tbody").append($row);
        $("#table-items-selected tbody tr").off().on("click",function(){
            $("#table-items-selected tbody tr").removeClass("item-selected");
            $(this).addClass("item-selected")
        });
        renameRows();
    });
    $("#myModal").modal("hide");
});

$("#btn-remove-row").on("click",function(){
    var $item =$("#table-items-selected tbody").find("tr.item-selected").eq(0);
    if($item.hasClass('new-column')){
        $item.remove();
        renameRows();
    }else{
        alert('Atencion, no puede eliminar una columna que ha sido registrada con anterioridad en el cuaderno.');
    }
});

$("#btn-up-row").on("click",function(){
    var $currentRow = $("#table-items-selected tbody tr.item-selected").eq(0);
    var $prevRow = $currentRow.prev();
    if($prevRow){
        $currentRow.insertBefore($prevRow);
        renameRows();
    }
});

$("#btn-down-row").on("click",function(){
    var $currentRow = $("#table-items-selected tbody tr.item-selected").eq(0);
    var $nextRow = $currentRow.next();
    if($nextRow){
        $currentRow.insertAfter($nextRow);
        renameRows();
    }
});

function renameRows(){
    $("#table-items-selected tbody tr").each(function(i){
        var index = i+1;
        $(this).find("td").eq(0).text(index);
        $(this).find("input[name $= '[for_id]']").attr("name","lib_formulario["+index+"][for_id]");
        $(this).find("input[name $= '[col_id]']").attr("name","lib_formulario["+index+"][col_id]");
        $(this).find("input[name $= '[for_col_posi]']").val(index).attr("name","lib_formulario["+index+"][for_col_posi]");
        $(this).find("input[name $= '[for_seleccionable]']").attr("name","lib_formulario["+index+"][for_seleccionable]");
        $(this).find("input[name $= '[for_obliga]']").attr("name","lib_formulario["+index+"][for_obliga]");
        $(this).find("input[name $= '[for_modifica]']").attr("name","lib_formulario["+index+"][for_modifica]");
    });
}

$("form").submit(function(e){
    var $form = $(this);
    e.preventDefault();
    $.ajax({
        data:$(this).serialize(),
        url:$(this).attr("action"),
        method:"post",
        beforeSend:function(){
            var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            $form.closest(".box").append($over);
            $form.find("span").text("");
        },
        success:function(data){
            window.location.href = data;
        },
        error:function(data){
            var errors = data.responseJSON;
            $.each(errors,function(i,o){
                $form.find("[name = '"+i+"']").closest(".col-sm-10").find("span").text(o);
                $("[name = "+i+"]").text(o);
            });
        },
        complete:function(){
            $form.closest(".box").find(".overlay").remove();
        }
    });
});

$("#myModal").on('hide.bs.modal',function(){
    table.rows(".item-selected").eq(0).each(function(index){
        var $currentRow = $(table.row(index).node());
        $currentRow.removeClass("item-selected");
    });
});

$("#myModal").on('show.bs.modal',function(){
    table.rows(".item-unselected").eq(0).each(function(index){
        var $currentRow = $(table.row(index).node());
        $currentRow.removeClass("item-unselected");
    });

    $("#table-items-selected tbody tr").each(function(){
        var id = $(this).data("id");
        table.rows("[data-id = '"+id+"']").eq(0).each(function(index){
            var $currentRow = $(table.row(index).node());
            $currentRow.addClass("item-unselected");
        });
    });
});