@extends('layouts.app')

@section('content')

    <!-- Buscador solo para NO-Clientes -->
    @if(Auth::user()->rol != 'Cliente')
    <h4 class="font-weight-bold">Listado de Aeronaves</h4>
    <p>Puedes utilizar el buscador para filtrar las <b>aeronaves</b> por siglas, seriales, cliente, modelo, marca o estado actual.</p>
    <div class="form-group mt-2 mb-4">
        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar Aeronave" url="{{ route('buscaraeronaves', '') }}">
    </div>
    @endif

<div class="row" id="listadodeaeronaves">

    <!-- Aqui llenaré via AJAX proximamente -->
    
</div>

@endsection

@section('script')
<script src="{{ asset('js/aeronaves/aeronaves.js') }}"></script>
@endsection