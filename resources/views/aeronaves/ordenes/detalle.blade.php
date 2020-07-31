@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">Orden de Trabajo</div>
                        <div class="col-6 text-right font-weight-bold">#{{$orden->id}}</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-between mb-4">
                        <h3 class="col-sm-6 mt-2">
                            <img src="{{ asset('imagenes/LCwajjo7_400x400.png') }}" height="30px">
                            <span class="font-weight-bold">Airtech</span>
                        </h3>
                        <span class="d-none d-sm-block col-sm-6 text-right">Aeropuerto Caracas, Oscar Machado Zuloaga,<br> Charallave Edo. Miranda.</span>
                    </div>

                    <h6 class="mt-5 text-uppercase">Datos de la Orden</h6>
                    <hr class="my-0">
                    <div class="row">
                        <div class="col-sm-4 my-1"><b>Numero de Orden: </b>{{$orden->id}}</div>
                        <div class="col-sm-4 my-1"><b>Fecha de Inicio: </b>{{ \Carbon\Carbon::parse($orden->created_at)->format('d/m/Y') }}</div>
                        <div class="col-sm-4 my-1"><b>Última Revisión: </b>{{ \Carbon\Carbon::parse($fecha->updated_at)->format('d/m/Y') }}</div>
                        <div class="col-sm-4 my-1"><b>Aeronave: </b>{{$orden->aeronave->siglas}}</div>
                        <div class="col-sm-4 my-1"><b>Seriales: </b>{{$orden->aeronave->seriales}}</div>
                        <div class="col-sm-4 my-1"><b>Modelo: </b>{{$orden->aeronave->modelo->marca.' '.$orden->aeronave->modelo->modelo}}</div>
                        <div class="col-sm-4 my-1"><b>Dueño: </b>{{$orden->aeronave->usuario->nombre.' '.$orden->aeronave->usuario->apellido}}</div>
                        <div class="col-sm-4 my-1"><b>Teléfono: </b><a href="tel:{{$orden->aeronave->usuario->telefono}}">{{$orden->aeronave->usuario->telefono}}</a></div>
                        <div class="col-sm-4 my-1"><b>Email: </b>{{$orden->aeronave->usuario->email}}</div>
                    </div>

                    <h6 class="mt-3 text-uppercase">Información</h6>
                    <hr class="my-0">
                    <div class="row">
                        <div class="col-12 my-1"><b>Observaciones: </b>{{ is_null($orden->observaciones) ? 'Ninguna' : $orden->observaciones }}</div>
                        <div class="col-sm-4 my-1"><b>Reportes Técnicos: </b>{{count($orden->reportes)}}</div>
                        <div class="col-sm-4 my-1"><b>Finalizados: </b>{{count($orden->reportes->where('estado', 'Finalizado'))}}</div>
                        <!-- Verificamos si la cantidad de reportes finalizados es igual a la cantidad de reportes -->
                        @if(count($orden->reportes->where('estado', 'Finalizado')) == count($orden->reportes))
                        <div class="col-sm-4 my-1"><b>Estado:</b> <button type="button" class="btn btn-success btn-sm py-0">Finalizado</button></div>
                        @else
                        <div class="col-sm-4 my-1"><b>Estado:</b> <button type="button" class="btn btn-warning btn-sm py-0">En Proceso</button></div>
                        @endif
                        <!-- Esta funcion se puede mejorar y optimizar, pero por cuestion de tiempo se opta por dejarla mientras trabaje de forma correcta -->
                    </div>

                    
                    <!-- Información de la orden de trabajo se actualia via AJAX -->
                    <table class="table mt-4">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Servicio</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Finalizado</th>
                                
                                @if(Auth::user()->rol != 'Cliente')
                                <th scope="col">Acción</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody id="TablaDeTareas" url="{{ route('ObtenerReportes', $orden->id) }}">
                            <!-- Se rellena via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Menú de Acciones</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <a href="{{ route('detalleaeronave', $orden->aeronave->siglas) }}"><button type="button" class="btn btn-secondary btn-block">Volver a Aeronave</button></a>
                        </div>
                        <div class="col-12 mb-2">
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#ModalReporte">Reporte Técnico</button>
                        </div>
                        <div class="col-12 mb-2">
                            <a href="{{ route('EmitirPDF', $orden->id) }}"><button type="button" class="btn btn-dark btn-block">Emitir Reporte</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="ModalReporte" tabindex="-1" role="dialog" aria-labelledby="ModalReporteTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalReporteTitle">Añadir Reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('CrearReporte') }}" id="CrearReporte">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12">
                            <label for="servicio">Servicio:</label>
                            <select name="servicio" id="servicio" class="form-control" required>
                                <option selected value="">Seleccionar Servicio</option>
                                @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}">{{ $servicio->tipo.' - '.$servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="number" id="orden" name="orden" value="{{ $orden->id }}" class="d-none">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="NuevoReporte">Aceptar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('js/aeronaves/detalles.js') }}"></script>
@endsection