$("#select-date").datepicker({language:'es',todayHighlight:true});
$("#new-cita").on("click",function () {
    var url=$(this).data('url');
    $.ajax({
        url:url,
        beforeSend:function () {
            var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            $("#modal-agenda").find(".box").append($over);
        },
        success:function (data) {
            $("#modal-agenda").find(".box .box-body").html(data);
            eventHandlers();
        },
        complete:function () {
            $("#modal-agenda").find(".overlay").remove();
        }
    });
    $("#modal-agenda").modal("show");
});

function eventHandlers(){
    $("#agenda_fec_ini").datetimepicker({locale:'es'});
    $("#sesiones").TouchSpin({
        verticalbuttons:true,
        min:1,
        step:1
    });
    $("#duracion").TouchSpin({
        verticalbuttons:true,
        min:15,
        step:5
    });
    $("#pac_id").select2({
        language:'es',
        placeholder:'Buscar paciente',
        minimumInputLength:3,
        ajax:{
            url:$("#pac_id").data('url'),
            dataType:'json',
            delay:250,
            data:function (params) {
                return {
                    query: params.term,
                };
            },
            processResults: function (data, page) {
                console.log(data);
                return {
                    results: data
                };
            }
        },
        templateResult: templatePaciente
    });

    $("#rrhh_id").select2({
        language:'es',
        placeholder:'Buscar medico',
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
        },
        templateResult: templatePersona
    });
}

$("#btn-save").on('click',function () {
    var $form =$(this).closest(".modal-content").find(".modal-body form");
    $.ajax({
        url:$form.attr("action"),
        data:$form.serialize(),
        method:'post',
        beforeSend:function () {
            var $over = $("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            $("#modal-agenda").find(".box").append($over);
            $form.find("span.label-warning").text("");
        },
        success:function(data){
            $("#modal-agenda").modal('hide');
        },
        error:function(data) {
            var errors = data.responseJSON;
            $.each(errors,function(i,o){
                $form.find("[name ^= '"+i+"']").closest(".form-group").find("span.label-warning").text(o);
            });
        },
        complete:function () {
            $("#modal-agenda").find(".overlay").remove();
        }
    });
});

function templatePaciente(persona){
    if (!persona.id) { return persona.text; }
    var $persona = $(
        '<strong>' + persona.text + ' <abbr title="edad"> ('+ persona.edad +')</abbr>'+'</strong><br/>'
        +'<b>HC:</b>'+persona.nro_hc + '  <b>CI:</b>'+persona.nro_ci+'<br/>'
    );
    return $persona;
}

function templatePersona(persona){
    if (!persona.id) { return persona.text; }
    var $persona = $(
        '<strong>' + persona.text + '</strong><br/>'
        +'<b>CI:</b>'+persona.nro_ci+'<br/>'
    );
    return $persona;
}