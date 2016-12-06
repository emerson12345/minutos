var actividadesTable = $("#actividades-table").DataTable({
    "lengthMenu": [5,10, 25, 50],
    "processing":true,
    "serverSide":true,
    "ajax": $("#actividades-table").data("url"),
    "columns":[
        {data:'act_nro',orderable:true,searchable:true},
        {
            data:function(row, type, val, meta){
                var fecha = row.act_fecha;
                if(moment(row.act_fecha).isValid())
                    fecha = moment(row.act_fecha).format('DD/MM/YYYY HH:mm:ss');
                return fecha;
            },
            orderable:true,
            searchable:true
        },
        {data:'act_apellido_nombre',orderable:true,searchable:true},
        {
            data:function (row,type,val,meta) {
                var valReturn = "";
                if(row.act_seleccionable == 1)
                    valReturn = "<span class='label text-green'>SI</span>";
                else
                    valReturn = "<span class='label text-red'>NO</span>"
                return valReturn;
            },
            orderable:false,searchable:false
        },
        {
            data:function (row,type,val,meta) {
                return '<button type="button" class="btn btn-edit btn-xs btn-primary" data-url="" title="Editar"><i class="fa fa-edit"></i></button>'
                    +'<button type="button" class="btn btn-detail btn-xs btn-primary"  data-url="" title="Permiso a cuadernos"><i class="fa fa-list-ul"></i></button>';
            },
            orderable:false,
            searchable:false
        }
    ]
});

$("#actividades-table-table").on('draw.dt',function () {
    $(".btn-edit").off().on('click',handleEvent);
});

$(".btn-add").on('click',handleEvent);

function handleEvent(){
    var url = $(this).data("url");
    $.ajax({
        url:url,
        beforeSend:function () {
            var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            $("#myModal").find(".box").append($over);
        },
        success:function (data) {
            $("#myModal").find(".box .box-body").html(data);
        },
        complete:function () {
            $("#myModal").find(".overlay").remove();
        }
    });
    $("#myModal").modal("show");
}

/*
$("#btn-save").on("click",function(){
    var $form =$(this).closest(".modal-content").find(".modal-body form");
    $.ajax({
        url:$form.attr("action"),
        data:$form.serialize(),
        method:'post',
        beforeSend:function () {
            var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            $("#myModal").find(".box").append($over);
            $form.find("span.label").text("");
        },
        success:function(data){
            usersTable.ajax.reload();
            $("#myModal").modal('hide');
        },
        error:function(data) {
            var errors = data.responseJSON;
            $.each(errors,function(i,o){
                $form.find("[name ^= '"+i+"']").closest(".col-sm-9").find("span.label").text(o);
            });
        },
        complete:function () {
            $("#myModal").find(".overlay").remove();
        }
    });
});

    */