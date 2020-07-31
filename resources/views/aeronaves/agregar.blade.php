@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">Modulo de Registro de Aeronaves</div>

            <div class="card-body">
            <p>Este módulo sirve para agregar nuevas <b>Aeronaves</b> al sistema de la empresa. Recuerda relacionar de forma correcta las aeronaves a su respectivo cliente para evitar confusión en la información.</p> 
            <p class="mt-4"><b class="text-danger">Atención:</b> Una vez creada una aeronave solo puede ser eliminada desde la base de datos por un desarrollador del sistema.</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">Registrar Aeronave</div>

            <div class="card-body">
                <!-- Formulario -->
                <form method="POST" action="{{ route('nuevaaeronave') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-6 col-lg-4 mb-4">
                            <label for="modelo">Modelo de la Aeronave:</label>
                            <select name="modelo" id="modelo" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" required>
                                <option selected value="">Seleccionar Modelo</option>
                                @foreach($modelos as $modelo)
                                <option value="{{ $modelo->id }}">{{ $modelo->marca.' '.$modelo->modelo }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('modelo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('modelo') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6 col-lg-4 mb-4">
                            <label for="seriales">Seriales:</label>
                            <input type="text" class="form-control{{ $errors->has('seriales') ? ' is-invalid' : '' }}" id="seriales" name="seriales" placeholder="Escribir los seriales" required>
                            @if ($errors->has('seriales'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('seriales') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6 col-lg-4 mb-4">
                            <label for="siglas">Siglas Registradas:</label>
                            <input type="text" class="form-control{{ $errors->has('siglas') ? ' is-invalid' : '' }}" id="siglas" name="siglas" placeholder="YVXXXX" required>
                            @if ($errors->has('siglas'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('siglas') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6 col-lg-4 mb-4">
                            <label for="cliente">Nombre del cliente:</label>
                            <select name="cliente" id="cliente" class="form-control{{ $errors->has('cliente') ? ' is-invalid' : '' }}" required>
                                <option selected value="">Seleccionar Cliente</option>
                                @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre.' '.$cliente->apellido }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('cliente'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('cliente') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6 col-lg-4 mb-4">
                            <label for="estado">Estado actual:</label>
                            <select name="estado" id="estado" class="form-control{{ $errors->has('estado') ? ' is-invalid' : '' }}" required>  
                                <option selected value="">Seleccionar estado</option>
                                <option value="En taller">En taller</option>
                                <option value="Operativa">Operativa</option>
                            </select>
                            @if ($errors->has('estado'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('estado') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 col-lg-4 mb-4">
                            <label for="imagen">Foto de la Aeronave:</label>
                            <input id="imagen" type="file" class="form-control{{ $errors->has('imagen') ? ' is-invalid' : '' }}" name="imagen">

                            @if ($errors->has('imagen'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('imagen') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-6 col-md-3">
                            <button class="btn btn-danger btn-block">Cancelar</button>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <button type="submit" class="btn btn-success btn-block">Crear Aeronave</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4">
            @if(session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('mensaje') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Crear nuevo servicio -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Últimas agregadas</div>

            <div class="card-body py-0">
                @foreach($aeronaves as $aeronave)
                    <div class="row my-4">
                        <div class="col-3 miniaturaaviones pl-4">
                            <img src="{{ route('imagenavion', ['filename' => $aeronave->imagen] ) }}" class="rounded-circle" alt="">
                        </div>
                        <div class="col-9 pr-2">
                            <span class="">
                                <b>Fecha:</b> {{$aeronave->created_at}}<br> 
                                <b>Siglas:</b> {{$aeronave->siglas}}
                                <b class="mx-1">-</b>
                                    @if($aeronave->estado == 'En taller')
                                    <b class="text-danger">{{$aeronave->estado}} </b>
                                    @else
                                    <b class="text-success">{{$aeronave->estado}} </b>
                                    @endif
                                <br>
                                <b>Cliente: </b> {{$aeronave->usuario->nombre.' '.$aeronave->usuario->apellido}}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/aeronaves/aeronaves.js') }}"></script>
@endsection