<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::GET('/', 'AeronaveController@index')->name('home');

//Rutas para mis datos
Route::GET('/mis-datos', 'UserController@detalle')->name('misdatos');
Route::POST('/mis-datos/guardar', 'UserController@actualizardatos')->name('actualizarmisdatos');
Route::POST('/mis-datos/password', 'UserController@actualizarpassword')->name('actualizarpassword');
Route::POST('/mis-datos/avatar', 'UserController@actualizaravatar')->name('actualizaravatar');
Route::GET('/usuario/avatar/{filename}', 'UserController@getAvatar')->name('avatar');

// Rutas de Usuarios
Route::GET('/usuarios', 'UserController@panelusuarios')->name('usuarios')->middleware('rol:Developer');
Route::GET('/usuarios/busqueda/{page?}', 'UserController@buscar')->name('buscarusuario');
Route::POST('/usuarios/crear', 'UserController@crear')->name('crearusuario');
Route::POST('/usuarios/borrar/{id}', 'UserController@borrar')->name('borrarusuario');
Route::GET('/usuarios/editar/{id}', 'UserController@editar')->name('editarusuario');
Route::PUT('/usuarios/guardar', 'UserController@update')->name('guardarusuario');

//Rutas de Modelos
Route::GET('/modelos', 'ModeloController@index')->name('modelos')->middleware('rol:Developer');
Route::POST('/modelos/crear', 'ModeloController@crear')->name('crearmodelo');
Route::POST('/modelos/borrar/{id}', 'ModeloController@borrar')->name('borrarmodelo');
Route::GET('/modelos/editar/{id}', 'ModeloController@editar')->name('editarmodelo');
Route::POST('/modelos/guardar', 'ModeloController@guardar')->name('guardarmodelo');

//Rutas de Servicios
Route::GET('/servicios', 'ServicioController@index')->name('servicios')->middleware('rol:Developer');
Route::POST('/servicios/crear', 'ServicioController@crear')->name('crearservicio');
Route::POST('/servicios/borrar/{id}', 'ServicioController@borrar')->name('borrarservicio');
Route::GET('/servicios/editar/{id}', 'ServicioController@editar')->name('editarservicio');
Route::POST('/servicios/guardar', 'ServicioController@guardar')->name('guardarservicio');

// Rutas para Aeronaves
Route::GET('/aeronaves', 'AeronaveController@index')->name('aeronaves')->middleware('rol:Mecanico');
Route::GET('/aeronaves/busqueda/{page?}', 'AeronaveController@buscar')->name('buscaraeronaves');
Route::GET('/aeronaves/nueva', 'AeronaveController@nueva')->name('agregaraeronave')->middleware('rol:Gerente');
Route::POST('/aeronaves/crear', 'AeronaveController@crear')->name('nuevaaeronave');
Route::GET('/aeronave/imagen/{filename}', 'AeronaveController@getImagen')->name('imagenavion');
Route::GET('/aeronave/{siglas}', 'AeronaveController@detalle')->name('detalleaeronave');
Route::POST('/aeronave/actualizar/{id}', 'AeronaveController@CambiarEstado')->name('cambiarestado');

//Rutas para Ordenes de Trabajo
Route::POST('/orden-de-trabajo/crear/', 'OrdenController@crear')->name('CrearOrden');
Route::GET('/orden-de-trabajo/{id}', 'OrdenController@index')->name('OrdenDeTrabajo');
Route::GET('/orden-de-trabajo/{id}/pdf', 'OrdenController@pdf')->name('EmitirPDF');

// Reportes Técnicos de las ordenes de trabajo  
Route::GET('/orden-de-trabajo/obtener-reportes/{id}', 'ReporteController@index')->name('ObtenerReportes');
Route::POST('/orden-de-trabajo/agregar-reporte', 'ReporteController@crear')->name('CrearReporte');
Route::POST('/orden-de-trabajo/borrar-reporte', 'ReporteController@borrar')->name('BorrarReporte');
Route::POST('/orden-de-trabajo/actualizar-reporte/', 'ReporteController@actualizar')->name('ActualizarReporte');


// Boton para crear orden de trabajo, se abre un modal pidiendo las observaciones que deseas añadirle a la orden de trabajo
// Una vez aceptado, se guarda la información y se crea la orden, redirecciona la página de la orden para proceder a añadir los reportes tecnicos

// La página de los reportes tecnicos contiene breve información de la aeronave, además de un boton de "Añadir" que me abilita un formulario
// para ir agregando mas y mas reportes, todos ellos se guardan automaticamente y pueden ser eliminados unicamente por un
// Developer.

// Los clientes veran la lista y podran imprimir un PDF con toda la info de la orden de trabajo.
// Los mecanicos tendran la opcion de marcar como lista los reportes y añadir nuevos.
// El gerente puede visualizar toda la info, añadir nuevos y emitir un reporte en PDF sobre la orden de trabajo.
// El developer puede hacer todo y Eliminar información.

// La pantalla mostrará la lista, informacion de la aeronave, tiempo en el que se realizó cada tarea, una lista de fotos de las tareas
// el estado de las mismas, una barra de progreso, un indicador de progreso numerico ( 15/20, ejemplo ) y un menú lateral que permita
// volver a la página de la aeronave sin salir al menú.

