$(document).ready(function(){

    $(document).on('click', '.boton-borrar' ,function(e){
        e.preventDefault();
        if( ! confirm("¿Estas seguro de eliminar?")){
            return false;
        }
        $row = $(this).parents('tr');
        $form = $(this).parents('form');
        $url = $form.attr("action");
        $.post($url, $form.serialize(), function(result){
            $row.fadeOut();
            console.log('Modelo eliminado.');
            alert('Modelo Eliminado');
        }).fail(function(){
            console.log('Error al eliminar modelo');
        });
    });

});

function mostrarmodal($id){

    $url = '/modelos/editar/'+$id;
    console.log('Editando el Modelo: '+$id);
    $.get($url, function(data){
        console.log(data);
        $('#Modalmarca').val(data.marca);
        $('#Modalmodelo').val(data.modelo);
        $('#Modalid').val(data.id);
    });
}