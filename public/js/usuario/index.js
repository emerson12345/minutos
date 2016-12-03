var usersTable = $("#users-table").DataTable({
    "lengthMenu": [5,10, 25, 50],
    "processing":true,
    "serverSide":true,
    "ajax": $("#users-table").data("url"),
    "columns":[
        {data:'user_codigo'},
        {data:'user_nombre'},
        {data:'user_email'},
        {
            data:function(row, type, val, meta){
                var fecha = row.user_fec_alta;
                if(moment(row.user_fec_alta).isValid())
                    fecha = moment(row.user_fec_alta).format('DD/MM/YYYY HH:mm:ss');
                return fecha;
            }
        },
        {
            data:function(row, type, val, meta){
                var fecha = row.user_fec_mod;
                if(moment(row.user_fec_mod).isValid())
                    fecha = moment(row.user_fec_mod).format('DD/MM/YYYY HH:mm:ss');
                return fecha;
            }
        },
        {
            data:function (row,type,val,meta) {
                var valReturn = "";
                if(row.user_seleccionable == 1)
                    valReturn = "<span class='label text-green'>SI</span>";
                else
                    valReturn = "<span class='label text-red'>NO</span>"
                return valReturn;
            },
            orderable:false
        },
        {
            data:function (row,type,val,meta) {
                return '<button type="button" class="btn btn-edit btn-xs btn-primary" data-url="update/'+row.user_id+'" title="Editar"><i class="fa fa-edit"></i></button>'
                      +'<button type="button" class="btn btn-detail btn-xs btn-primary"  data-url="permiso_cuaderno/'+row.user_id+'" title="Permiso a cuadernos"><i class="fa fa-list-ul"></i></button>';
            },
            orderable:false
        }
    ]
});
$("#users-table").on('draw.dt',function () {
    $(".btn-edit").off().on('click',handleEvent);
    $(".btn-detail").off().on('click',handleEvent);
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
            $(".roles").bootstrapDualListbox({
                filterPlaceHolder:'filtrar',
                selectedListLabel:'Seleccionados',
                nonSelectedListLabel:'Disponibles',
                infoText:'Total ({0})',
                infoTextEmpty:'Lista vacia',
                filterTextClear:'Todos',
                infoTextFiltered: '<span class="label label-warning">Filtrados</span> {0} de {1}'
            });
            $("#rrhh_id").select2({
                language:'es',
                placeholder:'Buscar rrhh',
                minimumInputLength:3,
                ajax:{
                    url:$("#rrhh_id").data('url'),
                    dataType:'json',
                    delay:250,
                    data:function (params) {
                        return {
                            query: params.term,
                        };
                    },
                    processResults: function (data, page) {
                        return {
                            results: data
                        };
                    }
                }
            });
            $("#rrhh_id").on('select2:select',function(evt){
                var fullname = $("#rrhh_id").select2('data')[0].text;
                $("#user_nombre").val(fullname);
            });
        },
        complete:function () {
            $("#myModal").find(".overlay").remove();
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