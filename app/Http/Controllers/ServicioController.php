<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;

class ServicioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');//Obligatorio para solo acceder si estas logeado
    }

    public function index(){

        $servicios = Servicio::all();
        return view('servicios.servicios', [
            'servicios' => $servicios
        ]);
    }

    public function crear(Request $request){
        $request->validate([
            'nombre' => 'string|max:32|required',
            'descripcion' => 'string|max:100|required'
        ]);

        Servicio::create([
            'tipo' => $request->tipo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);
        
        return redirect()->route('servicios')->with(['mensaje'=>'Servicio '.$request->tipo.' de '.$request->nombre.' creado.']);
    }
    
    public function borrar(Request $request, $id){
        //Lógica cuando se utiliza la opción de borrar usuario de la base de datos
        if($request->ajax()){
            $servicio = Servicio::find($id);
            $servicio->delete();

            return response()->json([
                'mensaje' => 'Servicio fué eliminado',
            ]);
        }
    }

    public function editar($id){
        //Lógica encargada de tomar los datos y adjuntarlos al formulario
        $servicio = Servicio::find($id);
        return response()->json($servicio);
    }

    public function guardar(Request $request){
        //Validamos los datos del formulario
        $servicio = Servicio::find($request->id);

        $validate = $request->validate([
            'nombre' => 'string|max:32|required',
            'descripcion' => 'string|max:100|required'
        ]); 

        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->update();
            
        return redirect()->route('servicios')->with(['mensaje'=>'Servicio '.$request->tipo.' de '.$request->nombre.' actualizado.']);
    }
}
