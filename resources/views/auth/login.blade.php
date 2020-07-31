<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tablero</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Estilos CSS-->
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-blueairtech">

    <div id="login"  class="container-fluid d-flex align-items-center justify-content-center">
        <div class="card">
            <div class="card-header">
            Ingresar
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-5 col-form-label">{{ __('E-Mail Address') }}:</label>

                        <div class="col-md-7">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-5 col-form-label">{{ __('Password') }}:
                        </label>

                        <div class="col-md-7">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-12">
                            <p><b><i class="fas fa-info mr-2"></i>Contacta</b> con la empresa para aperturar una cuenta.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    <!--Archivos de JavaScript-->
    <script src="js/app.js"></script>
    <script src="js/script.js"></script>
   
</body>
</html>