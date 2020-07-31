@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">Modelos de Aeronaves</div>

            <div class="card-body">
                <p>Estos son los modelos que han sido registrados en el sistema hasta el momento. Los modelos son necesarios para poder añadir Aeronaves.</p> 
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
                <div class="table-responsive" id="tablademodelos">
                    <!-- Incluimos el archivo que contiene la tabla actualizada via AJAX -->

<table class="table table-borderred table-hover">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Marca</th>
            <th scope="col">Modelo</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if(sizeof($modelos) > 0)
            @foreach( $modelos as $modelo)
            <tr>
                <th scope="row">{{ $modelo->id }}</th>
                <td>{{ $modelo->marca }}</td>
                <td>{{ $modelo->modelo }}</td>
                <td class="d-flex">
                    <form action="" method="" class="mr-1">
                        @csrf
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Editar">
                            <span class="badge badge-primary py-2" style="width: 25px;" onclick="mostrarmodal({{ $modelo->id }})" data-toggle="modal" data-target="#ModalEditar"><i class="fas fa-pen"></i></span>
                        </a>
                    
                    </form>
                    <form action="{{ route('borrarmodelo', $modelo->id) }}" method="delete" class="">
                        @csrf
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Borrar" class="boton-borrar">
                            <span class="badge badge-danger py-2" style="width: 25px;"><i class="fas fa-trash-alt"></i></span>
                        </a>
                    </form>
                </td>
            </tr>
            @endforeach
        @else
        <tr>
            <td colspan="6" class="text-center">No hay datos</td>
        </tr>
        @endif
    </tbody>
</table>


<!-- Modal -->
<div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('guardarmodelo') }}" id="editarmodelo">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar modelo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <input type="text" class="form-control{{ $errors->has('marca') ? ' is-invalid' : '' }}" id="Modalmarca" name="marca" required disabled>
                        @if ($errors->has('marca'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('marca') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo:</label>
                        <input type="text" class="form-control" id="Modalmodelo" name="modelo" required>
                    </div>
                </div>
                <input type="hidden" name="id" id="Modalid">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar modelo</button>
                </div>
                <!-- Boton que activa el javascript y envia la peticion AJAX -->
            </form>
        </div>
    </div>
</div>



                </div>
            </div>
        </div>
    </div>
    
    <!-- Crear nuevo modelo -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Añadir Modelo</div>

            <div class="card-body">
                <!-- Formulario que crea los modelos -->
                <form method="post" action="{{ route('crearmodelo') }}" id="crearmodelo">
                    @csrf
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <select id="marca" class="form-control" name="marca" required>
                            <option selected value="Cessna">Cessna</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo:</label>
                        <input type="text" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" id="modelo" name="modelo" placeholder="Nombre del modelo" required>
                        @if ($errors->has('modelo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('modelo') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success btn-block" id="crearmodelo">Crear Modelo</button>
                </form>
            </div>

        </div>
        <!-- Mensaje de error o confirmación del formulario -->
        <div class="row mt-2">
            <div class="col-12">
                @if(session('mensaje'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('mensaje') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong>{{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
        <!-- Los datos mas especificos los puedes observar en la consola del navegador. -->
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/modelos/modelos.js') }}"></script>
@endsection