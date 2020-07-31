<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orden;
use App\Servicio;
use App\Reporte;

class OrdenController extends Controller
{
    public function __construct(){
        $this->middleware('auth');//Obligatorio para solo acceder si estas logeado
    }

    public function index($id){
        $orden = Orden::where('id', $id)->first();
        $servicios = Servicio::orderBy('tipo', 'ASC')->get();
        
        $fechamod = Reporte::where('orden_id', $id)->orderBy('updated_at', 'DESC')->first();
        return view('aeronaves.ordenes.detalle', [
            'orden' => $orden,
            'fecha' => $fechamod,
            'servicios' => $servicios
        ]);
    }

    public function crear(Request $request){

        Orden::create([
            'observaciones' => $request->observacion,
            'aeronave_id' => $request->aeronaveid,
        ]);

        // En esta variable almacenamos la ID de la ultima orden creada para la aeronave, es decir, la que acabamos de crear
        // Estoy seguro que se puede optimizar, pero mientras funcione y sea entendible, mejor dejarlo jajaja
        $id = Orden::where('aeronave_id', $request->aeronaveid)->orderBy('id', 'DESC')->value('id');

        return redirect()->route('OrdenDeTrabajo', $id);

    }

    public function pdf($id){
        // Buscaba una consulta para sacar cual orden de trabajo era la de el reporte
        $orden = Orden::where('id', $id)->first();
        // Luego tomaba la fecha de la ultima actualización que hacia la orden, en este caso mi orden se valía de Reportes, asi que el ultimo reporte en ser modificado
        $fecha = Reporte::where('orden_id', $id)->orderBy('updated_at', 'DESC')->first();
        // Llamaba a un PDF con los datos TAL COMO SI FUESE A ENVIAR UNA VISTA, con Orden y Fecha que saque anteriormente, y luego lo almacenaba en una var $pdf
        $pdf = \PDF::loadView('aeronaves.ordenes.pdf', compact(['orden', 'fecha']));
        // Retornaba el PDF como una descarga, asi no se actualizaba la página y el reporte quedaba en mi pc, queda mejor ponerlo en una pestaña nueva pero me pase de ñero.
        return $pdf->download($orden->aeronave->siglas.' - Orden #'.$id.'.pdf');
    }
}
