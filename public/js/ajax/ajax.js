function ajaxGET(divContainer,urlData)
{
    $.ajax({
        beforeSend: function()
        {
            $(divContainer).html("cargando...");
        },
        url:urlData,
        type:"GET",
        data:{nom:"xc"},
        success: function(info){
            //console.log(info);
            $(divContainer).html(info);
        },
        error:function(jqXHR,estado,error){
            console.log("error");
        }
    });
}
