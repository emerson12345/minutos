function ocultarModal(strIdModal){
    $(strIdModal).modal('hide');
}
function mostrarModal(strIdModal){
    $(strIdModal).modal('show');
}
function clickModal(strIdModal,strIdBotonModal)
{
    $(strIdBotonModal).on('click',function(e){
        mostrarModal(strIdModal);
    });
}