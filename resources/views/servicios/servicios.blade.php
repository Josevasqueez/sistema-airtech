@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">Servicios prestados por la Empresa</div>

            <div class="card-body">
                <p>Estos son los servicios que han sido registrados en el sistema hasta el momento. Los Servicios son necesarios para poder añadir reportes técnicos.</p> 
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
                <div class="table-responsive" id="tabladeservicios">
                    <!-- Incluimos el archivo que contiene la tabla actualizada via AJAX -->

<table class="table table-borderred table-hover">
    <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Tipo</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @if(sizeof($servicios) > 0)
            @foreach( $servicios as $servicio)
            <tr>
                <th scope="row">{{ $servicio->id }}</th>
                <td>{{ $servicio->nombre }}</td>
                <td>{{ $servicio->tipo }}</td>
                <td class="d-flex">
                    <form action="" method="" class="mr-1">
                        @csrf
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Editar">
                            <span class="badge badge-primary py-2" style="width: 25px;" onclick="mostrarmodal({{ $servicio->id }})" data-toggle="modal" data-target="#ModalEditar"><i class="fas fa-pen"></i></span>
                        </a>
                    
                    </form>
                    <form action="{{ route('borrarservicio', $servicio->id) }}" method="delete" class="">
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
            <form method="post" action="{{ route('guardarservicio') }}" id="editarservicio">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Editar Servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tipo">Tipo:</label>
                        <input type="text" class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}" id="Modaltipo" name="tipo" required disabled>
                        @if ($errors->has('tipo'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tipo') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="nombre">Mombre:</label>
                        <input type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" id="Modalnombre" name="nombre" required>
                        @if ($errors->has('nombre'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripcion:</label>
                        <textarea class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" id="Modaldescripcion" name="descripcion" required rows="2"></textarea>
                        @if ($errors->has('descripcion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('descripcion') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <input type="hidden" name="id" id="Modalid">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Servicio</button>
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
    
    <!-- Crear nuevo servicio -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Añadir Servicio</div>

            <div class="card-body">
                <!-- Formulario que crea los servicios -->
                <form method="post" action="{{ route('crearservicio') }}" id="crearservicio">
                    @csrf
                    <div class="form-group">
                        <label for="tipo">Tipo de Servicio:</label>
                        <select id="tipo" class="form-control" name="tipo" required>
                            <option selected value="Mecanico">Mecánico</option>
                            <option value="Avionica">Avionica</option>
                            <option value="Tapicería">Tapicería</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" id="nombre" name="nombre" placeholder="Nombre del servicio" required>
                        @if ($errors->has('nombre'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripcion:</label>
                        <textarea class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" id="descripcion" name="descripcion" placeholder="Descripción del servicio" required rows="2"></textarea>
                        @if ($errors->has('descripcion'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('descripcion') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success btn-block" id="crearservicio">Crear Servicio</button>
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
<script src="{{ asset('js/servicios/servicios.js') }}"></script>
@endsection