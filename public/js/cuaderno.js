/*function ajax_cuaderno(url_data,elemento,contenedor,evento,metodo)
{
    $(elemento).on(evento, function(e) {
        alert("asdfdsa");
        $.ajax({
            beforeSend: function()
            {
                console.log($(contenedor).html("cargando..."));
            },
            url:url_data+"/"+e.toElement.id,
            type:metodo,
            data:{nom:"xc"},
            success: function(info){
                console.log(info);
                console.log($(contenedor).html(info));
            },
            error:function(jqXHR,estado,error){
                console.log("errorrr");

            }
        });
    });
}
*/
function ajax_cuaderno(url_data,elemento,contenedor,evento,metodo)
{
    $(elemento).on(evento, 'td', function(e) {
        $.ajax({
            beforeSend: function()
            {
                console.log($(contenedor).html("cargando..."));
            },
            url:url_data+"/"+e.toElement.id,
            type:metodo,
            data:{nom:"xc"},
            success: function(info){
                console.log(info);
                console.log($(contenedor).html(info));
            },
            error:function(jqXHR,estado,error){
                console.log("errorrr");

            }
        });
    });
}
function ajax_formulario(url_data,elemento,contenedor,evento,metodo)
{
    $(elemento).on(evento,function(e) {
        $.ajax({
            beforeSend: function()
            {
                console.log($(contenedor).html("cargando..."));
            },
            url:url_data+"/"+e.toElement.id,
            type:metodo,
            data:{nom:"xc"},
            success: function(info){
                console.log(info);
                console.log($(contenedor).html(info));
            },
            error:function(jqXHR,estado,error){
                console.log("errorrr");

            }
        });
    });
}