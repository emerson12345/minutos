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
                    valReturn = "<span class='text-green'>SI</span>";
                else
                    valReturn = "<span class='text-red'>NO</span>"
                return valReturn;
            },
            orderable:false
        },
        {
            data:function (row,type,val,meta) {
                return '<button type="button" class="btn btn-detail btn-xs btn-primary"  data-url="establecimiento/'+row.user_id+'" title="Acceso a establecimientos"><i class="fa fa-list-ul"></i></button>';
            },
            orderable:false
        }
    ]
});
$("#users-table").on('draw.dt',function () {
    $(".btn-detail").off().on('click',handleEvent);
});

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
            filterEventHandler();
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

function filterEventHandler(){
    $("[name=departamento]").on('change',function(){
        var dep_id = $(this).val();
        var url = $(this).data('url');
        var token = $(this).data('token');
        $.ajax({
            url:url,
            method:'post',
            data:{dep_id:dep_id,_token:token},
            success:function(data){
                var $opt = $("<option>",{value:0,text:'TODO'});
                $("[name=municipio]").html($opt);
                for(item in data){
                    $opt = $("<option>",{value:data[item].mun_id,text:data[item].mun_nombre});
                    $("[name=municipio]").append($opt);
                }
            },
            complete:function(){
                $("[name=municipio]").val(0);
                $("[name=area]").val(0);
                setEstablecimientos();
            }
        });
    });

    $("[name=municipio]").on('change',function(){
        var mun_id = $(this).val();
        var url = $(this).data('url');
        var token = $(this).data('token');
        $.ajax({
            url:url,
            method:'post',
            data:{mun_id:mun_id,_token:token},
            success:function(data){
                var $opt = $("<option>",{value:0,text:'TODO'});
                $("[name=area]").html($opt);
                for(item in data){
                    $opt = $("<option>",{value:data[item].area_id,text:data[item].area_nombre});
                    $("[name=area]").append($opt);
                }
            },
            complete:function(){
                $("[name=area]").val(0);
                setEstablecimientos();
            }
        });
    });

    $("[name=area]").on('change',setEstablecimientos);
}

function setEstablecimientos(){
    var dep_id = $('[name=departamento]').eq(0).val(),
        mun_id = $('[name=municipio]').eq(0).val(),
        area_id = $('[name=area]').eq(0).val();
    console.log(dep_id+" "+mun_id+" "+area_id);
    var url = $("#institucion_list").data('url');
    var token = $('[name=departamento]').eq(0).data('token');
    $.ajax({
        url:url,
        method:'post',
        data:{dep_id:dep_id,mun_id:mun_id,area_id:area_id,_token:token},
        success:function(data){
            $("#institucion_list").find("option:not(:selected)").remove();
            $.each(data,function(i,v){
                if($("#institucion_list").find("option[value="+v.inst_id+"]").length==0)
                    $("#institucion_list").append($("<option>",{value:v.inst_id,text:v.inst_nombre}));
            });
            $("#institucion_list").bootstrapDualListbox('refresh');
        }
    });
}