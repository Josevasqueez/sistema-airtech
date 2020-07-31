<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reporte;
use App\Orden;

class ReporteController extends Controller
{
    public function __construct(){
        $this->middleware('auth');//Obligatorio para solo acceder si estas logeado
    }

    public function index($id){

        $reportes = Reporte::where('orden_id', $id)->get();
        return view('aeronaves.ordenes.reportes',[
            'reportes' => $reportes,
        ]); 
    }

    public function crear(Request $request){

        Reporte::create([
            'orden_id' => strval($request->orden),
            'servicio_id' => strval($request->servicio),
            'estado' => 'En Proceso',
            'imagen' => 'Ninguna',
        ]);

        //Enviamos la respuesta mediante un json al AJAX
        return response()->json([
            'success'   => true,
            'message'   => 'Llegaron: '.$request->orden.' y '.$request->servicio,
        ], 200);

    }

    public function borrar(Request $request){
    
        $reporte = Reporte::where('id', $request->reporte)->first();
        $reporte->delete();
        
        return response()->json([
            'success' => true,
        ], 200);

    }

    public function actualizar(Request $request){

        $reporte = Reporte::where('id', $request->reporte)->first();
        
        if($reporte->estado == 'En Proceso'){
            $reporte->estado = 'Finalizado';
        }
        else{
            $reporte->estado = 'En Proceso';
        }
        $reporte->update();

        return response()->json([
            'success' => true,
        ], 200);

    }
}
