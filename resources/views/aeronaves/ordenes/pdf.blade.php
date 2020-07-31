<html>
<head>
    <!--Estilos CSS-->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
            <div class="card">
                <div class="card-body bg-white">
                    <div class="justify-content-between mb-4">
                        <h3 class="mt-2">
                            <img src="{{ asset('imagenes/LCwajjo7_400x400.png') }}" height="30px">
                            <span class="font-weight-bold">Airtech</span>
                        </h3>
                        <span class="d-inline col-sm-6 text-right">Aeropuerto Caracas, Oscar Machado Zuloaga,<br> Charallave Edo. Miranda.</span>
                    </div>

                    <h6 class="mt-5 text-uppercase">Datos de la Orden</h6>
                    <hr class="my-0">
                    <div>
                        <div class="my-1"><b>Numero de Orden: </b>{{$orden->id}}</div>
                        <div class="my-1"><b>Fecha de Inicio: </b>{{ \Carbon\Carbon::parse($orden->created_at)->format('d/m/Y') }}</div>
                        <div class="my-1"><b>Última Revisión: </b>{{ \Carbon\Carbon::parse($fecha->updated_at)->format('d/m/Y') }}</div>
                        <div class="my-1"><b>Aeronave: </b>{{$orden->aeronave->siglas}}</div>
                        <div class="my-1"><b>Seriales: </b>{{$orden->aeronave->seriales}}</div>
                        <div class="my-1"><b>Modelo: </b>{{$orden->aeronave->modelo->marca.' '.$orden->aeronave->modelo->modelo}}</div>
                        <div class="my-1"><b>Dueño: </b>{{$orden->aeronave->usuario->nombre.' '.$orden->aeronave->usuario->apellido}}</div>
                        <div class="my-1"><b>Teléfono: </b><a href="tel:{{$orden->aeronave->usuario->telefono}}">{{$orden->aeronave->usuario->telefono}}</a></div>
                        <div class="my-1"><b>Email: </b>{{$orden->aeronave->usuario->email}}</div>
                    </div>

                    <h6 class="mt-3 text-uppercase">Información</h6>
                    <hr class="my-0">
                    <div>
                        <div class="my-1"><b>Observaciones: </b>{{ is_null($orden->observaciones) ? 'Ninguna' : $orden->observaciones }}</div>
                        <div class="my-1"><b>Reportes Técnicos: </b>{{count($orden->reportes)}}</div>
                        <div class="my-1"><b>Finalizados: </b>{{count($orden->reportes->where('estado', 'Finalizado'))}}</div>
                        <!-- Verificamos si la cantidad de reportes finalizados es igual a la cantidad de reportes -->
                        @if(count($orden->reportes->where('estado', 'Finalizado')) == count($orden->reportes))
                        <div class="my-1"><b>Estado:</b> <button type="button" class="btn btn-success btn-sm py-0">Finalizado</button></div>
                        @else
                        <div class="my-1"><b>Estado:</b> <button type="button" class="btn btn-warning btn-sm py-0">En Proceso</button></div>
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
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($orden->reportes as $reporte)
                            <tr>
                                <th scope="row">{{$reporte->id}}</th>
                                <td>{{$reporte->servicio->nombre}}</td>
                                <td>{{$reporte->servicio->tipo}}</td>
                                <td><button type="button" class="btn {{ $reporte->estado == 'En Proceso' ? 'btn-light' : 'btn-success' }} btn-sm py-0">{{$reporte->estado}}</button></td>
                                @if($reporte->estado == 'En Proceso')
                                <td>-</td>
                                @else
                                <td>{{ \Carbon\Carbon::parse($reporte->updated_at)->format('d/m/Y') }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
</body>
</html>