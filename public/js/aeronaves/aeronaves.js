$(document).ready(function(){

    // Ejecutamos la busqueda completa al iniciar la pagina
    BuscarDatos();

    // Cada vez que escribimos en el buscador
    $(document).on('keyup', '#search', function(){
        $query = $(this).val();
        BuscarDatos($query);
     });

    // Configuramos los botones de la paginación
    $(document).on('click', '.pagination li a' ,function(e){
        e.preventDefault();
        $url = $(this).attr("href");
        $query = $("#search").val();
        $.ajax({
            url: $url,
            type: 'GET',
            data:{query:$query},
            success: function(data){
                $('#listadodeaeronaves').html(data);
            },
            error: function(data){
                console.log('Hay un error en el metodo AJAX');  
            }
        });

    });

});

function BuscarDatos($query = ''){
    $url = $('#search').attr("url");
    $.ajax({
        url: $url,
        type: 'GET',
        data:{query:$query},
        success: function(data){
            $('#listadodeaeronaves').html(data);
        },
        error: function(data){
            console.log('Hay un error en el metodo AJAX');  
        }
    });
}