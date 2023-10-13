<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){

        if(session('usuario_autenticado')) {
            
            return view('main');
        }

        return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
    }
}
