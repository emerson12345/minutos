var rolesTable = $("#roles-table").DataTable({
    "lengthMenu": [5,10, 25, 50],
    "processing":true,
    "serverSide":true,
    "ajax": $("#roles-table").data('url'),
    "columns":[
        {data:'rol_codigo'},
        {data:'rol_nombre'},
        {
            data:function(row, type, val, meta){
                var fecha = row.rol_fec_alta;
                if(moment(row.rol_fec_alta).isValid())
                    fecha = moment(row.rol_fec_alta).format('DD/MM/YYYY HH:mm:ss');
                return fecha;
            }
        },
        {
            data:function(row, type, val, meta){
            var fecha = row.rol_fec_mod;
            if(moment(row.rol_fec_mod).isValid())
                fecha = moment(row.rol_fec_mod).format('DD/MM/YYYY HH:mm:ss');
            return fecha;
        }},
        {
            data:function (row,type,val,meta) {
                var valReturn = "";
                if(row.rol_seleccionable == 1)
                    valReturn = "<span class='label text-green'>SI</span>";
                else
                    valReturn = "<span class='label text-red'>NO</span>"
                return valReturn;
            },
            orderable:false
        },
        {
            data:function (row,type,val,meta) {
                return '<button type="button" class="btn btn-edit btn-xs btn-primary" data-url="update/'+row.rol_id+'" title="Editar"><i class="fa fa-edit"></i> </button>'
            },
            orderable:false
        }
    ]
});

$("#roles-table").on('draw.dt',function () {
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
            /*
            $("#app_list").bootstrapDualListbox({
                filterPlaceHolder:'filtrar',
                selectedListLabel:'Seleccionados',
                nonSelectedListLabel:'Disponibles',
                infoText:'',
                infoTextEmpty:'',
                filterTextClear:'Todos'
            });*/
        }
    });
    $("#myModal").modal("show");
}

$("#btn-save").on("click",function(){
    var $form =$(this).closest(".modal-content").find(".modal-body form");
    $.ajax({
        url:$form.attr("action"),
        data:$form.serialize(),
        method:'post',
        beforeSend:function () {
            var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            $("#myModal").find(".box").append($over);
            $form.find("span").text("");
        },
        success:function(data){
            rolesTable.ajax.reload();
            $("#myModal").modal('hide');
        },
        error:function(data) {
            var errors = data.responseJSON;
            $.each(errors,function(i,o){
                $form.find("[name = '"+i+"']").closest(".col-sm-10").find("span").text(o);
            });
        },
        complete:function () {
            $("#myModal").find(".overlay").remove();
        }
    });
});
