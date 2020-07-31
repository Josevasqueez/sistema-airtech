@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 mb-4">
        <div class="card">
            <div class="card-header">Detalles de la Aeronave</div>
            <div class="m-0 p-0 cobertordeimagen bg-dark">
                <img src="{{ route('imagenavion', ['filename' => $aeronave->imagen] ) }}" class="" alt="">
            </div>
            <div class="card-body justify-content-between">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre del cliente:</label>
                        <input id="nombre" type="nombre" class="form-control" name="nombre" value="{{ $aeronave->Usuario->nombre.' '.$aeronave->Usuario->apellido }}" disabled>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email:</label>
                        <a href="mailto:{{ $aeronave->Usuario->email }}">
                            <input id="email" type="email" class="form-control" name="email" value="{{ $aeronave->Usuario->email }}" disabled>
                        </a>                    
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="Telefono">Teléfono:</label>
                        <input id="Telefono" type="Telefono" class="form-control" name="Telefono" value="{{ $aeronave->Usuario->telefono }}" disabled>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="pais">Pais de residencia:</label>
                        <input id="pais" type="pais" class="form-control" name="pais" value="{{ $aeronave->Usuario->pais }}" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="siglas">Siglas:</label>
                        <input id="siglas" type="siglas" class="form-control" name="siglas" value="{{ $aeronave->siglas }}" disabled>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="Seriales">Seriales:</label>
                        <input id="Seriales" type="Seriales" class="form-control" name="Seriales" value="{{ $aeronave->seriales }}" disabled>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="estado">Estado Actual:</label>
                        <input id="estado" type="estado" class="form-control {{ $aeronave->estado == 'En taller' ? ' bg-danger' : 'bg-success' }} text-white" name="estado" value="{{ $aeronave->estado }}" disabled>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="estado">Trabajos realizados:</label>
                        <input id="estado" type="estado" class="form-control bg-light" name="estado" value="{{ count($aeronave->ordenes) }}" disabled>
                    </div>

                    @if(Auth::User()->rol != 'Cliente')
                    <div class="form-group col-12">
                        <form action="{{ route('cambiarestado', $aeronave->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-dark btn-block">Actualizar Estado</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-7">
        <div class="card">
            <div class="card-header">Listado de Ordenes de Trabajo</div>
        
            <div class="card-body">
                @if(count((array)$aeronave->ordenes) == 0)
                    <div class="col-12 text-center my-3">
                        <p>A esta aeronave no se le ha registrado ninguna orden de trabajo.</p>
                        @if(Auth::User()->rol != 'Cliente')
                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#ModalOrden">Agregar</button>
                        @endif
                    </div>
                @else
                    @if(Auth::User()->rol != 'Cliente')
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#ModalOrden">Agregar</button>
                    @endif
                    <button type="button" class="btn btn-danger mb-3 d-none">Emitir Reporte</button>

                    <table class="table table-borderred table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Fecha Inicial</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Reportes</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aeronave->ordenes as $orden)
                            <tr>
                                <th scope="row">{{ $orden->id }}</th>
                                <td>{{ \Carbon\Carbon::parse($orden->created_at)->format('d-M-Y') }}</td>
                                <td>
                                    @if(count($orden->reportes) == 0)
                                    <button type="button" class="btn btn-warning btn-sm py-0">Sin Datos</button>
                                    @elseif(count($orden->reportes->where('estado', 'Finalizado')) == count($orden->reportes))
                                    <button type="button" class="btn btn-success btn-sm py-0">Finalizado</button>
                                    @else
                                    <button type="button" class="btn btn-light btn-sm py-0">En Proceso</button>
                                    @endif
                                </td>
                                <td class="text-center pr-4 font-weight-bold">{{count($orden->reportes->where('estado', 'Finalizado'))}}/{{count($orden->reportes)}}</td>
                                <td class="d-flex">
                                    <a href="{{ route('OrdenDeTrabajo', $orden->id)}}">
                                        <button type="button" class="btn btn-dark btn-sm py-0 mr-2">Ver Más</button>
                                    </a>
                                    @if(count($orden->reportes) != 0)
                                    <a href="{{ route('EmitirPDF', $orden->id)}}">
                                        <button type="button" class="btn btn-danger btn-sm py-0">Reporte</button>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ModalOrden" tabindex="-1" role="dialog" aria-labelledby="ModalOrdenTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalOrdenTitle">Crear orden de trabajo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('CrearOrden') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="aeronave">Aeronave Vinculada:</label>
                            <input id="aeronave" type="text" class="form-control" name="aeronave" value="{{ $aeronave->siglas }}" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cliente">Cliente:</label>
                            <input id="cliente" type="text" class="form-control" name="cliente" value="{{ $aeronave->Usuario->nombre.' '.$aeronave->Usuario->apellido }}" disabled>
                        </div>
                        <div class="form-group col-12">
                            <label for="observacion">Observación:</label>
                            <textarea class="form-control" id="observacion" rows="3"></textarea>
                        </div>
                        <input type="number" id="aeronaveid" name="aeronaveid" value="{{ $aeronave->id }}" class="d-none">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/aeronaves/detalles.js') }}"></script>
@endsection