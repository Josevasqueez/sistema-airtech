@foreach($aeronaves as $aeronave)
<div class="col-sm-6 col-lg-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between">
            <span><b>Aeronave: </b>{{ $aeronave->siglas}}</span> 
            @if($aeronave->estado == 'En taller')
                <span class="badge badge-danger" style="padding-top: 6px">En Taller</span>
            @else                    
                <span class="badge badge-success" style="padding-top: 6px">Operativa</span>
            @endif
        </div>
        <div class="m-0 p-0 cobertordeimagen bg-dark">
            <a href="{{ route('detalleaeronave', $aeronave->siglas) }}">
                <img src="{{ route('imagenavion', ['filename' => $aeronave->imagen] ) }}" class="" alt="">
            </a>
        </div>
        <div class="card-body justify-content-between">            
            <div class="row">
                <div class="col-sm-6">
                    <b>Marca: </b>{{$aeronave->modelo->marca}}
                </div>
                <div class="col-sm-6">
                    <b>Modelo: </b>{{$aeronave->modelo->modelo}}
                </div>
            </div>
            <b>Seriales: </b>{{$aeronave->seriales}}
            <hr>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-sm btn-light">
                    Cantidad de Servicios <span class="badge badge-light">{{ count($aeronave->ordenes) }}</span>
                </button>
                <a href="{{ route('detalleaeronave', $aeronave->siglas) }}">
                    <button type="button" class="btn btn-sm btn-primary">
                        Ver Más
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

{{ $aeronaves->links() }}