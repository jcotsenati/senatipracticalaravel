<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function index(){

        if(session('usuario_autenticado')) {
            return redirect()->route('main');
        }
        return view("login");
    }
    public function login(Request $request)
    {

        $email=$request->input("email");
        $contrasena=$request->input("contrasena");
        
        $usuario = Usuario::where('correo', $email)->where('password', $contrasena)->get();
        if (count($usuario)==1) {//Solo un usuario

            $usuario_sesion=[
                "id"=>$usuario[0]->id,
                "usuario"=>$usuario[0]->usuario //Este usuario lo usaremos para mostrarlo en la cabecera de la web
            ];

            session(['usuario_autenticado' => $usuario_sesion]);
            return redirect()->route('main');
        }
        
        return redirect()->route('login')->with('mensaje', 'Credenciales Inválidas');
    }
    public function logout()
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }
        // Cerrar la sesión y redirigir al inicio.
        session()->forget('usuario_autenticado');
        return redirect()->route('login');
    }
}
