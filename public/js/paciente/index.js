var pacientesTable = $("#pacientes-table").DataTable({
    "lengthMenu": [5,10, 25, 50],
    "processing":true,
    "serverSide":true,
    "ajax": $("#pacientes-table").data('url'),
    "columns":[
        {data:'pac_nro_hc',searchable:true},
        {data:'pac_nro_ci',searchable:true},
        {data:'pac_ap_prim'},
        {data:'pac_ap_seg'},
        {data:'pac_nombre',searchable:false},
        {data:'pac_sexo',orderable:false,searchable:false},
        {data:'pac_fecha_nac',orderable:false,searchable:false},
        {
            data:function (row,type,val,meta) {
                var valReturn = "";
                if(row.pac_con_discapaci == 1)
                    valReturn = "<span class='label label-primary'>SI</span>";
                else
                    valReturn = "<span class='label label-primary'>NO</span>"
                return valReturn;
            },
            orderable:false,searchable:false
        },
        {data:'pac_fec_alta',orderable:false,searchable:false},
        {data:'pac_fec_mod',orderable:false,searchable:false},
        {
            data:function (row,type,val,meta) {
                return '<button type="button" class="btn btn-edit btn-xs btn-primary" data-url="update/'+row.pac_id+'" ><i class="fa fa-edit"></i> Editar</button>'
            },
            orderable:false
        }
    ]
});

$("#pacientes-table").on('draw.dt',function () {
    var contador = pacientesTable.rows().eq(0).length;
    if(contador>0)
        $(".btn-add").prop('disabled',true);
    else
        $(".btn-add").removeAttr('disabled');
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
            pacientesTable.search('').draw();
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
