@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">Listado de Usuarios</div>

            <div class="card-body">
                <p>En este panel podras visualizar todos los usuarios registrados en el sistema, además podrás interactuar con ellos mediante los botones que encontrarás en sus respectivas filas.</p> 
                <div class="row mt-2">
                    <div class="col-12">
                        <div id="BorradoMensaje" class="alert alert-dismissible alert-success fade show" style="display: none" role="alert">
                            <span id="nombreborrado"></span>
                            <button type="button" class="close" onclick="ReiniciarMensaje(1)">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Buscar Usuario" url="{{ route('buscarusuario', '') }}">
                </div>
                <div class="table-responsive" id="tabladeusuarios">
                    <!-- Incluimos el archivo que contiene la tabla actualizada via AJAX -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Crear nuevo usuario -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Añadir Usuario</div>

            <div class="card-body">
                <!-- Formulario que crea los usuarios con un metodo AJAX -->
                <form method="post" action="{{ route('crearusuario') }}" id="nuevousuario">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Su nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Su apellido" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@airtech.com" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Télefono:</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+</div>
                            </div>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="414123123" required>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="pais">Pais:</label>
                            <select id="pais" class="form-control" name="pais" required>
                                <option selected value="Venezuela">Venezuela</option>
                                <!-- Tomamos la variable $pais que viene desde el controlador UserController@panelusuarios -->
                                @foreach($paises as $pais)
                                <option value="{{ $pais }}">{{ $pais }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="rol">Rol:</label>
                            <!-- Los roles permitidos hasta el momento, si se alteran debes modificar manualmente las restricciones
                            que existen dentro del sistema, ya que lo diseñe como un string y no como un int, si la cadena varia no
                            funcionará el sistema de jerarquias -->
                            <select id="rol" class="form-control" name="rol" required>
                                <option selected value="Cliente">Cliente</option>
                                <option value="Mecánico">Mecánico</option>
                                <option value="Gerente">Gerente</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mínimo 8 Caracteres, Máximo 32" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-block" id="crearusuario">Crear Usuario</button>
                    <!-- Boton que activa el javascript y envia la peticion AJAX -->
                </form>
            </div>
        </div>
        <!-- Mensaje de error o confirmación del formulario -->
        <div class="row mt-2">
            <div class="col-12">
                <div id="EstadoMensaje" class="alert alert-dismissible fade show" style="display: none" role="alert">
                    <span id="nombreregistrado"></span>
                    <button type="button" class="close" onclick="ReiniciarMensaje(2)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Los datos mas especificos los puedes observar en la consola del navegador. -->
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/usuarios/usuarios.js') }}"></script>
@endsection