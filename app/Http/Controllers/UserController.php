<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');//Obligatorio para solo acceder si estas logeado
    }

    public function detalle(){
        return view('user.misdatos');
    }

    public function actualizardatos(Request $request){
        //Perfil del usuario actual, solo datos personales y la opción de editar su 
        $user = \Auth::user();

        $request->validate([
            'nombre' => 'string|max:32|required',
            'apellido' => 'string|max:32|required',
            'email' => 'string|max:100|required|email|unique:users,email,'.$user->id,
            'telefono' => 'string|max:32|required',
        ]);

        $user->nombre = $request->input('nombre');
        $user->apellido = $request->input('apellido');
        $user->email = $request->input('email');
        $user->telefono = $request->input('telefono');

        $user->update();
        return redirect()->route('misdatos')->with(['mensaje'=>'Usuario Actualizado.']);
    }

    public function actualizarpassword(Request $request){
        $user = \Auth::user();

        $request->validate([
            'password' => 'required|string|min:8|max:32',
            'oldpassword' => 'required|string|min:8|max:32',
        ]);

        $password = $request->input('password');
        $oldpassword = $request->input('oldpassword');

        if(Hash::check($oldpassword, $user->password)){
            $user->password = Hash::make($password);
            $user->update();
            return redirect()->route('misdatos')->with(['mensaje'=>'Usuario Actualizado.']);
        }
        else{
            return redirect()->route('misdatos')->with(['error'=>'La contraseña actual no coincide.']);
        }

    }

    public function actualizaravatar(Request $request){

        $user = \Auth::user();

        $request->validate([
            'avatar' => 'mimes:jpeg,jpg,png,gif|required',
        ]);

        $avatar = $request->file('avatar');
        $avatarname = 'avatar'.$user->id.'.'.$avatar->getClientOriginalExtension();

        //Almaceno imagen
        Storage::disk('users')->put($avatarname, File::get($avatar));
    
        //Seteo al usuario la imagen
        $user->avatar = $avatarname;
        $user->update();
        return redirect()->route('misdatos')->with(['mensaje'=>'Usuario Actualizado.']);
    }

    public function getAvatar($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    // A partir de acá son los metodos de administracion de usuarios
    public function panelusuarios(){

        
        $paises = array(
            "Afghanistan",
            "Albania",
            "Algeria",
            "Andorra",
            "Angola",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bhutan",
            "Bolivia",
            "Bosnia and Herzegovina",
            "Botswana",
            "Brazil",
            "Brunei",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Cape Verde",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Colombia",
            "Comoros",
            "Congo (Brazzaville)",
            "Congo",
            "Costa Rica",
            "Cote d'Ivoire",
            "Croatia",
            "Cuba",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "East Timor (Timor Timur)",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Ethiopia",
            "Fiji",
            "Finland",
            "France",
            "Gabon",
            "Gambia, The",
            "Georgia",
            "Germany",
            "Ghana",
            "Greece",
            "Grenada",
            "Guatemala",
            "Guinea",
            "Guinea-Bissau",
            "Guyana",
            "Haiti",
            "Honduras",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran",
            "Iraq",
            "Ireland",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Korea, North",
            "Korea, South",
            "Kuwait",
            "Kyrgyzstan",
            "Laos",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Macedonia",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Mauritania",
            "Mauritius",
            "Mexico",
            "Micronesia",
            "Moldova",
            "Monaco",
            "Mongolia",
            "Morocco",
            "Mozambique",
            "Myanmar",
            "Namibia",
            "Nauru",
            "Nepa",
            "Netherlands",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Poland",
            "Portugal",
            "Qatar",
            "Romania",
            "Russia",
            "Rwanda",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Vincent",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Serbia and Montenegro",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Slovakia",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "Spain",
            "Sri Lanka",
            "Sudan",
            "Suriname",
            "Swaziland",
            "Sweden",
            "Switzerland",
            "Syria",
            "Taiwan",
            "Tajikistan",
            "Tanzania",
            "Thailand",
            "Togo",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "United States",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Vatican City",
            "Venezuela",
            "Vietnam",
            "Yemen",
            "Zambia",
            "Zimbabwe"
        );
        return view('usuarios.usuarios', [
            'paises' => $paises
        ]);
    }

    public function buscar(Request $request){

        $paises = array(
            "Afghanistan",
            "Albania",
            "Algeria",
            "Andorra",
            "Angola",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bhutan",
            "Bolivia",
            "Bosnia and Herzegovina",
            "Botswana",
            "Brazil",
            "Brunei",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Cape Verde",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Colombia",
            "Comoros",
            "Congo (Brazzaville)",
            "Congo",
            "Costa Rica",
            "Cote d'Ivoire",
            "Croatia",
            "Cuba",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "East Timor (Timor Timur)",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Ethiopia",
            "Fiji",
            "Finland",
            "France",
            "Gabon",
            "Gambia, The",
            "Georgia",
            "Germany",
            "Ghana",
            "Greece",
            "Grenada",
            "Guatemala",
            "Guinea",
            "Guinea-Bissau",
            "Guyana",
            "Haiti",
            "Honduras",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran",
            "Iraq",
            "Ireland",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Korea, North",
            "Korea, South",
            "Kuwait",
            "Kyrgyzstan",
            "Laos",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Macedonia",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Mauritania",
            "Mauritius",
            "Mexico",
            "Micronesia",
            "Moldova",
            "Monaco",
            "Mongolia",
            "Morocco",
            "Mozambique",
            "Myanmar",
            "Namibia",
            "Nauru",
            "Nepa",
            "Netherlands",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Poland",
            "Portugal",
            "Qatar",
            "Romania",
            "Russia",
            "Rwanda",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Vincent",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Serbia and Montenegro",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Slovakia",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "Spain",
            "Sri Lanka",
            "Sudan",
            "Suriname",
            "Swaziland",
            "Sweden",
            "Switzerland",
            "Syria",
            "Taiwan",
            "Tajikistan",
            "Tanzania",
            "Thailand",
            "Togo",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "United States",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Vatican City",
            "Venezuela",
            "Vietnam",
            "Yemen",
            "Zambia",
            "Zimbabwe"
        );
        
        $query = $request->get('query');
        if($query != ''){
            $usuarios = DB::table('users')
                        ->where('nombre', 'like', '%'.$query.'%')
                        ->orwhere('apellido', 'like', '%'.$query.'%')
                        ->orwhere('email', 'like', '%'.$query.'%')
                        ->orwhere('telefono', 'like', '%'.$query.'%')
                        ->orwhere('pais', 'like', '%'.$query.'%')
                        ->orwhere('rol', 'like', '%'.$query.'%')
                        ->paginate(10);
            $total = DB::table('users')
                        ->where('nombre', 'like', '%'.$query.'%')
                        ->orwhere('apellido', 'like', '%'.$query.'%')
                        ->orwhere('email', 'like', '%'.$query.'%')
                        ->orwhere('telefono', 'like', '%'.$query.'%')
                        ->orwhere('pais', 'like', '%'.$query.'%')
                        ->orwhere('rol', 'like', '%'.$query.'%')
                        ->get();

        }
        else{
            $usuarios = User::paginate(10);//El valor significa cuanto se va a mostrar por página
            $total = User::all();
        }
        return view('usuarios.listado', [
            'usuarios' => $usuarios,
            'total' => $total,
            'paises' => $paises
        ]);
    }

    public function editar($id){
        //Lógica encargada de tomar los datos y adjuntarlos al formulario
        $usuario = User::find($id);
        return response()->json($usuario);
    }

    public function update(Request $request){
        //Validamos los datos del formulario
        $user = User::find($request->id);

        $validate = $request->validate([
            'nombre' => 'string|max:32|required',
            'apellido' => 'string|max:32|required',
            'email' => 'string|max:100|required|email|unique:users,email,'.$user->id,
            'telefono' => 'string|max:32|required',
            'pais' => 'string|max:32|required',
            'rol' => 'string|max:32|required',
        ]); 

        //Consultamos si la validación es efectiva
        if($validate){
            //creamos el nuevo usuario
            
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->email = $request->email;
            $user->telefono = $request->telefono;
            $user->pais = $request->pais;
            $user->rol = $request->rol;
            $user->update();

            //Enviamos la respuesta mediante un json al AJAX
            return response()->json([
                'success'   => true
            ], 200);
        }
        else{
            //JSON con los errores en caso de que no funcione el formulario
            return response()->json([
                'exception' => false,
                'success'   => false,
                'message'   => '$validate->errors' //Se recibe en la sección "error" de tu código JavaScript, y se almacena en la variable "info"
            ], 422);
        }
    }

    public function crear(Request $request){
        //Validamos los datos del formulario
        $validate = $request->validate([
            'nombre' => 'string|max:32|required',
            'apellido' => 'string|max:32|required',
            'email' => 'string|max:100|required|email|unique:users',
            'telefono' => 'string|max:32|required',
            'pais' => 'string|max:32|required',
            'rol' => 'string|max:32|required',
            'password' => 'required|string|min:8|max:32',
        ]); 

        //Consultamos si la validación es efectiva
        if($validate){
            //creamos el nuevo usuario
            User::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'pais' => $request->pais,
                'rol' => $request->rol,
                'password' => Hash::make($request->password),
                'avatar' => 'user.png',
            ]);

            //Enviamos la respuesta mediante un json al AJAX
            return response()->json([
                'success'   => true,
                'message'   => $request->nombre.' '.$request->apellido
            ], 200);
        }
        else{
            //JSON con los errores en caso de que no funcione el formulario
            return response()->json([
                'exception' => false,
                'success'   => false,
                'message'   => '$validate->errors' //Se recibe en la sección "error" de tu código JavaScript, y se almacena en la variable "info"
            ], 422);
        }
    }

    public function borrar(Request $request, $id){
        //Lógica cuando se utiliza la opción de borrar usuario de la base de datos
        if($request->ajax()){
            $usuario = User::find($id);
            $usuario->delete();

            return response()->json([
                'mensaje' => $usuario->nombre.' '.$usuario->apellido.' fué eliminado'
            ]);
        }
    }
}
