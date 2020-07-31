<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/gif" href="{{ asset('imagenes/favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Estilos CSS-->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="bg-gris">

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="bg-airtech text-white border-right overflow-hidden" id="sidebar-wrapper">
            <div class="mt-5 mb-4 mx-3">
                <div class="row">
                    <div class="col-4 p-0 pl-2" id="avatarnav">
                        <img src="{{ route('avatar', ['filename' => Auth::user()->avatar] ) }}" class="rounded-circle" alt="">
                    </div>
                    <div class="col-8 p-0 pr-2">
                        <span id="nombreuser"> {{ Auth::user()->nombre.' '.Auth::user()->apellido }}</span><br>
                        @if( Auth::user()->rol == 'Developer')
                        <span class="badge badge-danger">{{ Auth::user()->rol }}</span>
                        @else
                        <span class="badge bg-blueairtech">{{ Auth::user()->rol }}</span>
                        @endif
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Salir" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="badge badge-dark"><i class="fas fa-power-off"></i></span></a>
                    </div>
                </div>
            </div>
            <div id="menusidebar" class="list-group list-group-flush">
                <div class="col-12 text-center">
                    <p class="text-white-50" style="font-size: 12px">
                        <span class="badge badge-secondary text-dark">
                        <i class="fas fa-calendar-alt"></i></span> 
                        {{ date('d-m-Y') }}
                    </p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home"></i>Escritorio</a>
                    </li>
                    <span style="border: 1px solid #151a21; opacity: .5" class="my-1 mx-3"></span>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('aeronaves') }}"><i class="fas fa-plane"></i>Aeronaves</a>
                    </li>

                    <!-- Menu solo para Gerentes -->
                    @if(Auth::user()->rol == 'Gerente' || Auth::user()->rol == 'Developer')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agregaraeronave') }}"><i class="fas fa-plus"></i>Añadir Aeronave</a>
                    </li>
                    @endif

                    <!-- Menu solo para Desarrolladores -->
                    @if(Auth::user()->rol == 'Developer')
                    <span style="border: 1px solid #151a21; opacity: .5" class="my-1 mx-3"></span>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('usuarios') }}"><i class="fas fa-list"></i>Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('modelos') }}"><i class="fas fa-list"></i>Modelos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('servicios') }}"><i class="fas fa-list"></i>Servicios</a>
                    </li>
                    @endif
                    
                    <span style="border: 1px solid #151a21; opacity: .5" class="my-1 mx-3"></span>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('misdatos') }}"><i class="fas fa-user"></i>Mis datos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>Salir</a>
                    </li>
                </ul>
                <div class="row my-5">
                    <div class="col-12 text-center">
                        <span class="m-1 badge badge-light"><i class="fas fa-info px-1"></i></span>
                        <span class="m-1 badge badge-primary"><i class="fas fa-envelope"></i></span>
                        <span class="m-1 badge badge-dark"><i class="fas fa-globe-americas"></i></span>
                        <p style="font-size: 12px" class="mt-2">Airtech S.A. &copy; 2019</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand navbar-light bg-light border-bottom">
                <div>
                    <button class="btn bg-airtech text-white" id="menu-toggle"><i class="fas fa-bars"></i></button>
                    <img src="{{ asset('imagenes/LCwajjo7_400x400.png') }}" class="ml-3" height="30px">
                </div>


                <div class=" navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Alejandro Vásquez
                            </a>
                            <div class="dropdown-menu mt-2 dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('misdatos') }}"><i class="fas fa-user mr-2"></i>Mi perfil</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-globe-americas mr-2"></i>Ir a portal</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt mr-2"></i>Salir</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="container-fluid p-4 px-md-5">
                @yield('content')
            </div>
        
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    
    <!--Archivos de JavaScript-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('script')
   
</body>
</html>