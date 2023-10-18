<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){

        if(session('usuario_autenticado')) {
            return redirect()->route('main.index');
        }
        return view("login");
    }
    public function login(Request $request)
    {

        $email=$request->input("email");
        $contrasena=$request->input("contrasena");

        $usuario = Usuario::where('correo', $email)->first();

        //La contraseña esta encriptada con algoritmo bcrypt() usar: php artisan tinker
        if ($usuario && Hash::check($contrasena, $usuario->password)) {//Solo un usuario

            $usuario_sesion=[
                "id"=>$usuario->id,
                "usuario"=>$usuario->usuario //Este usuario lo usaremos para mostrarlo en la cabecera de la web
            ];

            session(['usuario_autenticado' => $usuario_sesion]);
            return redirect()->route('main.index');
        }
        
        return redirect()->route('login.index')->with('mensaje', 'Credenciales Inválidas');
    }
    public function logout()
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }
        // Cerrar la sesión y redirigir al inicio.
        session()->forget('usuario_autenticado');
        return redirect()->route('login.index');
    }
}
