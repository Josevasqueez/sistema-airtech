<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelo;

class ModeloController extends Controller
{
    public function __construct(){
        $this->middleware('auth');//Obligatorio para solo acceder si estas logeado
    }

    public function index(){

        $modelos = Modelo::all();
        return view('modelos.modelos', [
            'modelos' => $modelos
        ]);
    }

    public function crear(Request $request){
        $request->validate([
            'modelo' => 'string|max:32|required'
        ]);

        Modelo::create([
            'marca' => $request->marca,
            'modelo' => $request->modelo,
        ]);
        
        return redirect()->route('modelos')->with(['mensaje'=>'Modelo '.$request->marca.' '.$request->modelo.' Creado.']);
    }

    public function borrar(Request $request, $id){
        //Lógica cuando se utiliza la opción de borrar usuario de la base de datos
        if($request->ajax()){
            $modelo = Modelo::find($id);
            $modelo->delete();

            return response()->json([
                'mensaje' => 'Modelo fué eliminado',
            ]);
        }
    }

    public function editar($id){
        //Lógica encargada de tomar los datos y adjuntarlos al formulario
        $modelo = Modelo::find($id);
        return response()->json($modelo);
    }

    public function guardar(Request $request){
        //Validamos los datos del formulario
        $modelo = Modelo::find($request->id);

        $validate = $request->validate([
            'modelo' => 'string|max:32|required',
        ]); 

        $modelo->modelo = $request->modelo;
        $modelo->update();
            
        return redirect()->route('modelos')->with(['mensaje'=>'Modelo '.$request->marca.' '.$request->modelo.' Modificado.']);
    }
}
