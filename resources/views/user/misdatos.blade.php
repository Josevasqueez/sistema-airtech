@extends('layouts.app')

@section('content')
<div class="row">
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
<div class="row justify-content-center">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">Mis Datos</div>

            <div class="card-body">
                
                <form method="POST" action="{{ route('actualizarmisdatos') }}">
                    @csrf

                    <div class="row">
                        <div class="form-group col-6 col-md-4">
                            <label for="nombre">Nombre:</label>
                            <input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ Auth::User()->nombre }}" required>

                            @if ($errors->has('nombre'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col-6 col-md-4 ">
                            <label for="apellido">Apellido:</label>
                            <input id="apellido" type="text" class="form-control{{ $errors->has('apellido') ? ' is-invalid' : '' }}" name="apellido" value="{{ Auth::User()->apellido }}" required>

                            @if ($errors->has('apellido'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('apellido') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label for="telefono">Télefono:</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+</div>
                                </div>
                                <input id="telefono" type="text" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{ Auth::User()->telefono }}" required>

                                @if ($errors->has('telefono'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                @endif                            
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">Email:</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Auth::User()->email }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group col-6 col-md-3">
                            <label for="pais">Pais:</label>
                            <input id="pais" type="pais" class="form-control{{ $errors->has('pais') ? ' is-invalid' : '' }}" name="pais" value="{{ Auth::User()->pais }}" disabled>

                            @if ($errors->has('pais'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pais') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-6 col-md-3">
                            <label for="rol">Tipo de Cuenta:</label>
                            <input id="rol" type="rol" class="form-control{{ $errors->has('rol') ? ' is-invalid' : '' }}" name="rol" value="{{ Auth::User()->rol }}" disabled>

                            @if ($errors->has('rol'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('rol') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="form-group col-md-8">
                            <!-- No se que poner acá -->
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-primary btn-block">Guardar Usuario</button>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">Modificar Contraseña</div>

            <div class="card-body">
                
                <form method="POST" action="{{ route('actualizarpassword') }}">
                    @csrf

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="password">Nueva Contraseña:</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col-md-4">
                            <label for="oldpassword">Contraseña Actual:</label>
                            <input id="oldpassword" type="password" class="form-control{{ $errors->has('oldpassword') ? ' is-invalid' : '' }}" name="oldpassword" required>

                            @if ($errors->has('oldpassword'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('oldpassword') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-white">_</label>
                            <button type="submit" class="btn btn-danger btn-block">Guardar Contraseña</button>
                        </div>
                    </div>
                                  
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">Subir Avatar</div>

            <div class="card-body">
                
                <form method="POST" action="{{ route('actualizaravatar') }}" enctype="multipart/form-data">
                    @csrf

                        <div class="form-group">
                            <label for="avatar">Nuevo Avatar:</label>
                            <input id="avatar" type="file" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}" name="avatar" required>

                            @if ($errors->has('avatar'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-dark btn-block">Actualizar Avatar</button>
                        </div>
                                  
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
