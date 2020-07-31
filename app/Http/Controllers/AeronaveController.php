<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Aeronave;
use App\Modelo;
use App\User;


use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

class AeronaveController extends Controller
{
    public function __construct(){
        $this->middleware('auth');//Obligatorio para solo acceder si estas logeado
    }

    public function index(){

        // Retornamos la vista con las aeronaves
        return view('aeronaves.aeronaves');
    }

    public function detalle($siglas){
        // Realizamos la busqueda de la aeronave
        $aeronave = Aeronave::where('siglas', 'like', $siglas)->first();

        if($aeronave == Null){
            return redirect()->route('aeronaves');
        }

        return view('aeronaves.detalle', [
            'aeronave' => $aeronave
        ]);
        // Retornamos los datos de la aeronave a la vista de los Detalles para poder visualizar todo el contenido de la misma
    }

    public function buscar(Request $request){
        $query = $request->get('query');
        $user = \Auth::user();

        // Si es cliente solo puede ver sus aeronaves
        if($user->rol == 'Cliente'){
            $aeronaves = Aeronave::where('id_users', $user->id)->orderBy('id', 'desc')->paginate(9);
        }
        else{
            // En caso contrario puede acceder al buscador
            if($query != ''){
                $aeronaves = Aeronave::select(['aeronaves.*'])
                                    ->join('users', 'users.id', '=', 'aeronaves.id_users')
                                    ->join('modelos', 'modelos.id', '=', 'aeronaves.id_modelos')
                                    ->where('siglas', 'like', '%'.$query.'%')
                                    ->orwhere('seriales', 'like', '%'.$query.'%')
                                    ->orwhere('estado', 'like', '%'.$query.'%')
                                    ->orwhere('users.nombre', 'like', '%'.$query.'%')
                                    ->orwhere('users.apellido', 'like', '%'.$query.'%')
                                    ->orwhere('modelos.marca', 'like', '%'.$query.'%')
                                    ->orwhere('modelos.modelo', 'like', '%'.$query.'%')
                                    ->orderBy('id', 'desc')->paginate(9);
            }
            else{
                $aeronaves = Aeronave::orderBy('id', 'desc')->paginate(9);
            }
        }

        // Retornamos la vista de la aeronave para que el metodo AJAX ubicado en el archivo JS de Aeronaves pueda imprimir en pantalla.
        return view('aeronaves.listado', [
            'aeronaves' => $aeronaves
        ]);
    }

    public function nueva(){

        // Extraemos todos los datos en la base de datos para pasarlo a la vista
        $aeronaves = Aeronave::orderBy('id', 'DESC')->take(3)->get();
        $clientes = User::where('rol', 'Cliente')->orderBy('nombre', 'ASC')->get();
        $modelos = Modelo::all();

        return view('aeronaves.agregar', [
            'aeronaves' => $aeronaves,
            'clientes' => $clientes,
            'modelos' => $modelos
        ]);
    }

    public function crear(Request $request){

        $request->validate([
            'modelo' => 'required',
            'seriales' => 'string|max:50|required|unique:aeronaves',
            'siglas' => 'string|max:50|required|unique:aeronaves',
            'cliente' => 'required',
            'estado' => 'string|min:1|max:50|required'
        ]);

        // Revisamos si fue añadida una imagen, sino usaremos la imagen predeterminada
        if(!empty($request->imagen)){

            $request->validate([
                'imagen' => 'mimes:jpeg,jpg,png,gif|required',
            ]);

            // Recojo datos y lo asigno a la variable debidamente necesaria
            $imagen = $request->file('imagen');
            $nombreimagen = $request->siglas.'.'.$imagen->getClientOriginalExtension();

            //Almaceno imagen
            Storage::disk('aviones')->put($nombreimagen, File::get($imagen));
        
        }
        else{
            $nombreimagen = 'avion.jpg';
        }

        Aeronave::create([
            'id_modelos' => strval($request->modelo),
            'seriales' => $request->seriales,
            'siglas' => $request->siglas,
            'id_users' => strval($request->cliente),
            'estado' => $request->estado,
            'imagen' => $nombreimagen
        ]);
        
        return redirect()->route('agregaraeronave')->with(['mensaje'=>'Aeronave '.$request->siglas.' añadida.']);

    }

    public function getImagen($filename){
        // Basicamente extraemos las imagenes y ya
        $file = Storage::disk('aviones')->get($filename);
        return new Response($file, 200);
    }

    public function CambiarEstado($id){

        $Aeronave = Aeronave::where('id', $id)->first();
        
        if($Aeronave->estado == 'En taller'){
            $Aeronave->estado = 'Operativa';
        }
        else{
            $Aeronave->estado = 'En taller';
        }
        $Aeronave->update();

        
        return redirect()->route('detalleaeronave', $Aeronave->siglas);
    
    }
}
