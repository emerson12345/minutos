var pacientesTable = $("#pacientes-table").DataTable({
    "lengthMenu": [5,10, 25, 50],
    "processing":true,
    "serverSide":true,
    "ajax": $("#pacientes-table").data('url'),
    "columns":[
        {data:'pac_nro_hc',searchable:true},
        {data:'pac_nro_ci',searchable:true},
        {data:'pac_ap_prim',searchable:true},
        {data:'pac_ap_seg',searchable:true},
        {data:'pac_nombre',searchable:true},
        {data:'pac_sexo',orderable:false,searchable:false},
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
        {
            data:function (row,type,val,meta) {
                return '<button type="button" style="margin-right: 5px" class="btn btn-edit btn-xs btn-primary" data-url="update/'+row.pac_id+'" ><i class="fa fa-edit"></i></button>'
                    +'<button type="button" style="margin-right: 5px" class="btn btn-detail btn-xs btn-primary"  data-url="detail/'+row.pac_id+'"><i class="fa fa-list-ul"></i></button>'
                    +'<button type="button" class="btn btn-view-group btn-xs btn-primary"  data-url="group/'+row.pac_id+'"><i class="fa fa-group"></i></button>';
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
    $(".btn-detail").off().on('click',handleEvent);
    $(".btn-view-group").off().on('click',getDataGroup);
});

$(".btn-add").on('click',handleEvent);

function handleEvent(){
    if($(this).hasClass('btn-detail'))
        $("#btn-save").addClass('hidden');
    else
        $("#btn-save").removeClass('hidden');
    var url = $(this).data("url");
    $.ajax({
        url:url,
        beforeSend:function () {
            var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            $("#myModal").find(".box").append($over);
        },
        success:function (data) {
            $("#myModal").find(".box .box-body").html(data);
            $("#dep_id").on('change',getMunicipios);
            $("#pac_fecha_nac").datepicker({
                'format':'dd/mm/yyyy',
                language:'es',
            });
            $('#pac_fecha_nac').on('change',function(){
                if(moment($(this).val(),'DD/MM/YYYY').isValid()){
                    var date = moment($(this).val(),'DD/MM/YYYY');
                    $("#pac_edad_anio").val(moment().diff(date,'years'));
                }
                else
                    $("#pac_edad_anio").val("");
            });
            $("input[name=pac_con_discapaci]").on('click',function(){
                if($(this).val()==0){
                    $('#tipo_disc_id').attr('disabled','disabled');
                    $('#tipo_disc_id').val(0);
                    $('#grad_disc_id').attr('disabled','disabled');
                    $('#grad_disc_id').val(0);
                }else{
                    $('#tipo_disc_id').removeAttr('disabled');
                    $('#tipo_disc_id').val($('#tipo_disc_id').find("option").first().val());
                    $('#grad_disc_id').removeAttr('disabled');
                }
            });

            if($('#disc_no').prop('checked')){
                $('#tipo_disc_id').attr('disabled','disabled');
                $('#tipo_disc_id').val(0);
                $('#grad_disc_id').attr('disabled','disabled');
                $('#grad_disc_id').val(0);
            }else{
                $('#tipo_disc_id').removeAttr('disabled');
                $('#tipo_disc_id').val($('#tipo_disc_id').find("option").first().val());
                $('#grad_disc_id').removeAttr('disabled');
            }
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
                $form.find("[name = '"+i+"']").closest(".form-group").find("span").text(o);
            });
        },
        complete:function () {
            $("#myModal").find(".overlay").remove();
        }
    });
});

function getDataGroup(){
    var url = $(this).data("url");
    $.ajax({
        url:url,
        beforeSend:function () {
            var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            $("#modal-group").find(".box").append($over);
        },
        success:function (data) {
            $("#modal-group").find(".box .box-body").html(data);
            $(".btn-add-group, .btn-edit-group, .btn-index-group").off().on('click',getDataGroup);
            $("#btn-save-group").off().on('click',saveGroup);
        },
        complete:function () {
            $("#modal-group").find(".overlay").remove();
        }
    });
    $("#modal-group").modal("show");
}

function saveGroup(){
    var $formGroup = $(this).closest("form");
    var url = $formGroup.attr("action");
    $.ajax({
        url:url,
        data: $formGroup.serialize(),
        method:'post',
        beforeSend:function(){
            var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            $("#modal-group").find(".box").append($over);
            $formGroup.find("span").text("");
        },
        success:function(){
            $(".btn-index-group").eq(0).click();
        },
        error:function(data){
            var errors = data.responseJSON;
            $.each(errors,function(i,o){
                $formGroup.find("[name = '"+i+"']").closest(".col-sm-10").find("span").text(o);
            });
        },
        complete:function(){
            $("#modal-group").find(".overlay").remove();
        }
    });
}

function getMunicipios(){
    var dep_id = $("#dep_id").val();
    var url = $("#dep_id").data('url');
    $.ajax({
        url:url,
        method:'post',
        data:{dep_id:dep_id,_token:$('#dep_id').closest('form').find('input[name=_token]').eq(0).val()},
        success:function (data) {
            var val = $("#mun_id").val();
            $("#mun_id").html('<option value="0"></option>');
            $.each(data,function(index,value){
                var $opt = $("<option>",{value: value.mun_id}).text(value.mun_nombre);
                $("#mun_id").append($opt);
            });
        }
    });
}