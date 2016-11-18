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
        //$(this).addClass("tr-seleccionable");
        console.log("ajax "+url_data+"/"+e.toElement.id);
        console.log("fadsfa");
        $.ajax({
            beforeSend: function()
            {
                $(contenedor).html("cargando...");
            },
            url:url_data+"/"+e.toElement.id,
            type:metodo,
            data:{nom:"xc"},
            success: function(info){
                //console.log(info);
                $(contenedor).html(info);
            },
            error:function(jqXHR,estado,error){
                console.log("errorrr");

            }
        });
    });
}
function ajax_cuaderno2(url_data,elemento,contenedor,evento,metodo,id)
{
        console.log("ajax2 "+url_data+"/"+id);
        $.ajax({
            beforeSend: function()
            {
                $(contenedor).html("cargando...");
            },
            url:url_data+"/"+id,
            type:metodo,
            data:{nom:"xc"},
            success: function(info){
                //console.log(info);
                $(contenedor).html(info);
            },
            error:function(jqXHR,estado,error){
                console.log("errorrr");

            }
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