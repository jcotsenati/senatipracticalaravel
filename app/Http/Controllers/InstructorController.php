<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Database\QueryException;

class InstructorController extends Controller
{
    public function index()
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }
        
        $instructores = Instructor::all();
        return view('instructores.index', compact('instructores'));
    }
    public function update(Request $request, $id)
    {
        if(!session('usuario_autenticado')){
            return redirect()->route('login.index')->with('mensaje', 'Acceso No Autorizado');
        }

        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'dni' => 'required',
        ]);
        
    
        $instructor = Instructor::findOrFail($id);
        
        try{
            $instructor->update([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
            ]);

            return redirect()->route('instructores.index')->with('mensaje', 'Operacion Satisfactoria !!!');

        }catch(QueryException $e){

            $errorCode = $e->getCode();
            
            $mensaje="";
            if ($errorCode === '23000') {

                $mensaje='El registro tiene un campo duplicado';
            }
            else if ($errorCode === '22001') {

                $mensaje='El registro tiene un campo mas grande de lo esperado';
            }
            else{

                $mensaje='No se puede crear el registro';
            }

            $instructor=[
                'id'=>$id,
                'dni'=>$request->dni,
                'nombres'=>$request->nombres,
                'apellidos'=>$request->apellidos
            ];
            $instructor=(object)$instructor;
            
            return redirect()->route('instructores.index')->with('mensaje', $mensaje);
            
        }
    
    }
}
