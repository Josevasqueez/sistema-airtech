$(document).ready(function(){

    BuscarDatos();

    $('#NuevoReporte').click(function(e){
        e.preventDefault();
        $urlpost = $("#CrearReporte").attr("action");
        $data = $("#CrearReporte").serialize();
        $.ajax({
            type:"POST",
            url: $urlpost,
            data: $data,
            dataType : 'json',
            success: function(data){
                console.log(data.message);
                $("#CrearReporte")[0].reset();
                BuscarDatos();
                alert('Reporte añadido con éxito');
            },
            error: function(data){
                //Imprimimos los errores por la consola para ver cuales son.
                console.log("Listado de errores en el formulario:");
                console.log(data.message);
                $("#CrearReporte")[0].reset();
                alert('Hay un error para añadir reportes');
            }
        })
    });

    $(document).on('click', '.botonactualizar' ,function(e){
        e.preventDefault();
        if( ! confirm("¿Estás seguro de moficiar el estado de este reporte técnico?")){
            return false;
        }
        $form = $(this).parents('form');
        $url = $form.attr("action");
        $.post($url, $form.serialize(), function(result){
            console.log('Reporte Actualizado.');
            BuscarDatos();
        }).fail(function(){
            console.log('Error al actualizar el reporte');
        });
    });


    $(document).on('click', '.botonborrar' ,function(e){
        e.preventDefault();
        if( ! confirm("¿Estás seguro de borrar este reporte técnico?")){
            return false;
        }
        $form = $(this).parents('form');
        $url = $form.attr("action");
        $.post($url, $form.serialize(), function(result){
            console.log('Reporte Borrado.');
            BuscarDatos();
        }).fail(function(){
            console.log('Error al borrar el reporte');
        });
    });

});


function BuscarDatos(){
    $url = $('#TablaDeTareas').attr("url");
    $.get($url, function(data){
        $('#TablaDeTareas').html(data);
    });
}