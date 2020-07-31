$(document).ready(function(){

    BuscarDatos();

    $(document).on('click', '.pagination li a' ,function(e){
        e.preventDefault();
        $url = $(this).attr("href");
        $query = $("#search").val();
        $.ajax({
            url: $url,
            type: 'GET',
            data:{query:$query},
            success: function(data){
                $('#tabladeusuarios').html(data);
            },
            error: function(data){
                console.log('Hay un error en el metodo AJAX');  
            }
        });

    });

    $('#crearusuario').click(function(e){
        e.preventDefault();
        $urlpost = $("#nuevousuario").attr("action");
        $data = $("#nuevousuario").serialize();
        ReiniciarMensaje(2);
        $.ajax({
            type:"POST",
            url: $urlpost,
            data: $data,
            dataType : 'json',
            success: function(data){
                console.log(data.message);
                $("#nuevousuario")[0].reset();
                $nombre = data.message;
                $('#nombreregistrado').html('<strong>Exito!</strong> El usuario <b>'+$nombre+'</b> se ha registrado.');
                $('#EstadoMensaje').addClass('alert-success').fadeIn();
                $query = $("#search").val();
                BuscarDatos($query);
            },
            error: function(data){
                //Imprimimos los errores por la consola para ver cuales son.
                console.log("Listado de errores en el formulario:");
                console.log(data.responseJSON.errors);
                $('#EstadoMensaje').addClass('alert-danger').fadeIn();
                $('#nombreregistrado').html('<strong>Ups!</strong> Tienes un error en el formulario.');
            }
        })
    });

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
            console.log('Usuario eliminado.');
            $query = $("#search").val();
            setTimeout(BuscarDatos($query), 500);
            $nombre = result.mensaje;
            $('#nombreborrado').html('<strong>Adios!</strong> El usuario '+$nombre);
            $('#BorradoMensaje').fadeIn();
        }).fail(function(){
            console.log('Error al eliminar usuario');
        });
    });

    $(document).on('click', '#guardarusuario' ,function(e){
        e.preventDefault();
        $urlpost =  $("#editarusuario").attr("url");
        $data = $("#editarusuario").serialize();
        $.ajax({
            type:"PUT",
            url: $urlpost,
            data: $data,
            dataType : 'json',
            success: function(data){
                console.log(data.message);
                $('#nombreborrado').html('<strong>Como nuevo!</strong> Se ha editado al usuario con exito');
                $('#BorradoMensaje').fadeIn();
                $query = $("#search").val();
                BuscarDatos($query);
            },
            error: function(data){
                //Imprimimos los errores por la consola para ver cuales son.
                console.log("Listado de errores en el formulario:");
                console.log(data.responseJSON.errors);
                alert('No se puedo editar');
            }
        })
    });

    $(document).on('keyup', '#search', function(){
       $query = $(this).val();
       BuscarDatos($query);
    });
});

function ReiniciarMensaje($id){
    switch($id){
        case 1:{
            $('#BorradoMensaje').addClass('show').hide();
            $('#nombreborrado').html('');
        }
        case 2:{        
            $('#EstadoMensaje').removeClass('alert-success').addClass('show').removeClass('alert-danger').hide();
            $('#nombreregistrado').html('');
        }
    }
}

function mostrarmodal($id){

    $url = '/usuarios/editar/'+$id;
    console.log('Editando el usuario: '+$id);
    $.get($url, function(data){
        $('#Modalnombre').val(data.nombre);
        $('#Modalapellido').val(data.apellido);
        $('#Modalemail').val(data.email);
        $('#Modaltelefono').val(data.telefono);
        $('#Modalpais').val(data.pais);
        $('#Modalrol').val(data.rol);
        $('#Modalid').val(data.id);
    });
}

// Explico la funcion: Tomamos la URL del atributo url del elemento en el DOM, luego emitimos una peticion AJAX encargada de devolver
// Una vista que será introducida en el DOM, cual si fuese un @include.
function BuscarDatos($query = ''){
    $url = $('#search').attr("url");
    $.ajax({
        url: $url,
        type: 'GET',
        data:{query:$query},
        success: function(data){
            $('#tabladeusuarios').html(data);
        },
        error: function(data){
            console.log('Hay un error en el metodo AJAX');  
        }
    });
}