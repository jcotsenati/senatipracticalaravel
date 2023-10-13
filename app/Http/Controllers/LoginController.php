<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        if ($email=="jorge@gmail.com" && $contrasena=="jorge") {
            session(['usuario_autenticado' => true]);
            return redirect()->route('main');
        }
        
        return redirect()->route('login')->with('mensaje', 'Credenciales Inválidas');
    }
    public function logout()
    {
        // Cerrar la sesión y redirigir al inicio.
        session()->forget('usuario_autenticado');
        return redirect()->route('login');
    }
}
