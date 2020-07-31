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
            console.log('Servicio eliminado.');
            alert('Servicio Eliminado');
        }).fail(function(){
            console.log('Error al eliminar servicio');
        });
    });

});

function mostrarmodal($id){

    $url = '/servicios/editar/'+$id;
    console.log('Editando el Servicio: '+$id);
    $.get($url, function(data){
        $('#Modaltipo').val(data.tipo);
        $('#Modalnombre').val(data.nombre);
        $('#Modaldescripcion').val(data.descripcion);
        $('#Modalid').val(data.id);
    });
}