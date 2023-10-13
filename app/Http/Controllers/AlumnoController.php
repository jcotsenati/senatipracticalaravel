<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Database\QueryException;

class AlumnoController extends Controller
{
    public function index()
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }
        
        $alumnos = Alumno::all();
        return view('alumnos.index', compact('alumnos'));
    }
    public function show($id)
    {   
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }

        $alumno = Alumno::findOrFail($id);
        return view('alumnos.show', compact('alumno'));
    }
    public function create()
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }

        return view('alumnos.create');
    }
    public function store(Request $request)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }

        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => 'required',
        ]);
        try{
            Alumno::create($request->all());

            return redirect()->route('alumnos.index');

        }catch(QueryException $e){
            $errorCode = $e->getCode();
           
            if ($errorCode === '23000') {

                //return "El registro tiene un campo duplicado <br>".$e->getMessage();
                return "El registro tiene un campo duplicado";
            }
            else if ($errorCode === '22001') {

                //return "El registro tiene un campo duplicado <br>".$e->getMessage();
                return "El registro tiene un campo mas grande de lo esperado";
            }
            else{
                throw $e;
            }
        }
    }
    public function edit($id)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }

        $alumno = Alumno::findOrFail($id);
        return view('alumnos.edit', compact('alumno'));
    }
    public function update(Request $request, $id)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }

        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => 'required',
        ]);
    
        $alumno = Alumno::findOrFail($id);
        
        try{
            $alumno->update([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
            ]);
        }catch(QueryException $e){
        $errorCode = $e->getCode();
        
        if ($errorCode === '23000') {

            //return "El registro tiene un campo duplicado <br>".$e->getMessage();
            return "El registro tiene un campo duplicado";
        }
        else if ($errorCode === '22001') {

            //return "El registro tiene un campo duplicado <br>".$e->getMessage();
            return "El registro tiene un campo mas grande de lo esperado";
        }
        else{
            throw $e;
        }
    }

        return redirect()->route('alumnos.index');
    }
    public function destroy($id)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login')->with('mensaje', 'Acceso No Autorizado');
        }
        
        $alumno = Alumno::findOrFail($id);
        $alumno->delete();

        return redirect()->route('alumnos.index');
    }
}
