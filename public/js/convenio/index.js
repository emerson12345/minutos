var conveniosTable = $("#convenios-table").DataTable({
    "lengthMenu": [5,10, 25, 50],
    "processing":true,
    "serverSide":true,
    "ajax": $("#convenios-table").data("url"),
    "columns":[
        {data:'conv_codigo'},
        {data:'conv_nombre'},
        {
            data:function (row,type,val,meta) {
                var valReturn = "";
                if(row.conv_seleccionable == 1)
                    valReturn = "<span class='label label-primary'>VIGENTE</span>";
                else
                    valReturn = "<span class='label label-danger'>NO VIGENTE</span>"
                return valReturn;
            },
            orderable:false
        },
        {
            data:function (row,type,val,meta) {
                var valReturn = "";
                if(row.conv_niv_nacional == 1)
                    valReturn = "<span class='label label-primary'>SI</span>";
                else
                    valReturn = "<span class='label label-primary'>NO</span>"
                return valReturn;
            }
        },
        {data:'conv_fec_alta'},
        {data:'conv_fec_mod'},
        {
            data:function (row,type,val,meta) {
                return '<button type="button" class="btn btn-edit btn-xs btn-primary" data-url="update/'+row.conv_id+'"><i class="fa fa-edit"></i> Editar</button>'
            },
            orderable:false
        }
    ]
});

$("#convenios-table").on('draw.dt',function () {
    $(".btn-edit").off().on('click',handleEvent);
});

$(".btn-add").on('click',handleEvent);
//handle
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
            $("input[name = conv_niv_nacional]").on('click',function(){
                if($(this).val()=="0"){
                    $("#municipios").removeClass('hidden');
                }else{
                    $("#municipios").addClass('hidden');
                }
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
            $form.find("span").text("");
        },
        success:function(data){
            conveniosTable.ajax.reload();
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