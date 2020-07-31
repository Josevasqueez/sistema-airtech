@if(sizeof($reportes) > 0)
    @foreach($reportes as $reporte)
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
        <td class="d-flex py-2">

            <form action="{{ route('ActualizarReporte') }}" method="POST">
                @csrf
                <input type="number" id="reporte" name="reporte" value="{{ $reporte->id }}" class="d-none">
                @if($reporte->estado == 'En Proceso')
                <button type="submit" class="btn btn-success btn-sm botonactualizar"><i class="fas fa-check"></i></button>
                @else
                <button type="submit" class="btn btn-primary btn-sm botonactualizar"><i class="fas fa-undo-alt"></i></button>
                @endif
            </form>

            @if(Auth::user()->rol == 'Developer')
            <form action="{{ route('BorrarReporte') }}" method="POST" class="ml-2">
                @csrf
                <input type="number" id="reporte" name="reporte" value="{{ $reporte->id }}" class="d-none">
                <button type="submit" class="btn btn-danger btn-sm botonactualizar"><i class="fas fa-trash"></i></button>
            </form>
            @endif
        </td>
    </tr>
    @endforeach
@else
<tr>
    <td colspan="5" class="text-center">No hay datos</td>
</tr>
@endif